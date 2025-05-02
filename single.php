<?php
    get_header();

    $backBtn = get_field('back_button', 'option');
    $catArray = array();
    $tagsArray = array();
    $excludedPost = get_the_ID();
    $confidentiality = get_field('perspectives_confidentiality_copy', 'option');
    $isBlog = false;
?>
<section class="detail-container">
    <div class="grid-container">
        <div class="detail-upper">
            <div class="grid-x">
                <div class="small-6 back-btn-wrapper">
                    <?php if(isset($backBtn) && !empty($backBtn)){ ?>
                    <a href="<?php echo $backBtn['url']; ?>" class="back-btn">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 12H4M4 12L10 6M4 12L10 18" stroke="#6C009F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <?php echo $backBtn['title']; ?>
                    </a>
                    <?php } ?>
                </div>
                <div class="small-6 actions-wrapper">
                    <ul class="actions-list">
                        <li>
                            <a href="#share-modal" data-fancybox class="share-btn">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                        <path d="M0.880276 20.1707C0.86137 20.1707 0.841605 20.1689 0.822698 20.1664C0.660276 20.1414 0.529658 20.0168 0.498704 19.8553C-0.264432 15.9124 0.62589 12.2635 3.00032 9.58235C5.49688 6.76437 9.36581 5.27937 13.6653 5.47451V2.21829C13.6653 2.06103 13.7598 1.91922 13.905 1.85907C14.0511 1.79892 14.2187 1.83157 14.3296 1.94329L21.6549 9.26863C21.807 9.42074 21.807 9.66653 21.6549 9.81863L14.3296 17.144C14.2187 17.2557 14.0511 17.2892 13.905 17.2291C13.7598 17.168 13.6653 17.0262 13.6653 16.869V13.7366C8.30013 12.5275 3.36662 15.916 1.22404 19.9646C1.15615 20.0909 1.02381 20.1708 0.880294 20.1708L0.880276 20.1707Z" fill="#6C009F"/>
                                    </svg>
                                </span>
                                Share
                            </a>
                        </li>
                        <li>
                            <a href="#" onClick="window.print()" class="print-btn">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                        <path d="M19.0385 3.38462H3.06731C2.25381 3.38462 1.47363 3.70778 0.898394 4.28301C0.323162 4.85824 0 5.63842 0 6.45192V14.8077C0 15.5931 0.312019 16.3464 0.867415 16.9018C1.42281 17.4572 2.17609 17.7692 2.96154 17.7692H3.38462V19.8677C3.38462 20.4332 3.60927 20.9756 4.00915 21.3755C4.40904 21.7753 4.9514 22 5.51692 22H16.4831C17.0486 22 17.591 21.7753 17.9908 21.3755C18.3907 20.9756 18.6154 20.4332 18.6154 19.8677V17.7692H19.0385C19.8239 17.7692 20.5772 17.4572 21.1326 16.9018C21.688 16.3464 22 15.5931 22 14.8077V6.34615C22 5.56071 21.688 4.80743 21.1326 4.25203C20.5772 3.69663 19.8239 3.38462 19.0385 3.38462ZM16.9231 19.8677C16.9227 19.9843 16.8762 20.0959 16.7937 20.1784C16.7113 20.2608 16.5996 20.3073 16.4831 20.3077H5.51692C5.40036 20.3073 5.28868 20.2608 5.20626 20.1784C5.12383 20.0959 5.07734 19.9843 5.07692 19.8677V11.44C5.07734 11.3234 5.12383 11.2118 5.20626 11.1293C5.28868 11.0469 5.40036 11.0004 5.51692 11H16.4831C16.5996 11.0004 16.7113 11.0469 16.7937 11.1293C16.8762 11.2118 16.9227 11.3234 16.9231 11.44V19.8677ZM18.2981 8.45731C18.0392 8.47812 17.7802 8.41901 17.556 8.28797C17.3317 8.15692 17.1531 7.96025 17.0442 7.72449C16.9353 7.48873 16.9013 7.22523 16.9468 6.96955C16.9924 6.71387 17.1153 6.47832 17.2989 6.29468C17.4825 6.11104 17.7181 5.98815 17.9738 5.9426C18.2295 5.89705 18.493 5.93103 18.7287 6.03996C18.9645 6.14888 19.1612 6.32751 19.2922 6.55173C19.4232 6.77595 19.4823 7.03497 19.4615 7.29385C19.4374 7.59436 19.3071 7.87646 19.0939 8.08964C18.8807 8.30282 18.5986 8.43315 18.2981 8.45731ZM15.6538 0H6.34615C5.63433 0.00105996 4.94662 0.258057 4.40856 0.724082C3.8705 1.19011 3.51796 1.83408 3.41529 2.53846H18.5847C18.482 1.83408 18.1295 1.19011 17.5914 0.724082C17.0534 0.258057 16.3657 0.00105996 15.6538 0Z" fill="#6C009F"/>
                                    </svg>
                                </span>
                                Print
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="detail-main-wrapper">
            <div class="grid-x">
                <div class="detail-content-wrapper">
                    <?php 
                        if(have_posts())
                        {
                            while(have_posts())
                            {
                                the_post();

                                $title = get_the_title();
                                $date = get_the_date('F j, Y');
                                $tags = get_the_tags();
                                $tagsHTML = '';

                                /* Social Sharing Data */
                                $postLink = get_the_permalink();
                                $postContent = get_the_content();
                                $strippedContent = strip_tags($postContent);
                                $shortContent = trimStringToFullWord(170, $strippedContent);
                                $postImg = get_the_post_thumbnail_url(get_the_ID(), 'full');
                                $dateHTML = '';
                                $categories = get_the_category();
                                $catListHTML = '';
                                $metaHTML = '';
                                $externalLink = get_field('resource_external_link');
                                $resourceFile = get_field('resource_file');
                                $videoURL = get_field('video_url');
                                $videoThumb = get_field('video_thumbnail');

                                $types = get_the_terms(get_the_ID(), 'types');

                                if(isset($tags) && !empty($tags) && $hideTags == false)
                                {
                                    $tagsHTML = '<ul class="tags-list">';
                                    foreach($tags as $tag)
                                    {
                                        $tagsHTML .= '<li><a href="'.$backBtn['url'].'?tag='.$tag->term_id.'">'.$tag->name.'</a></li>';

                                        $tagsArray[] = $tag->term_id;
                                    }
                                    $tagsHTML .= '</ul>';
                                }

                                if(isset($categories) && !empty($categories))
                                {
                                    $catListHTML .= '<ul class="cat-list">';
                                    $catCounter = 0;
                                    $numCats = count($categories);

                                    foreach($categories as $category)
                                    {
                                        if($category->term_id != 1 && $category->term_id != 911 && $category->term_id != 912 && $category->term_id != 1658)
                                        {
                                            $catCounter++;

                                            $catArray[] = $category->term_id;

                                            $concatHTML = ',';

                                            if($catCounter == $numCats)
                                            {
                                                $concatHTML = '';
                                            }

                                            $catListHTML .= '<li><a href="'.$backBtn['url'].'?cat='.$category->term_id.'">'.$category->name.'</a><span class="concat">'.$concatHTML.'</span></li>';
                                        }
                                        
                                    }

                                    $catListHTML .= '</ul>';
                                }

                                $dateHTML = '
                                <span class="date">
                                    '.$date.'
                                </span>
                                ';

                                if((isset($dateHTML) && $dateHTML != '') || (isset($catListHTML) && $catListHTML != ''))
                                {
                                    $metaHTML = '
                                    <div class="grid-x meta-info">
                                        '.$dateHTML.'
                                        '.$catListHTML.'
                                    </div>
                                    ';
                                }

                                $linksHTML = '';
                                $isWhitepaper = false;
                                $videoHTML = '';

                                if(isset($types) && !empty($types))
                                {
                                    foreach($types as $type)
                                    {
                                        if($type->name == 'White Papers')
                                        {
                                            $isWhitepaper = true;
                                        }
                                        if($type->term_id == 1657)
                                        {
                                            $isBlog = true;
                                        }
                                    }
                                }

                                if(isset($externalLink) && $externalLink != '')
                                {
                                    $linksHTML .= '<p><a href="'.$externalLink.'" target="_blank" class="btn btn-primary">Visit Link</a></p>';
                                }

                                if(isset($resourceFile) && $resourceFile != '')
                                {
                                    $btnText = 'Download File';

                                    if($isWhitepaper == true)
                                    {
                                        $btnText = 'Download Whitepaper';
                                    }

                                    $linksHTML .= '<p><a href="'.$resourceFile['url'].'" target="_blank" class="btn btn-primary">'.$btnText.'</a></p>';
                                }

                                if(isset($videoURL) && $videoURL != '')
                                {
                                    $videoHTML .= '
                                    <a href="'.$videoURL.'" class="video" data-fancybox style="background-image:url('.$videoThumb.');">
                                        <div class="video-shade"></div>
                                        <span class="video-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="148" height="148" viewBox="0 0 148 148" fill="none">
                                                <circle cx="74" cy="74" r="73.5" stroke="#F7F6FB"/>
                                                <path d="M96 74L60 94.7846L60 53.2154L96 74Z" fill="#D9D9D9"/>
                                            </svg>
                                        </span>
                                        <span class="watch-copy">
                                            Watch Video
                                        </span>
                                    </a>';
                                }

                                echo '
                                <div class="detail-content-upper">
                                    <h1>'.$title.'</h1>
                                    '.$metaHTML.'
                                    '.$tagsHTML.'
                                    </span>
                                </div>
                                ';
                                the_content();

                                if(isset($linksHTML) && $linksHTML != '')
                                {
                                    echo '<div class="resource-links">'.$linksHTML.'</div>';
                                }
                                
                                if(isset($videoHTML) && $videoHTML != '')
                                {
                                    echo $videoHTML;
                                }

                                if(isset($confidentiality) && $confidentiality != '' && $isBlog == true)
                                {
                                    echo '
                                    <div class="confidentiality-copy">
                                        <hr>
                                        '.$confidentiality.'
                                    </div>';
                                }
                            }
                        }
                    ?>

                </div>
                <div class="detail-sidebar-wrapper">
                    <div class="sidebar-inner">
                        <form action="<?php echo $backBtn['url']; ?>" method="POST" class="blog-detail-search-form">
                            <label for="blogSearch">Search</label>
                            <input type="text" name="search" id="blogSearch" placeholder="Search...">
                            <button type="submit">
                                Search
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19" fill="none">
                                    <path d="M18.7417 17.3547L15.1963 13.8464C17.8873 10.4948 17.6338 5.56421 14.5631 2.49811C12.948 0.885371 10.8271 0 8.54797 0C6.26886 0 4.11575 0.885402 2.50053 2.49688C0.886665 4.10962 0 6.22747 0 8.5355C0 10.8435 0.886696 12.9612 2.50053 14.5741C4.11563 16.1547 6.23657 17.071 8.54797 17.071C10.4797 17.071 12.3793 16.4066 13.8669 15.2064L17.3817 18.716C17.5721 18.9062 17.7935 19 18.047 19C18.3005 19 18.5541 18.9049 18.7124 18.716C19.0908 18.3357 19.0908 17.7355 18.742 17.3552L18.7417 17.3547ZM15.1963 8.53547C15.1963 10.3063 14.5001 11.9806 13.2337 13.2144C11.9674 14.4468 10.3214 15.1741 8.5479 15.1741C6.77445 15.1741 5.09774 14.4789 3.8621 13.2144C2.62792 11.9499 1.89952 10.3063 1.89952 8.53547C1.89952 6.7646 2.59576 5.09034 3.8621 3.8565C5.12845 2.62412 6.74355 1.89678 8.5479 1.89678C10.3213 1.89678 11.9981 2.592 13.2337 3.8565C14.4679 5.121 15.1963 6.73374 15.1963 8.53547Z" fill="#6C009F"/>
                                </svg>
                            </button>
                        </form>
                        <?php 
                            $categories = get_categories(['orderby' => 'ID', 'order' => 'DESC', 'hide_empty' => 1, 'exclude' => array(1, 911, 912, 1658)]);
                            $categoryCounter = 0;

                            if($categories && !empty($categories)){
                        ?>
                        <div class="sidebar-cat-container">
                            <h4>Topics:</h4>
                            <ul class="cat-list">
                                <?php 
                                    shuffle($categories);
                                    foreach($categories as $category)
                                    {
                                        $categoryCounter++;

                                        if($categoryCounter <= 3)
                                        {
                                            echo '<li><a href="'.$backBtn['url'].'?cat='.$category->term_id.'">'.$category->name.'</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <?php 
                            $numRelatedItems = 0;
                            $fillerNumber = 0;
                            $excludedArray = [];
                            $relatedArray = [];
                            $relatedCounter = 0;

                            $defaultThumbArray = [];
                            $lastUsedThumbnail = '';

                            if(have_rows('perspectives_thumbnails', 'option'))
                            {
                                while(have_rows('perspectives_thumbnails', 'option'))
                                {
                                    the_row();

                                    $defaultThumbArray[] = get_sub_field('thumbnail');
                                }
                            }

                            $relatedArgs = array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'post__not_in' => array($excludedPost),
                                'post_status' => 'publish',
                                'meta_query' => array(
                                    array( 
                                        'key' => 'hide_on_perspectives',
                                        'value' => '1',
                                        'compare' => '!='
                                    )
                                )
                            );

                            if(isset($catArray) && !empty($catArray))
                            {
                                $relatedArgs['category__in'] = $catArray;
                            }
                            elseif(isset($tagsArray) && !empty($tagsArray))
                            {
                                $relatedArgs['tag__in'] = $tagsArray;
                            }

                            $relatedPosts = new WP_Query($relatedArgs);

                            if($relatedPosts->have_posts())
                            {
                                $numRelatedItems = $relatedPosts->post_count;

                                while($relatedPosts->have_posts())
                                {
                                    $relatedPosts->the_post();

                                    $relatedID = get_the_ID();

                                    $excludedArray[] = $relatedID;

                                    $relatedTitle = get_the_title();
                                    $relatedLink = get_the_permalink();
                                    $relatedImg = get_the_post_thumbnail_url($relatedID, 'full');

                                    if(!isset($relatedImg) || $relatedImg == '')
                                    {
                                        if (!empty($defaultThumbArray)) {
                                            do {
                                                $randomKey = array_rand($defaultThumbArray);
                                                $randomThumbnail = $defaultThumbArray[$randomKey];
                                            } while ($randomThumbnail == $lastUsedThumbnail && count($defaultThumbArray) > 1);
    
                                            $relatedImg = $randomThumbnail;
                                            // Update the last used thumbnail
                                            $lastUsedThumbnail = $randomThumbnail;
                                        }
                                    }

                                    $relatedArray[$relatedCounter]['title'] = $relatedTitle;
                                    $relatedArray[$relatedCounter]['link'] = $relatedLink;
                                    $relatedArray[$relatedCounter]['img'] = $relatedImg;

                                    $relatedCounter++;
                                }
                            }

                            if($numRelatedItems < 3)
                            {
                                $fillerNumber = 3 - $numRelatedItems;
                            }

                            if($fillerNumber > 0)
                            {
                                $fillerArgs = array(
                                    'post_type' => 'post',
                                    'posts_per_page' => $fillerNumber,
                                    'post__not_in' => $excludedArray,
                                    'post_status' => 'publish',
                                    'meta_query' => array(
                                        array( 
                                            'key' => 'hide_on_perspectives',
                                            'value' => '1',
                                            'compare' => '!='
                                        )
                                    )
                                );

                                $fillerPosts = new WP_Query($fillerArgs);

                                if($fillerPosts->have_posts())
                                {
                                    while($fillerPosts->have_posts())
                                    {
                                        $fillerPosts->the_post();

                                        $relatedID = get_the_ID();

                                        $relatedTitle = get_the_title();
                                        $relatedLink = get_the_permalink();
                                        $relatedImg = get_the_post_thumbnail_url($relatedID, 'full');

                                        if(!isset($relatedImg) || $relatedImg == '')
                                        {
                                            if (!empty($defaultThumbArray)) {
                                                do {
                                                    $randomKey = array_rand($defaultThumbArray);
                                                    $randomThumbnail = $defaultThumbArray[$randomKey];
                                                } while ($randomThumbnail == $lastUsedThumbnail && count($defaultThumbArray) > 1);
        
                                                $relatedImg = $randomThumbnail;
                                                // Update the last used thumbnail
                                                $lastUsedThumbnail = $randomThumbnail;
                                            }
                                        }

                                        $relatedArray[$relatedCounter]['title'] = $relatedTitle;
                                        $relatedArray[$relatedCounter]['link'] = $relatedLink;
                                        $relatedArray[$relatedCounter]['img'] = $relatedImg;

                                        $relatedCounter++;
                                    }
                                
                                }
                            }

                            if(isset($relatedArray) && !empty($relatedArray)){
                        ?>
                        <div class="related-posts-wrapper">
                            <h4>Related:</h4>
                            <?php 
                                foreach($relatedArray as $relatedItem)
                                {
                                    $thumbStyle = '';
                                    $shortTitle = trimStringToFullWord(40, $relatedItem['title']);

                                    if(isset($relatedItem['img']) && $relatedItem['img'] != '')
                                    {
                                        $thumbStyle = 'style="background-image: url('.$relatedItem['img'].');"';
                                    }

                                    echo '
                                    <div class="related-post">
                                        <div class="grid-x">
                                            <a class="related-post-link" href="'.$relatedItem['link'].'">
                                                <span class="post-thumbnail" '.$thumbStyle.'>
                                                    <span class="thumb-overlay"></span>
                                                </span>
                                                <span class="title">'.$shortTitle.'</span>
                                            </a>
                                        </div>
                                    </div>
                                    ';
                                }
                            ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-lower">
            <div class="grid-x">
                <div class="small-6 back-btn-wrapper">
                    <?php if(isset($backBtn) && !empty($backBtn)){ ?>
                    <a href="<?php echo $backBtn['url']; ?>" class="back-btn">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 12H4M4 12L10 6M4 12L10 18" stroke="#6C009F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <?php echo $backBtn['title']; ?>
                    </a>
                    <?php } ?>
                </div>
                <div class="small-6 actions-wrapper">
                    <ul class="actions-list">
                        <li>
                            <a href="#share-modal" data-fancybox class="share-btn">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                        <path d="M0.880276 20.1707C0.86137 20.1707 0.841605 20.1689 0.822698 20.1664C0.660276 20.1414 0.529658 20.0168 0.498704 19.8553C-0.264432 15.9124 0.62589 12.2635 3.00032 9.58235C5.49688 6.76437 9.36581 5.27937 13.6653 5.47451V2.21829C13.6653 2.06103 13.7598 1.91922 13.905 1.85907C14.0511 1.79892 14.2187 1.83157 14.3296 1.94329L21.6549 9.26863C21.807 9.42074 21.807 9.66653 21.6549 9.81863L14.3296 17.144C14.2187 17.2557 14.0511 17.2892 13.905 17.2291C13.7598 17.168 13.6653 17.0262 13.6653 16.869V13.7366C8.30013 12.5275 3.36662 15.916 1.22404 19.9646C1.15615 20.0909 1.02381 20.1708 0.880294 20.1708L0.880276 20.1707Z" fill="#6C009F"/>
                                    </svg>
                                </span>
                                Share
                            </a>
                        </li>
                        <li>
                            <a href="#" onClick="window.print()" class="print-btn">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                        <path d="M19.0385 3.38462H3.06731C2.25381 3.38462 1.47363 3.70778 0.898394 4.28301C0.323162 4.85824 0 5.63842 0 6.45192V14.8077C0 15.5931 0.312019 16.3464 0.867415 16.9018C1.42281 17.4572 2.17609 17.7692 2.96154 17.7692H3.38462V19.8677C3.38462 20.4332 3.60927 20.9756 4.00915 21.3755C4.40904 21.7753 4.9514 22 5.51692 22H16.4831C17.0486 22 17.591 21.7753 17.9908 21.3755C18.3907 20.9756 18.6154 20.4332 18.6154 19.8677V17.7692H19.0385C19.8239 17.7692 20.5772 17.4572 21.1326 16.9018C21.688 16.3464 22 15.5931 22 14.8077V6.34615C22 5.56071 21.688 4.80743 21.1326 4.25203C20.5772 3.69663 19.8239 3.38462 19.0385 3.38462ZM16.9231 19.8677C16.9227 19.9843 16.8762 20.0959 16.7937 20.1784C16.7113 20.2608 16.5996 20.3073 16.4831 20.3077H5.51692C5.40036 20.3073 5.28868 20.2608 5.20626 20.1784C5.12383 20.0959 5.07734 19.9843 5.07692 19.8677V11.44C5.07734 11.3234 5.12383 11.2118 5.20626 11.1293C5.28868 11.0469 5.40036 11.0004 5.51692 11H16.4831C16.5996 11.0004 16.7113 11.0469 16.7937 11.1293C16.8762 11.2118 16.9227 11.3234 16.9231 11.44V19.8677ZM18.2981 8.45731C18.0392 8.47812 17.7802 8.41901 17.556 8.28797C17.3317 8.15692 17.1531 7.96025 17.0442 7.72449C16.9353 7.48873 16.9013 7.22523 16.9468 6.96955C16.9924 6.71387 17.1153 6.47832 17.2989 6.29468C17.4825 6.11104 17.7181 5.98815 17.9738 5.9426C18.2295 5.89705 18.493 5.93103 18.7287 6.03996C18.9645 6.14888 19.1612 6.32751 19.2922 6.55173C19.4232 6.77595 19.4823 7.03497 19.4615 7.29385C19.4374 7.59436 19.3071 7.87646 19.0939 8.08964C18.8807 8.30282 18.5986 8.43315 18.2981 8.45731ZM15.6538 0H6.34615C5.63433 0.00105996 4.94662 0.258057 4.40856 0.724082C3.8705 1.19011 3.51796 1.83408 3.41529 2.53846H18.5847C18.482 1.83408 18.1295 1.19011 17.5914 0.724082C17.0534 0.258057 16.3657 0.00105996 15.6538 0Z" fill="#6C009F"/>
                                    </svg>
                                </span>
                                Print
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="share-modal">
    <div class="share-modal-inner">
        <div class="share-modal-upper grid-x">
            <div class="medium-8 share-column">
                <h3>Share this Perspective!</h3>
                <h5>Share On Social:</h5>
                <ul class="social-list">
                    <li>
                        <a aria-label="Share on Instagram" href="https://www.instagram.com/?url=<?php echo urlencode($postLink); ?>" target="_blank" class="btn-instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" width="43" height="44" viewBox="0 0 43 44" fill="none">
                                <path d="M38.2605 9.01887C37.8705 7.992 37.4031 7.25852 36.6519 6.48983C35.8978 5.72114 35.1839 5.24292 34.1775 4.8439C33.4206 4.54171 32.2823 4.18377 30.1834 4.08695C27.9154 3.98133 27.2359 3.95786 21.4957 3.95786C15.7555 3.95786 15.0731 3.98133 12.808 4.08695C10.712 4.18377 9.57371 4.54464 8.8139 4.8439C7.81036 5.24292 7.09355 5.72114 6.34233 6.48983C5.59112 7.25852 5.12376 7.992 4.73381 9.01887C4.43849 9.79342 4.08868 10.9582 3.99407 13.1058C3.89084 15.4266 3.86791 16.1219 3.86791 21.9985C3.86791 27.8752 3.89084 28.5705 3.99407 30.8883C4.08868 33.033 4.44135 34.1978 4.73381 34.9753C5.12376 36.0021 5.59112 36.7356 6.34233 37.5043C7.09355 38.273 7.81036 38.7512 8.8139 39.1502C9.57085 39.4524 10.7091 39.8104 12.808 39.9072C15.0759 40.0128 15.7555 40.0363 21.4957 40.0363C27.2359 40.0363 27.9183 40.0128 30.1834 39.9072C32.2794 39.8104 33.4206 39.4495 34.1775 39.1502C35.181 38.7512 35.8978 38.273 36.6519 37.5043C37.4031 36.7356 37.8705 36.0021 38.2605 34.9753C38.5558 34.2007 38.9056 33.0359 39.0002 30.8883C39.1034 28.5676 39.1264 27.8722 39.1264 21.9985C39.1264 16.1248 39.1034 15.4266 39.0002 13.1058C38.9056 10.9611 38.5529 9.79636 38.2605 9.01887ZM21.4986 33.2971C15.3999 33.2971 10.4568 28.239 10.4568 21.9985C10.4568 15.7581 15.3999 10.7 21.4986 10.7C27.5972 10.7 32.5403 15.7581 32.5403 21.9985C32.5403 28.239 27.5972 33.2971 21.4986 33.2971ZM32.9761 12.8916C31.5511 12.8916 30.3956 11.7093 30.3956 10.2511C30.3956 8.79296 31.5511 7.61059 32.9761 7.61059C34.4011 7.61059 35.5566 8.79296 35.5566 10.2511C35.5566 11.7093 34.4011 12.8916 32.9761 12.8916ZM21.4986 14.6637C17.5389 14.6637 14.3305 17.9468 14.3305 21.9985C14.3305 26.0503 17.5389 29.3333 21.4986 29.3333C25.4582 29.3333 28.6667 26.0503 28.6667 21.9985C28.6667 17.9468 25.4582 14.6637 21.4986 14.6637ZM42.871 31.0702C42.7649 33.4115 42.4036 35.0105 41.8732 36.41C41.3227 37.8564 40.5886 39.0827 39.393 40.3062C38.1974 41.5296 36.9989 42.2807 35.5853 42.844C34.2176 43.3868 32.655 43.7594 30.3669 43.868C28.0731 43.9736 27.342 44 21.5014 44C15.6609 44 14.9297 43.9736 12.6359 43.868C10.3479 43.7594 8.78522 43.3897 7.41755 42.844C6.004 42.2807 4.80549 41.5296 3.60985 40.3062C2.41422 39.0827 1.6802 37.8564 1.12969 36.41C0.599253 35.0105 0.235114 33.4115 0.129026 31.0702C0.0258052 28.7231 0 27.9749 0 21.9985C0 16.0221 0.0258052 15.274 0.129026 12.9269C0.232246 10.5856 0.596386 8.9866 1.12969 7.58712C1.6802 6.14069 2.41422 4.91138 3.60985 3.69087C4.80549 2.46743 6.004 1.71634 7.41755 1.15303C8.78522 0.610255 10.3479 0.237647 12.6359 0.132026C14.9297 0.0234713 15.6609 0 21.5014 0C27.342 0 28.0731 0.0264052 30.3669 0.132026C32.655 0.237647 34.2176 0.610255 35.5853 1.15596C36.9989 1.71928 38.1974 2.47036 39.393 3.69381C40.5886 4.91725 41.3227 6.14363 41.8732 7.59005C42.4036 8.98953 42.7677 10.5885 42.871 12.9298C42.9771 15.2769 43 16.0251 43 22.0015C43 27.9779 42.9742 28.726 42.871 31.0731V31.0702Z" fill="#6C009F"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a aria-label="Share on Facebook" href="https://www.facebook.com/share.php?u=<?php echo urlencode($postLink); ?>" target="_blank" class="btn-facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="42" viewBox="0 0 22 42" fill="none">
                                <path d="M14.2895 42V22.8689H20.8015L21.7779 15.3806H14.2921V10.6094C14.2921 8.44759 14.8991 6.97143 18.0298 6.97143H22V0.294207C21.3077 0.202108 18.9365 0 16.1803 0C10.4253 0 6.48609 3.47676 6.48609 9.86745V15.3806H0V22.8689H6.48609V42H14.2921H14.2895Z" fill="#6C009F"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a aria-label="Share on Twitter" href="https://twitter.com/intent/tweet?url=<?php echo urlencode($postLink); ?>&text=<?php echo urlencode($shortContent); ?>" target="_blank" class="btn-x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="37" viewBox="0 0 41 37" fill="none">
                                <path d="M24.8422 15.6737L38.5759 0H32.2889L21.9295 11.8223L12.9714 0H0L15.5002 20.2354L0.810717 37H7.10046L18.4397 24.0654L28.3481 37H41L24.8422 15.6737ZM7.34204 3.55929H11.0815L33.5667 33.2424H30.0823L7.34204 3.55929Z" fill="#6C009F"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a aria-label="Share on LinkedIn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($postLink); ?>" target="_blank" class="btn-linkedin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="40" viewBox="0 0 41 40" fill="none">
                                <path d="M9.05014 13.728H0.765625V39.5021H9.05014V13.728Z" fill="#6C009F"/>
                                <path d="M5.34121 0.841064C2.53956 0.841064 0.711685 2.62706 0.766981 5.00931C0.708613 7.28488 2.5395 9.12558 5.28279 9.12558C8.02607 9.12558 9.97065 7.28488 9.97065 5.00931C9.91228 2.62706 8.14286 0.841064 5.33814 0.841064H5.34121Z" fill="#6C009F"/>
                                <path d="M30.6259 12.8076C26.949 12.8076 24.4241 14.5561 23.0154 16.1399V13.4214H14.5723V39.5022H23.0154V24.9543C23.0154 24.1729 23.1258 23.3375 23.3496 22.8375C23.9048 21.2777 25.2926 19.6609 27.6264 19.6609C30.6826 19.6609 31.9032 22.0561 31.9032 25.5681V39.5022H40.3463V24.5082C40.3463 16.4843 36.18 12.8076 30.6289 12.8076H30.6259Z" fill="#6C009F"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a aria-label="Share on Pinterest" href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($postLink); ?>&media=<?php echo urlencode($postImg); ?>&description=<?php echo urlencode($shortContent); ?>" target="_blank" class="btn-pinterest">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="40" viewBox="0 0 32 40" fill="none">
                                <path d="M16.561 0C5.73255 0 0 7.2635 0 15.1667C0 18.8611 1.95956 23.4197 5.09329 24.887C5.56818 25.1142 5.83432 25.0097 5.93869 24.558C6.02219 24.2056 6.45531 22.4928 6.64057 21.7096C6.70319 21.4615 6.68228 21.2344 6.47615 20.989C5.44549 19.7305 4.61839 17.4173 4.61839 15.2737C4.61839 9.74123 8.80623 4.39674 15.94 4.39674C22.1057 4.39674 26.4162 8.58461 26.4162 14.5923C26.4162 21.3597 22.9929 26.0671 18.5388 26.0671C16.0835 26.0671 14.2283 24.0254 14.8258 21.5268C15.5486 18.5347 16.9081 15.3181 16.9081 13.1719C16.9081 11.2529 15.8773 9.64202 13.7325 9.64202C11.2172 9.64202 9.19505 12.2425 9.19505 15.7306C9.19505 17.9394 9.93865 19.4459 9.93865 19.4459C9.93865 19.4459 7.46246 29.9495 7.00845 31.9103C6.51269 34.0774 6.69278 37.7665 6.925 39.1138C7.05546 39.8683 8.27136 40.3017 8.5949 39.7534C9.08284 38.9232 11.152 35.3593 11.7104 33.1714C12.0182 31.9939 13.2759 27.2055 13.2759 27.2055C14.0822 28.7746 16.4723 30.0957 19.0085 30.0957C26.5571 30.0957 32 23.1429 32 14.4957C32 5.8484 25.2342 0.00783273 16.5532 0.00783273L16.561 0Z" fill="#6C009F"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="medium-4 copy-column">
                <a href="#" class="copy-btn">
                    <span class="copy-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
                            <path d="M0.964582 4.69933H4.28868V0H27V22.3007H22.7113V27H0V4.69933H0.964582ZM6.16091 14.8915H10.3926V10.6853H12.3208V14.8915H16.5525V16.8079H12.3208V21.0141H10.3926V16.8079H6.16091V14.8915ZM6.21791 4.69933H22.7125V20.384H25.0732V1.91494H6.21791V4.69933ZM20.7842 6.61577H1.92894V25.0849H20.7842V6.61577Z" fill="#7A7976"/>
                        </svg>
                    </span>
                    Copy Link<br>
                    To Post
                </a>
            </div>
        </div>
        <div class="share-form-wrapper">
            <h5>Share Via Email:</h5>
            <form action="/" method="POST" class="share-form">
                <input type="hidden" name="post-title" value="<?php echo $title; ?>">
                <input type="hidden" name="post-url" id="post-url" value="<?php echo $postLink ?>">
                <div class="grid-x">
                    <div class="medium-7 share-form-left">
                        <div class="input-wrapper">
                            <label for="recipient-name">Recipient's Name</label>
                            <input type="text" name="recipient-name" required placeholder="Name" id="recipient-name">
                        </div>
                        <div class="input-wrapper">
                            <label for="recipient-email">Recipient's Email</label>
                            <input type="email" name="recipient-email" required placeholder="name@company.com" id="recipient-email">
                        </div>
                        
                    </div>
                    <div class="medium-5 share-form-right">
                        <label for="special-message">Special Message (optional)</label>
                        <textarea name="special-message" id="special-message" placeholder="Message..."></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Send</button>
            </form>
            <div class="share-success">
                <p>Thank you for sharing! Your message has been sent successfully!</p>
            </div>
            <div class="share-error">
                <p>Sorry, there was an error sending your message. Please try again later.</p>
            </div>
        </div>
    </div>
</div>
<?php 
    get_footer(); 
?>