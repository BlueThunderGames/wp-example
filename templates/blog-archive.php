<?php
/* Template Name: Blog / Resources Archive */
    get_header();

    $hideDates = get_field('hide_dates', 'option');
    $hideCategories = get_field('hide_categories', 'option');
    $hideTags = get_field('hide_tags', 'option');
    $hideAuthor = get_field('hide_author', 'option');
    $defaultThumbArray = [];

    if(have_rows('perspectives_thumbnails', 'option'))
    {
        while(have_rows('perspectives_thumbnails', 'option'))
        {
            the_row();

            $defaultThumbArray[] = get_sub_field('thumbnail');
        }
    }
?>
<section class="archive-container">
    <div class="ajax-loader">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><radialGradient id="a5" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)"><stop offset="0" stop-color="#81D8D0"></stop><stop offset=".3" stop-color="#81D8D0" stop-opacity=".9"></stop><stop offset=".6" stop-color="#81D8D0" stop-opacity=".6"></stop><stop offset=".8" stop-color="#81D8D0" stop-opacity=".3"></stop><stop offset="1" stop-color="#81D8D0" stop-opacity="0"></stop></radialGradient><circle transform-origin="center" fill="none" stroke="url(#a5)" stroke-width="15" stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70"><animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="5" values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite"></animateTransform></circle><circle transform-origin="center" fill="none" opacity=".2" stroke="#81D8D0" stroke-width="15" stroke-linecap="round" cx="100" cy="100" r="70"></circle></svg>
    </div>
    <div class="grid-container">
        <div class="grid-x">
            <div class="sidebar-wrapper">
                <div class="sidebar-inner">
                    <div class="search-wrapper">
                        <form action="/" class="archive-search-form" method="POST">
                            <?php
                                $search = '';

                                if(isset($_POST['search']) && $_POST['search'] != '')
                                {
                                    $search = 'value="'.$_POST['search'].'"';
                                }
                            ?>
                            <label for="resource-search">Search</label>
                            <input type="text" name="search" id="resource-search" required <?php echo $search; ?> placeholder="Search...">
                            <button type="submit">
                                Search
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                                    <path d="M18.4979 20.8627C16.6735 22.162 14.442 22.9272 12.0312 22.9272C5.87055 22.9272 0.875 17.9317 0.875 11.771C0.875 5.6103 5.87055 0.614746 12.0312 0.614746C18.1919 0.614746 23.1875 5.6103 23.1875 11.771C23.1875 14.182 22.4223 16.4134 21.1229 18.2376L28.4533 25.568C29.1752 26.2899 29.17 27.4462 28.4533 28.1616L28.4231 28.1918C27.7092 28.9057 26.5449 28.9085 25.8295 28.1918L18.4991 20.8614L18.4979 20.8627ZM12.0312 20.3022C16.7429 20.3022 20.5625 16.483 20.5625 11.771C20.5625 7.05895 16.7433 3.23975 12.0312 3.23975C7.3192 3.23975 3.5 7.05895 3.5 11.771C3.5 16.483 7.3192 20.3022 12.0312 20.3022Z" fill="#2F3942"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                    <?php if($hideCategories == false) { ?>
                    <div class="filters-wrapper cat-filters-wrapper">
                        <ul class="cat-list">
                            <?php
                                $args = array(
                                    'taxonomy' => 'category',
                                    'hide_empty' => 0,
                                    'exclude' => array(1, 912, 911, 1658)
                                );

                                $categories = get_categories($args);

                                foreach($categories as $category)
                                {
                                    $catClass = '';

                                    if(isset($_GET['cat']) && $_GET['cat'] == $category->term_id)
                                    {
                                        $catClass = 'active';
                                    }

                                    echo '<li><a href="#" class="category-filter '.$category_color.$catClass.'" data-id="'.$category->term_id.'">'.$category->name.' <span class="filter-toggle"><span class="filter-toggle-inner"></span></span></a></li>';
                                }

                            ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if($hideCategories == false) { ?>
                    <div class="filters-wrapper file-filters-wrapper">
                        <?php
                        $fileTypes = get_terms( "types", array(
                            'hide_empty' => 0,
                            'orderby' => 'id', 
                            'order' => 'ASC'
                        ));
                        if(isset($fileTypes) && !empty($fileTypes)){ ?>
                        <ul class="cat-list">
                            <?php 
                                    foreach($fileTypes as $type)
                                    {
                                        $typeClass = '';

                                        if(isset($_GET['type']) && $_GET['type'] == $type->term_id)
                                        {
                                            $typeClass = 'active';
                                        }

                                        echo '<li><a href="#" class="file-filter '.$typeClass.'" data-id="'.$type->term_id.'">'.$type->name.'<span class="filter-toggle"><span class="filter-toggle-inner"></span></span></a></li>';
                                    }
                            ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php

                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 6,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array( 
                            'key' => 'hide_on_perspectives',
                            'value' => '1',
                            'compare' => '!='
                        )
                    )
                );

                if(isset($_GET['tag']) && $_GET['tag'] != '')
                {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => $_GET['tag']
                        )
                    );
                }

                if(isset($_GET['cat']) && $_GET['cat'] != '')
                {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $_GET['cat']
                        )
                    );
                }

                if(isset($_POST['search']) && $_POST['search'] != '')
                {
                    $args['s'] = "".$_POST['search']."";
                    $args['suppress_filters'] = true;
                }

                if(isset($_GET['type']) && $_GET['type'] != '')
                {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'types',
                            'field' => 'term_id',
                            'terms' => $_GET['type']
                        )
                    );
                }

                $blogQuery = new WP_Query($args);
            ?>
            <div class="results-wrapper">
                <div class="tags-applied">
                    <ul class="tags-list">
                        <?php 
                            if(isset($_GET['tag']) && $_GET['tag'] != '')
                            {
                                $tagID = $_GET['tag'];

                                $tag = get_term($tagID, 'post_tag');

                                $tagName = $tag->name;

                                echo '
                                <li>
                                    <a data-id="'.$tagID.'" class="removal-tag">
                                        '.$tagName.'
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <circle cx="10" cy="10" r="10" fill="#F7F6FB"/>
                                            <path d="M6 6L14 14" stroke="#2F3942"/>
                                            <path d="M14 6L6 14" stroke="#2F3942"/>
                                        </svg>
                                    </a>
                                </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
                <div class="blog-results" aria-live="polite">
                    <?php
                        if(!empty($defaultThumbArray))
                        {
                            $lastUsedThumbnail = '';
                        }

                        if($blogQuery->have_posts())
                        {
                            while($blogQuery->have_posts())
                            {
                                $blogQuery->the_post();

                                $title = get_the_title();
                                $title = trimStringToFullWord(84, $title);
                                $tags = get_the_tags();
                                $thumb = get_the_post_thumbnail_url();
                                $thumbStyle = '';
                                $tagHTML = '';
                                $post_id = get_the_ID();

                                $articleFile = get_field('article_file');
                                $articleHTML = '';
                                $articleTitle = '';
                                $articleButton = '';

                                if(isset($thumb) && $thumb != '')
                                {
                                    $thumbStyle = 'style="background-image: url('.$thumb.')"';
                                } else {

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

                                if(isset($tags) && !empty($tags) && $hideTags == false)
                                {
                                    $tagCounter = 0;
                                    $tagHTML = '<ul class="tag-list">';

                                    foreach($tags as $tag)
                                    {
                                        $tagCounter++;

                                        if($tagCounter < 5)
                                        {
                                            $tagHTML .= '<li><a href="#" class="feed-tag" data-id="'.$tag->term_id.'">'.$tag->name.'</a></li>';
                                        }
                                        elseif($tagCounter == 5)
                                        {
                                            $tagHTML .= '<li>+</li>';
                                        }
                                    }

                                    $tagHTML .= '</ul>';
                                }

                                if(isset($articleFile) && $articleFile != '')
                                {
                                    $articleLink = $articleFile['url'];
                                    $articleLinkTarget = 'target="_blank"';
                                    $articleHTML = '<a href="'.$articleFile['url'].'" target="_blank" aria-label="View Resource" class="result-thumb"'.$thumbStyle.'></a>';
                                    $articleTitle = '<a href="'.$articleFile['url'].'" target="_blank" class="result-title">'.$title.'</a>';
                                } 
                                else 
                                {
                                    $articleLink = get_the_permalink();
                                    $articleLinkTarget = '';
                                    $articleHTML ='<a href="'.get_the_permalink().'" aria-label="View Resource" class="result-thumb"'.$thumbStyle.'></a>';
                                    $articleTitle = '<a href="'.get_the_permalink().'" class="result-title">'.$title.'</a>';
                                }

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
                        }
                        else 
                        {
                            echo '<h3 class="no-results">No Results Found!</h3>';
                        }
                    ?>
                </div>
                <div class="loading-position"></div>
            </div>
        </div>
    </div>
</section>
<?php
    get_footer();
?>