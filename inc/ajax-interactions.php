<?php 
// Ajax for the Resources / Posts System
function ajaxGetResources()
{
    $page = $_POST['page'];
    $searchTerm = $_POST['searchTerm'];
    $categories = $_POST['categories'];
    $types = $_POST['types'];
    $tags = $_POST['tags'];

    $defaultThumbArray = [];

    if(have_rows('perspectives_thumbnails', 'option'))
    {
        while(have_rows('perspectives_thumbnails', 'option'))
        {
            the_row();

            $defaultThumbArray[] = get_sub_field('thumbnail');
        }
    }

    $postsPerPage = 6;

    $taxArray = [];

    $resourceArgs = array(
        'post_type' => 'post',
        'paged' => $page,
        'posts_per_page' => $postsPerPage,
        'post_status' => 'publish',
        'meta_query' => array(
            array( 
                'key' => 'hide_on_perspectives',
                'value' => '1',
                'compare' => '!='
            )
        )
    );

    if ($searchTerm != '') {
        $resourceArgs['s'] = $searchTerm;
    }

    if(isset($categories) && !empty($categories))
    {
        $taxArray[] = [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $categories,
            'operator' => 'IN',
        ];
    }

    if(isset($tags) && !empty($tags))
    {
        $resourceArgs['tag__in'] = $tags;
    }

    if(isset($types) && !empty($types))
    {
        $taxArray[] = [
            'taxonomy' => 'types',
            'field' => 'term_id',
            'terms' => $types,
            'operator' => 'IN',
        ];
    }

    if(!empty($taxArray))
    {
        $resourceArgs['tax_query'] = [
            'relation' => 'AND',
            $taxArray
        ];
    }

    $blogQuery = new WP_Query($resourceArgs);

    if ($blogQuery->have_posts()) {
        $lastUsedThumbnail = '';
        
        while ($blogQuery->have_posts()) {
            $blogQuery->the_post();

            $title = get_the_title();
            $title = trimStringToFullWord(84, $title);
            $tags = get_the_tags();
            $thumb = get_the_post_thumbnail_url();
            $thumbStyle = '';
            $tagHTML = '';


            if (isset($thumb) && $thumb != '') {
                $thumbStyle = 'style="background-image: url(' . $thumb . ')"';
            }
            else 
            {
                // Randomly select a default thumbnail from the array
                if (!empty($defaultThumbArray)) {
                    do {
                        $randomKey = array_rand($defaultThumbArray);
                        $randomThumbnail = $defaultThumbArray[$randomKey];
                    } while ($randomThumbnail == $lastUsedThumbnail && count($defaultThumbArray) > 1);

                    $thumbStyle = 'style="background-image: url(' . $randomThumbnail . ')"';
                    // Update the last used thumbnail
                    $lastUsedThumbnail = $randomThumbnail;
                }
            }

            if (isset($tags) && !empty($tags)) {
                $tagCounter = 0;
                $tagHTML = '<ul class="tag-list">';

                foreach ($tags as $tag) {
                    $tagCounter++;

                    if ($tagCounter < 5) {
                        $tagHTML .= '<li><a href="#" class="feed-tag" data-id="' . $tag->term_id . '">' . $tag->name . '</a></li>';
                    } elseif ($tagCounter == 5) {
                        $tagHTML .= '<li><a href="#">+</a></li>';
                    }
                }

                $tagHTML .= '</ul>';
            }

            $articleLink = get_the_permalink();
            $articleLinkTarget = 'target="_self"';

            echo '
			<div class="blog-result">
                <a href="'.$articleLink.'" class="article-link" '.$articleLinkTarget.'>
                    <div class="result-thumb" '.$thumbStyle.'></div>
                    <div class="title-wrapper result-title">
                        '.$title.'
                    </div>
                </a>                                    
                <div class="tags-wrapper">'.$tagHTML.'</div>
            </div>';
        }
    } else {
        echo '<h3 class="no-results">No Results Found!</h3>';
    }

    die();
}
add_action('wp_ajax_ajaxGetResources', 'ajaxGetResources');
add_action('wp_ajax_nopriv_ajaxGetResources', 'ajaxGetResources');

// Ajax that allows users to share Blog Posts
function ajaxSharePost()
{
    $postTitle = $_POST['post-title'];
    $postLink = $_POST['post-url'];
    $recipientName = $_POST['recipient-name'];
    $recipientEmail = $_POST['recipient-email'];
    $specialMessage = $_POST['special-message'];

    $siteName = get_bloginfo('name');

    $subject = 'Check out this article from ' . $siteName;

    $message = 'Hi ' . $recipientName . ',<br><br>Check out the resource from ' . $siteName . ':<br><br><a href="' . $postLink . '">' . $postTitle . '</a>';

    if (isset($specialMessage) && $specialMessage != '') {
        $message .= '<br><br>' . $specialMessage;
    }

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $header = 'From: ' . $siteName . ' <noreply@greatgray.com>' . "\r\n";

    $sendEmail = wp_mail($recipientEmail, $subject, $message, $headers);

    if ($sendEmail) {
        echo 'success';
    } else {
        echo 'error';
    }

    die();
}
add_action('wp_ajax_ajaxSharePost', 'ajaxSharePost');
add_action('wp_ajax_nopriv_ajaxSharePost', 'ajaxSharePost');

// Fund Family Search Form Links Ajax
function ajaxFundSearch()
{
    $searchTerm = trim($_POST['searchTerm']);
    $categories = $_POST['categories'];
    $applyCategoryFilter = false;

    $availableFamilies = [];

    if(isset($categories) && !empty($categories))
    {
        $applyCategoryFilter = true;

        $fundArgs = array(
            'post_type' => 'funds',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'fund_categories',
                    'field' => 'term_id',
                    'terms' => $categories,
                    'operator' => 'IN',
                ],
            ],
            'fields' => 'ids',
        );

        $fundPosts = new WP_Query($fundArgs);

        $returnedFunds = $fundPosts->posts;

        if(isset($returnedFunds) && !empty($returnedFunds))
        {
            foreach($returnedFunds as $fundID)
            {
                $fundFamilies = get_the_terms($fundID, 'family');

                if(isset($fundFamilies) && !empty($fundFamilies))
                {
                    foreach($fundFamilies as $fundFamily)
                    {
                        $familyID = $fundFamily->term_id;

                        if(!in_array($familyID, $availableFamilies))
                        {
                            $availableFamilies[] = $familyID;
                        }
                    }
                }
            }
        }
    }

    if(isset($searchTerm) && $searchTerm != '') 
    {
        $numResults = 0;

        $args = array(
            'taxonomy' => 'family',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC',
            'fields' => 'all',
            'name__like' => $searchTerm,
        );

        $families = get_terms($args);

        $tickerArgs = array(
            'post_type' => 'funds',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'nasdaq_ticker',
                    'value'   => ('^'.$searchTerm.'$'),
                    'compare' => 'REGEXP'
                ),
                array(
                    'key' => 'cusip',
                    'value'   => ('^'.$searchTerm.'$'),
                    'compare' => 'REGEXP'
                )
            ),
            'fields' => 'ids'
        );

        $tickCuspText = '';

        $tickerQuery = new WP_Query($tickerArgs);

        $tickerPosts = $tickerQuery->posts;

        $tickerFamilies = [];

        $tickerChildFamilies = [];

        if(isset($tickerPosts) && !empty($tickerPosts))
        {
            $tickCuspText = $searchTerm;

            foreach($tickerPosts as $postID)
            {
                $fundFamilies = get_the_terms($postID, 'family');

                if(isset($fundFamilies) && !empty($fundFamilies))
                {
                    foreach($fundFamilies as $fundFamily)
                    {
                        $tickerFamilies[] = $fundFamily;

                        if($fundFamily->parent != 0)
                        {
                            $tickerChildFamilies[] = $fundFamily->term_id;
                        }
                    }
                }
            }
        }

        if(!empty($tickerFamilies))
        {
            $families = array_merge($families, $tickerFamilies);
        }

        if (!empty($families)) {
            foreach ($families as $family) {
                $parentTermID = $family->parent;
                $termID = $family->term_id;
                
                $tickCuspDisplay = '';

                if(isset($tickCuspText) && $tickCuspText != '')
                {
                    if(isset($tickerChildFamilies) && !empty($tickerChildFamilies))
                    {
                        if(in_array($termID, $tickerChildFamilies))
                        {
                            $tickCuspDisplay = '<span class="ticker-cusip">'.$tickCuspText.'</span>';
                        }
                    }
                }

                if ($parentTermID == 0) {
                    $parentTermID = $termID;
                }

                if($applyCategoryFilter == true)
                {
                    if(in_array($termID, $availableFamilies))
                    {
                        $numResults++;
                        echo '<a href="#" data-parent="' . $parentTermID . '" data-id="' . $termID . '" class="fund-result"><span class="result-name">' . $family->name . ' '.$tickCuspDisplay.'</span></a>';
                    }
                    
                }
                else 
                {
                    $numResults++;
                    echo '<a href="#" data-parent="' . $parentTermID . '" data-id="' . $termID . '" class="fund-result"><span class="result-name">' . $family->name . ' '.$tickCuspDisplay.'</span></a>';
                }
            }

            if($numResults == 0)
            {
                echo 'no results';
            }

        } else {
            echo 'no results';
        }
    } else {
        echo 'no results';
    }

    die();
}
add_action('wp_ajax_ajaxFundSearch', 'ajaxFundSearch');
add_action('wp_ajax_nopriv_ajaxFundSearch', 'ajaxFundSearch');

// Ajax to populate Fund Family Table
function ajaxGetFundTable()
{
    $parentID = $_POST['parentID'];
    $hasResults = false;

    if (isset($parentID) && $parentID != '') {
        $familyArray = [$parentID];

        $fundsArray = [];
        $fundsCounter = 0;

        $unitArray = [];
        $unitCounter = 0;

        $childFamilies = get_terms(array(
            'taxonomy' => 'family',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC',
            'fields' => 'all',
            'parent' => $parentID,
        ));

        if (!empty($childFamilies)) {
            $hasResults = true;

            foreach ($childFamilies as $childFamily) {
                array_push($familyArray, $childFamily->term_id);
            }
        }

        $fundPostArgs = array(
            'post_type' => 'funds',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'unit_value',
                    'value' => '0',
                    'compare' => '=',
                ),
                array(
                    'key' => 'unit_value',
                    'compare' => 'NOT EXISTS',
                ),
                array(
                    'key' => 'unit_value',
                    'value' => '',
                    'compare' => '=',
                ),
            ),
            'tax_query' => [
                [
                    'taxonomy' => 'family',
                    'field' => 'term_id',
                    'terms' => $familyArray,
                    'operator' => 'IN',
                ],
            ],
            'meta_key' => 'class_name',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );

        $fundPosts = new WP_Query($fundPostArgs);

        if ($fundPosts->have_posts()) {
            while ($fundPosts->have_posts()) {
                $fundPosts->the_post();

                $fundID = get_the_ID();
                $fundFamilies = get_the_terms($fundID, 'family');
                $className = get_field('class_name');
                $documentID = get_field('document_id');
                //$ticker = get_field('nasdaq_ticker');

                $familiesArray = [];

                if (isset($fundFamilies) && !empty($fundFamilies)) {
                    foreach ($fundFamilies as $fundFamily) {
                        $familiesArray[] = $fundFamily->term_id;
                    }
                }

                $fundsArray[$fundsCounter]['families'] = $familiesArray;
                $fundsArray[$fundsCounter]['document_id'] = $documentID;
                $fundsArray[$fundsCounter]['class_name'] = $className;
                //$fundsArray[$fundsCounter]['ticker'] = $ticker;

                $fundsCounter++;
            }
        }

        $unitValueArgs = array(
            'post_type' => 'funds',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key' => 'unit_value',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
            'tax_query' => [
                [
                    'taxonomy' => 'family',
                    'field' => 'term_id',
                    'terms' => $familyArray,
                    'operator' => 'IN',
                ],
            ],
            'meta_key' => 'class_name',
            'orderby' => 'meta_value',
            'order' => 'ASC',
        );

        $unitValuePosts = new WP_Query($unitValueArgs);

        if ($unitValuePosts->have_posts()) {
            while ($unitValuePosts->have_posts()) {
                $unitValuePosts->the_post();

                $unitID = get_the_ID();
                $unitFamilies = get_the_terms($unitID, 'family');
                $className = get_field('class_name');
                $documentID = get_field('document_id');
                //$ticker = get_field('nasdaq_ticker');

                $familiesArray = [];

                if (isset($unitFamilies) && !empty($unitFamilies)) {
                    foreach ($unitFamilies as $unitFamily) {
                        $familiesArray[] = $unitFamily->term_id;
                    }
                }

                $unitArray[$unitCounter]['families'] = $familiesArray;
                $unitArray[$unitCounter]['document_id'] = $documentID;
                $unitArray[$unitCounter]['class_name'] = $className;
                //$unitArray[$unitCounter]['ticker'] = $ticker;

                $unitCounter++;
            }
        }

        foreach ($childFamilies as $childFamily) {
            $childFundID = $childFamily->term_id;
            $childFundName = $childFamily->name;

            echo '
			<div class="child-fund-row" data-id="' . $childFundID . '">
				<div class="child-fund-cell">
					' . $childFundName . '
				</div>
			';

            if (!empty($unitArray)) {
                foreach ($unitArray as $key => $unitValue) {
                    if (in_array($childFundID, $unitValue['families'])) {
                        $documentID = $unitValue['document_id'];
                        $className = $unitValue['class_name'];
                        /*
                        $ticker = $unitValue['ticker'];

                        $tickerHTML = '';

                        if(isset($ticker) && $ticker != '')
                        {
                            $tickerHTML = '<span class="ticker-text">'.$ticker.'</span>';
                        }
                        */

                        echo '
						<div class="child-fund-cell">
							<a target="_blank" href="/cit-fund-info/collective-funds-fact-sheets/portfolio-unit-values?id=' . $documentID . '">Unit Value</a>
						</div>
						';

                        unset($unitArray[$key]);
                    }
                }
            }

            if (!empty($fundsArray)) {
                foreach ($fundsArray as $key => $fund) {
                    if (in_array($childFundID, $fund['families'])) {
                        $documentID = $fund['document_id'];
                        $className = $fund['class_name'];

                        /*
                        $ticker = $fund['ticker'];

                        $tickerHTML = '';

                        if(isset($ticker) && $ticker != '')
                        {
                            $tickerHTML = '<span class="ticker-text">'.$ticker.'</span>';
                        }
                        */
                        echo '
						<div class="child-fund-cell">
							<a target="_blank" href="https://doc.morningstar.com/LatestDoc.aspx?clientid=greatgray&key=1cd9aa63b2372cae&documenttype=124&sourceid=260&secid=' . $documentID . '">' . $className .'</a>
						</div>
						';

                        unset($fundsArray[$key]);
                    }
                }
            }

            echo '
			</div>
			';
        }

        if ((empty($childFamilies)) && (!empty($unitArray) || !empty($fundsArray))) {
            $parentFundName = get_term($parentID)->name;

            echo '
			<div class="child-fund-row">
				<div class="child-fund-cell">
					' . $parentFundName . '
				</div>
			';

            if (!empty($unitArray)) {
                $hasResults = true;

                foreach ($unitArray as $unitValue) {
                    $documentID = $unitValue['document_id'];
                    $className = $unitValue['class_name'];
                    /*
                    $ticker = $unitValue['ticker'];
                    $tickerHTML = '';

                    if(isset($ticker) && $ticker != '')
                    {
                        $tickerHTML = '<span class="ticker-text">'.$ticker.'</span>';
                    }
                    */
                    echo '
					<div class="child-fund-cell">
						<a target="_blank" href="/cit-fund-info/collective-funds-fact-sheets/portfolio-unit-values?id=' . $documentID . '">Unit Value</a>
					</div>
					';
                }
            }

            if (!empty($fundsArray)) {
                $hasResults = true;

                foreach ($fundsArray as $fund) {
                    $documentID = $fund['document_id'];
                    $className = $fund['class_name'];
                    /*
                    $ticker = $fund['ticker'];

                    $tickerHTML = '';

                    if(isset($ticker) && $ticker != '')
                    {
                        $tickerHTML = '<span class="ticker-text">'.$ticker.'</span>';
                    }

                    */

                    echo '
					<div class="child-fund-cell">
						<a target="_blank" href="https://doc.morningstar.com/LatestDoc.aspx?clientid=greatgray&key=1cd9aa63b2372cae&documenttype=124&sourceid=260&secid=' . $documentID . '">' . $className .'</a>
					</div>
					';
                }
            }

            echo '</div>';
        }

        if ($hasResults == false) {
            echo 'no results';
        }
    } else {
        echo 'no results';
    }

    die();
}
add_action('wp_ajax_ajaxGetFundTable', 'ajaxGetFundTable');
add_action('wp_ajax_nopriv_ajaxGetFundTable', 'ajaxGetFundTable');

function ajaxRebuildFunds()
{
    $categories = $_POST['fund_categories'];

    $parentFundsArray = array();
    $parentFundsCounter = 0;

    $familyArray = [];

    $alphabetArray = range('A', 'Z');
    $availableLetters = [];

    $returnedData = [];
    $alphabetHTML = '';
    $resultsHTML = '';
    $parentsHTML = '';

    if(isset($categories) && !empty($categories))
    {
        $fundArgs = array(
            'post_type' => 'funds',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'fund_categories',
                    'field' => 'term_id',
                    'terms' => $categories,
                    'operator' => 'IN',
                ],
            ],
            'fields' => 'ids',
        );

        $fundPosts = new WP_Query($fundArgs);

        $returnedFunds = $fundPosts->posts;

        if(isset($returnedFunds) && !empty($returnedFunds))
        {
            foreach($returnedFunds as $fundID)
            {
                $fundFamilies = get_the_terms($fundID, 'family');

                if(isset($fundFamilies) && !empty($fundFamilies))
                {
                    foreach($fundFamilies as $fundFamily)
                    {
                        $familyParent = $fundFamily->parent;

                        if($familyParent == 0)
                        {
                            if(!in_array($fundFamily->term_id, $familyArray))
                            {
                                $familyArray[] = $fundFamily->term_id;

                                $categoryName = $fundFamily->name;
                                $categoryID = $fundFamily->term_id;
                                $categoryParent = $fundFamily->parent;

                                $firstLetter = substr($categoryName, 0, 1);

                                if(!in_array($firstLetter, $availableLetters))
                                {
                                    $availableLetters[] = $firstLetter;
                                }

                                $parentFundsArray[$parentFundsCounter]['name'] = $categoryName;
                                $parentFundsArray[$parentFundsCounter]['id'] = $categoryID;

                                $parentFundsCounter++;
                            }
                        }
                        else 
                        {
                            if(!in_array($familyParent, $familyArray))
                            {
                                $familyArray[] = $familyParent;

                                $fundParent = get_term($familyParent, 'family');

                                $categoryName = $fundParent->name;
                                $categoryID = $fundParent->term_id;

                                $firstLetter = substr($categoryName, 0, 1);

                                if(!in_array($firstLetter, $availableLetters))
                                {
                                    $availableLetters[] = $firstLetter;
                                }

                                $parentFundsArray[$parentFundsCounter]['name'] = $categoryName;
                                $parentFundsArray[$parentFundsCounter]['id'] = $categoryID;
                                $parentFundsCounter++;
                            }

                            if(!in_array($fundFamily->term_id, $familyArray))
                            {
                                $familyArray[] = $fundFamily->term_id;
                            }
                        }
                    }
                }

            }
        }
    }
    else 
    {
        $allFamilies = get_terms(array(
            'taxonomy' => 'family',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC'
        ));
    
        if(isset($allFamilies) && !empty($allFamilies))
        {
            foreach($allFamilies as $family)
            {
                $categoryName = $family->name;
                $categoryID = $family->term_id;
                $categoryParent = $family->parent;
    
                $firstLetter = substr($categoryName, 0, 1);
    
                if(!in_array($firstLetter, $availableLetters))
                {
                    $availableLetters[] = $firstLetter;
                }
    
                if($categoryParent == 0)
                {
                    $parentFundsArray[$parentFundsCounter]['name'] = $categoryName;
                    $parentFundsArray[$parentFundsCounter]['id'] = $categoryID;
    
                    $parentFundsCounter++;
                }

                if(!in_array($categoryID, $familyArray))
                {
                    $familyArray[] = $categoryID;
                }
            }
        }
    }

    /* Generate Search Results Families */
    if(!empty($familyArray))
    {
        $familyDisplayArray = [];
        $familyDisplayCounter = 0;

        foreach($familyArray as $familyID)
        {
            $family = get_term($familyID);

            $familyName = $family->name;
            $familyParent = $family->parent;
            $parentID = $family->term_id;

            if(isset($familyParent) && $familyParent != 0)
            {
                $parentID = $familyParent;
            }

            $familyDisplayArray[$familyDisplayCounter]['name'] = $familyName;
            $familyDisplayArray[$familyDisplayCounter]['id'] = $family->term_id;
            $familyDisplayArray[$familyDisplayCounter]['parent'] = $parentID;

            $familyDisplayCounter++;
        }

        usort($familyDisplayArray, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        if(isset($familyDisplayArray) && !empty($familyDisplayArray))
        {
            foreach($familyDisplayArray as $familyItem)
            {
                $familyName = $familyItem['name'];
                $familyID = $familyItem['id'];
                $familyParent = $familyItem['parent'];

               $resultsHTML .= '
                <a href="#" data-parent="' . $familyParent . '" data-id="' . $familyID . '" class="fund-result">
                    <span class="result-name">' . $familyName . '</span>
                </a>
                ';
            }
        }
    }

    /* Generate Alphabet Data */
    $alphabetHTML .= '<div class="alphabet-carousel swiper"><div class="swiper-wrapper">';
    foreach($alphabetArray as $letter)
    {
        $letterClass = 'has-letter';

        if(!in_array($letter, $availableLetters))
        {
            $letterClass = 'no-letter';
        }
        $alphabetHTML .= '<div class="swiper-slide"><a class="letter-link '.$letterClass.'" href="#letter-'.$letter.'">'.$letter.'</a></div>';
    }
    $alphabetHTML .= '</div></div>';

    /* Generate Parent Fund Data */
    if(isset($parentFundsArray) && !empty($parentFundsArray))
    {
        usort($parentFundsArray, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        foreach($parentFundsArray as $parentFund)
        {
            $parentFundName = $parentFund['name'];
            $parentFundID = $parentFund['id'];
            $firstLetter = substr($parentFundName, 0, 1);

            $parentsHTML .= '<div class="parent-fund-wrapper" data-id="'.$parentFundID.'">';

            foreach($alphabetArray as $key => $letter)
            {
                if(strtolower($firstLetter) == strtolower($letter))
                {
                    $letterIndex = $key;

                    $parentsHTML .=  '<div class="fund-letter-location" id="letter-'.$letter.'"></div>';

                    unset($alphabetArray[$key]);
                }
            }

            $parentsHTML .=  '
            <a class="parent-fund-link"> 
                '.$parentFundName.'
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                        <path d="M1 13L7 7L1 1" stroke="#2F3942"/>
                    </svg>
                </span>
            </a>
            <div class="child-fund-table"></div>
            ';

            $parentsHTML .=  '</div>'; // parent fund wrapper
        }
    }

    $returnedData[0] = $resultsHTML;
    $returnedData[1] = $alphabetHTML;
    $returnedData[2] = $parentsHTML;

    echo json_encode($returnedData);

    exit();
}
add_action('wp_ajax_ajaxRebuildFunds', 'ajaxRebuildFunds');
add_action('wp_ajax_nopriv_ajaxRebuildFunds', 'ajaxRebuildFunds');