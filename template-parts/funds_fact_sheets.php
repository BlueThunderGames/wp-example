<?php 

    $searchPlaceholder = get_sub_field('search_placeholder');
    $parentFundsArray = array();
    $parentFundsCounter = 0;
    $fundFamilyOverride = get_sub_field('fund_family_override');

    $childFundsArray = array();
    $childFundsCounter = 0;

    $alphabetArray = range('A', 'Z');
    $availableLetters = [];

    if(!isset($fundFamilyOverride) || empty($fundFamilyOverride))
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
                else 
                {
                    $childFundsArray[$childFundsCounter]['name'] = $categoryName;
                    $childFundsArray[$childFundsCounter]['id'] = $categoryID;
                    $childFundsArray[$childFundsCounter]['parent'] = $categoryParent;

                    $childFundsCounter++;
                }
            }
        }
    }
    else 
    {
        $parentFunds = [];
        $childFunds = [];
        $fundPosts = [];
        $fundPostsCounter = 0;
        $familyArray = [];

        $fundsArray = [];
        $fundsCounter = 0;

        $unitArray = [];
        $unitCounter = 0;

        foreach($fundFamilyOverride as $fund)
        {
            $fundName = $fund->name;
            $fundID = $fund->term_id;
            $fundParent = $fund->parent;

            $familyArray[] = $fundID;

            if($fundParent == 0)
            {
                $parentFundsArray[$parentFundsCounter]['name'] = $fundName;
                $parentFundsArray[$parentFundsCounter]['id'] = $fundID;

                $parentFundsCounter++;
            }
            else 
            {
                $childFundsArray[$childFundsCounter]['name'] = $fundName;
                $childFundsArray[$childFundsCounter]['id'] = $fundID;
                $childFundsArray[$childFundsCounter]['parent'] = $fundParent;

                $childFundsCounter++;
            }
        }

        if(isset($parentFundsArray) && !empty($parentFundsArray))
        {
            foreach($parentFundsArray as $parentItem)
            {
                $fundName = $parentItem['name'];
                $firstLetter = substr($fundName, 0, 1);

                if(!in_array($firstLetter, $availableLetters))
                {
                    $availableLetters[] = $firstLetter;
                }
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

        if($fundPosts->have_posts())
        {
            while($fundPosts->have_posts())
            {
                $fundPosts->the_post();

                $fundID = get_the_ID();
                $fundFamilies = get_the_terms($fundID, 'family');
                $className = get_field('class_name');
                $documentID = get_field('document_id');

                $familiesArray = [];

                if (isset($fundFamilies) && !empty($fundFamilies)) {
                    foreach ($fundFamilies as $fundFamily) {
                        $familiesArray[] = $fundFamily->term_id;
                    }
                }

                $fundsArray[$fundsCounter]['families'] = $familiesArray;
                $fundsArray[$fundsCounter]['document_id'] = $documentID;
                $fundsArray[$fundsCounter]['class_name'] = $className;

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

        if($unitValuePosts->have_posts())
        {
            while($unitValuePosts->have_posts())
            {
                $unitValuePosts->the_post();

                $unitID = get_the_ID();
                $unitFamilies = get_the_terms($unitID, 'family');
                $className = get_field('class_name');
                $documentID = get_field('document_id');

                $familiesArray = [];

                if (isset($unitFamilies) && !empty($unitFamilies)) {
                    foreach ($unitFamilies as $unitFamily) {
                        $familiesArray[] = $unitFamily->term_id;
                    }
                }

                $unitArray[$unitCounter]['families'] = $familiesArray;
                $unitArray[$unitCounter]['document_id'] = $documentID;
                $unitArray[$unitCounter]['class_name'] = $className;

                $unitCounter++;
            }
        }
    }    

    /*
    Code that creates child fund families for each Fund post - only needs to be run if you're wiping all data and importing fresh data from a spreadsheet
    $allFundArgs = array(
        'post_type' => 'funds',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    );

    $allFunds = new WP_Query($allFundArgs);

    if($allFunds->have_posts())
    {
        while($allFunds->have_posts())
        {
            $allFunds->the_post();

            $fundID = get_the_ID();
            $fundName = get_the_title();
            $fundCategories = get_the_terms(get_the_ID(), 'family');

            $parentFund = '';
            $parentCounter = 0;

            if(isset($fundCategories) && !empty($fundCategories))
            {
                foreach($fundCategories as $fundCategory)
                {
                    $parentCounter++;

                    $parentFund = $fundCategory->term_id;
                }
            }

            if($parentFund != '')
            {
                $existingFund = get_term_by('name', $fundName, 'family');

                if($existingFund == false)
                {
                   $newFundID =  wp_insert_term($fundName, 'family', array('parent' => $parentFund));

                    wp_set_object_terms($fundID, $newFundID['term_id'], 'family');
                }
                else 
                {
                    $existingFundID = $existingFund->term_id;

                    wp_set_object_terms($fundID, $existingFundID, 'family');
                }
            }
        }
    }
    */
?>
<section class="fund-sheets-container">
    <div class="grid-container">
        <div class="funds-upper-actions">
            <div class="grid-x">
                <div class="crumb-wrapper">
                    <?php 
                        if(function_exists('yoast_breadcrumb')) 
                        {
                            yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                        }
                    ?>
                </div>
                <?php if(!isset($fundFamilyOverride) || empty($fundFamilyOverride)){ ?>
                <?php 
                    $fundCategories = get_terms(array(
                        'taxonomy' => 'fund_categories',
                        'hide_empty' => true,
                        'orderby' => 'name',
                        'order' => 'ASC'
                    )
                    );
                ?>
                <div class="fund-search-wrapper">
                    <form action="/" method="POST" id="fund-search-form">
                        <label for="fund-search"><?php echo $searchPlaceholder; ?></label>
                        <input type="text" name="fund_search" id="fund-search" placeholder="<?php echo $searchPlaceholder; ?>">
                        <button type="submit" id="fund-search-submit">Search
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M17.549 20.1631C15.7323 21.457 13.5102 22.219 11.1095 22.219C4.97462 22.219 0 17.2444 0 11.1095C0 4.97462 4.97462 0 11.1095 0C17.2444 0 22.219 4.97462 22.219 11.1095C22.219 13.5105 21.457 15.7325 20.1631 17.549L27.4628 24.8487C28.1816 25.5676 28.1765 26.7191 27.4628 27.4314L27.4327 27.4615C26.7218 28.1725 25.5623 28.1752 24.85 27.4615L17.5503 20.1618L17.549 20.1631ZM11.1095 19.605C15.8015 19.605 19.605 15.8018 19.605 11.1095C19.605 6.4172 15.8018 2.614 11.1095 2.614C6.4172 2.614 2.614 6.4172 2.614 11.1095C2.614 15.8018 6.4172 19.605 11.1095 19.605Z" fill="#2F3942"/>
                        </svg>
                        </button>
                        <div class="fund-results-wrapper">
                            <?php 
                                if(isset($fundCategories) && !empty($fundCategories)){ ?>
                                    <div class="fund-results-categories">
                                        <?php 
                                            foreach($fundCategories as $category)
                                            {
                                                $categoryName = $category->name;
                                                $categoryID = $category->term_id;

                                                echo '<a href="#" class="category-result" data-id="'.$categoryID.'"><span class="result-name"><span class="cat-label">Category: </span><span class="name-inner">'.$categoryName.'</span></span><span class="apply-filter">Apply Filter</span></a>';
                                            }
                                        ?>
                                    </div>
                            <?php } ?>
                            <div class="fund-results-families" >

                            </div>
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
            <?php if(!isset($fundFamilyOverride) || empty($fundFamilyOverride)){ ?>
                <div class="grid-x search-note-row">
                    <div class="fund-search-wrapper"><p class="search-note">*CUSIP and Nasdaq Ticker Codes must be searched as full values.</p></div>
                </div>
            <?php } ?>
        </div>
        <div class="funds-alphabet-outer">
            <div class="funds-alphabet">
                <div class="alphabet-carousel swiper">
                    <div class="swiper-wrapper">
                        <?php 
                            foreach($alphabetArray as $letter)
                            {
                                $letterClass = 'has-letter';

                                if(!in_array($letter, $availableLetters))
                                {
                                    $letterClass = 'no-letter';
                                }
                                echo '<div class="swiper-slide"><a class="letter-link '.$letterClass.'" href="#letter-'.$letter.'">'.$letter.'</a></div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="fund-cat-wrapper">
            <h5>Category Filter</h5>
            <ul class="cat-filter-list"></ul>
        </div>
        <div class="ajax-loader">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#81D8D0"></stop><stop offset=".3" stop-color="#81D8D0" stop-opacity=".9"></stop><stop offset=".6" stop-color="#81D8D0" stop-opacity=".6"></stop><stop offset=".8" stop-color="#81D8D0" stop-opacity=".3"></stop><stop offset="1" stop-color="#81D8D0" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="5" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#81D8D0" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>
        </div>
        <div class="fund-listings-wrapper">
            <?php 
                if(isset($fundFamilyOverride) && !empty($fundFamilyOverride))
                {
                    /* Loop Through Parent Items */
                    if(isset($parentFundsArray) && !empty($parentFundsArray))
                    {
                        foreach($parentFundsArray as $parentFund)
                        {
                            $parentFundName = $parentFund['name'];
                            $parentFundID = $parentFund['id'];
                            $firstLetter = substr($parentFundName, 0, 1);

                            echo '<div class="parent-fund-wrapper populated" data-id="'.$parentFundID.'">';

                            foreach($alphabetArray as $key => $letter)
                            {
                                if(strtolower($firstLetter) == strtolower($letter))
                                {
                                    $letterIndex = $key;

                                    echo '<div class="fund-letter-location" id="letter-'.$letter.'"></div>';

                                    unset($alphabetArray[$key]);
                                }
                            }

                            echo '
                            <a class="parent-fund-link"> 
                                '.$parentFundName.' 
                                <span class="arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                                        <path d="M1 13L7 7L1 1" stroke="#2F3942"/>
                                    </svg>
                                </span>
                            </a>
                            <div class="child-fund-table">
                            ';

                            /* Loop through Child Items */
                            if(isset($childFundsArray) && !empty($childFundsArray))
                            {
                                foreach($childFundsArray as $childFund)
                                {
                                    $childFundName = $childFund['name'];
                                    $childFundID = $childFund['id'];
                                    $childFundParent = $childFund['parent'];

                                    if($childFundParent == $parentFundID)
                                    {
                                        echo '
                                        <div class="child-fund-row" data-id="'.$childFundID.'">
                                            <div class="child-fund-cell">'.$childFundName.'</div>
                                        ';

                                        /* Display Unit Values First */
                                        if(isset($unitArray) && !empty($unitArray))
                                        {
                                            foreach($unitArray as $unit)
                                            {
                                                $unitFamilies = $unit['families'];
                                                $unitDocumentID = $unit['document_id'];
                                                $unitClassName = $unit['class_name'];

                                                if(in_array($childFundID, $unitFamilies))
                                                {
                                                    echo '
                                                    <div class="child-fund-cell">
                                                        <a href="/cit-fund-info/collective-funds-fact-sheets/portfolio-unit-values/?id='.$unitDocumentID.'" target="_blank">'.$unitClassName.'</a>
                                                    </div>
                                                    ';
                                                }
                                            }
                                        }

                                        /* Display Normal Fund Fact Sheets */
                                        if(isset($fundsArray) && !empty($fundsArray))
                                        {
                                            foreach($fundsArray as $fund)
                                            {
                                                $fundFamilies = $fund['families'];
                                                $fundDocumentID = $fund['document_id'];
                                                $fundClassName = $fund['class_name'];

                                                if(in_array($childFundID, $fundFamilies))
                                                {
                                                    echo '
                                                    <div class="child-fund-cell">
                                                        <a href="https://doc.morningstar.com/LatestDoc.aspx?clientid=greatgray&key=1cd9aa63b2372cae&documenttype=124&sourceid=260&secid='.$fundDocumentID.'" target="_blank">'.$fundClassName.'</a>
                                                    </div>
                                                    ';
                                                }
                                            }
                                        }

                                        echo '
                                        </div>
                                        ';
                                    }
                                }
                            }
                            elseif((isset($unitArray) && !empty($unitArray)) || (isset($fundsArray) && !empty($fundsArray)))
                            {
                                echo '<div class="child-fund-row"><div class="child-fund-cell">'.$parentFundName.'</div>';

                                if(isset($unitArray) && !empty($unitArray))
                                {
                                    foreach($unitArray as $unit)
                                    {
                                        $unitFamilies = $unit['families'];
                                        $unitDocumentID = $unit['document_id'];
                                        $unitClassName = $unit['class_name'];

                                        if(in_array($parentFundID, $unitFamilies))
                                        {
                                            echo '
                                            <div class="child-fund-cell">
                                                <a href="/cit-fund-info/collective-funds-fact-sheets/portfolio-unit-values/?id='.$unitDocumentID.'" target="_blank">'.$unitClassName.'</a>
                                            </div>
                                            ';
                                        }
                                    }
                                }

                                if(isset($fundsArray) && !empty($fundsArray))
                                {
                                    foreach($fundsArray as $fund)
                                    {
                                        $fundFamilies = $fund['families'];
                                        $fundDocumentID = $fund['document_id'];
                                        $fundClassName = $fund['class_name'];

                                        if(in_array($parentFundID, $fundFamilies))
                                        {
                                            echo '
                                            <div class="child-fund-cell">
                                                <a href="https://doc.morningstar.com/LatestDoc.aspx?clientid=greatgray&key=1cd9aa63b2372cae&documenttype=124&sourceid=260&secid='.$fundDocumentID.'" target="_blank">'.$fundClassName.'</a>
                                            </div>
                                            ';
                                        }
                                    }
                                }

                                echo '</div>';
                            }

                            echo '</div>'; // end of child fund table
                            echo '</div>'; // end of parent fund wrapper
                        }
                    }
                }
                else 
                {
                    if(isset($parentFundsArray) && !empty($parentFundsArray))
                    {
                        foreach($parentFundsArray as $parentFund)
                        {
                            $parentFundName = $parentFund['name'];
                            $parentFundID = $parentFund['id'];
                            $firstLetter = substr($parentFundName, 0, 1);

                            echo '<div class="parent-fund-wrapper" data-id="'.$parentFundID.'">';

                            foreach($alphabetArray as $key => $letter)
                            {
                                if(strtolower($firstLetter) == strtolower($letter))
                                {
                                    $letterIndex = $key;

                                    echo '<div class="fund-letter-location" id="letter-'.$letter.'"></div>';

                                    unset($alphabetArray[$key]);
                                }
                            }

                            echo '
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

                            echo '</div>'; // parent fund wrapper
                        }
                    }
                }  
            ?>
        </div>
    </div>
</section>