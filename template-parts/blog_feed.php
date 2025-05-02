<?php 
    $feedH = get_sub_field('feed_heading');

    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }

    $bgStyle = get_sub_field('background_style');
    $bgClass = '';

    if(isset($bgStyle) && $bgStyle != '') 
    {
        if($bgStyle == 'White')
        {
            $bgClass = 'white-bg';
        }
    }
?>
<?php 
    $defaultThumbArray = [];
    $lastUsedThumbnail = '';
    $categoryToShow = get_sub_field('category_to_show');
    $tagToShow = get_sub_field('tag_to_show');

    if(have_rows('perspectives_thumbnails', 'option'))
    {
        while(have_rows('perspectives_thumbnails', 'option'))
        {
            the_row();

            $defaultThumbArray[] = get_sub_field('thumbnail');
        }
    }

    $featuredPosts = [];
    $featuredPostsCounter = 0;

    $featuredArgs = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 4,
        'meta_query' => array(
            array( 
                'key' => 'hide_on_perspectives',
                'value' => '1',
                'compare' => '!='
            )
        )
    );

    if(isset($categoryToShow) && !empty($categoryToShow))
    {
        $featuredArgs['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $categoryToShow->term_id
            )
        );
    }

    if(isset($tagToShow) && !empty($tagToShow))
    {
        $featuredArgs['tax_query'] = array(
            array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $tagToShow->term_id
            )
        );
    }

    $featuredQuery = new WP_Query($featuredArgs);

    if($featuredQuery->have_posts())
    {
        while($featuredQuery->have_posts())
        {
            $featuredQuery->the_post();

            $itemID = get_the_ID();
            $itemTitle = get_the_title();
            $itemLink = get_the_permalink($itemID);
            $itemThumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $passedThumbnail = '';

            if(isset($itemThumb) && $itemThumb != '')
            {
                $passedThumbnail = $itemThumb;
            }
            else
            {
                if (!empty($defaultThumbArray)) {
                    do {
                        $randomKey = array_rand($defaultThumbArray);
                        $randomThumbnail = $defaultThumbArray[$randomKey];
                    } while ($randomThumbnail == $lastUsedThumbnail && count($defaultThumbArray) > 1);

                    $passedThumbnail = $randomThumbnail;
                    // Update the last used thumbnail
                    $lastUsedThumbnail = $randomThumbnail;
                }
            }

            $featuredPosts[$featuredPostsCounter] = [
                'title' => $itemTitle,
                'link' => $itemLink,
                'thumbnail' => $passedThumbnail
            ];

            $featuredPostsCounter++;
        }
    }
    
    wp_reset_query();

    if(!empty($featuredPosts)){
?>
<section class="blog-feed-container <?php echo $bgClass; ?>" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <?php 
            echo $feedH; 
        ?>
    </div>
    <div class="blog-feed-wrapper">
        <div class="swiper-buttons">
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none"> <g filter="url(#filter0_d_1990_1872)"> <circle cx="30" cy="30" r="30" transform="matrix(-1 0 0 1 86 26)" fill="#D0D1DB"/> </g> <path d="M49.2929 56.7071C48.9024 56.3166 48.9024 55.6834 49.2929 55.2929L55.6569 48.9289C56.0474 48.5384 56.6805 48.5384 57.0711 48.9289C57.4616 49.3195 57.4616 49.9526 57.0711 50.3431L51.4142 56L57.0711 61.6569C57.4616 62.0474 57.4616 62.6805 57.0711 63.0711C56.6805 63.4616 56.0474 63.4616 55.6569 63.0711L49.2929 56.7071ZM62 55C62.5523 55 63 55.4477 63 56C63 56.5523 62.5523 57 62 57L62 55ZM50 55L62 55L62 57L50 57L50 55Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1990_1872" x="0" y="0" width="120" height="120" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1990_1872"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1990_1872" result="shape"/> </filter> </defs> </svg>
            </div>
            <div class="swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120" fill="none"> <g filter="url(#filter0_d_1990_1875)"> <circle cx="56" cy="56" r="30" fill="#D0D1DB"/> </g> <path d="M62.7071 56.7071C63.0976 56.3166 63.0976 55.6834 62.7071 55.2929L56.3431 48.9289C55.9526 48.5384 55.3195 48.5384 54.9289 48.9289C54.5384 49.3195 54.5384 49.9526 54.9289 50.3431L60.5858 56L54.9289 61.6569C54.5384 62.0474 54.5384 62.6805 54.9289 63.0711C55.3195 63.4616 55.9526 63.4616 56.3431 63.0711L62.7071 56.7071ZM50 55C49.4477 55 49 55.4477 49 56C49 56.5523 49.4477 57 50 57L50 55ZM62 55L50 55L50 57L62 57L62 55Z" fill="#2F3942"/> <defs> <filter id="filter0_d_1990_1875" x="0" y="0" width="120" height="120" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"> <feFlood flood-opacity="0" result="BackgroundImageFix"/> <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/> <feOffset dx="4" dy="4"/> <feGaussianBlur stdDeviation="15"/> <feComposite in2="hardAlpha" operator="out"/> <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/> <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1990_1875"/> <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1990_1875" result="shape"/> </filter> </defs> </svg>
            </div>
        </div>
        <div class="swiper blog-feed-carousel">
            <div class="swiper-wrapper">
            <?php 
                foreach($featuredPosts as $featuredPost)
                {
                    $postTitle = trimStringToFullWord(75, $featuredPost['title']);
                    $postLink = $featuredPost['link'];
                    $postThumb = $featuredPost['thumbnail'];

                    echo '
                    <a href="'.$postLink.'" class="blog-cell swiper-slide">
                        <span class="blog-thumb" style="background-image: url('.$postThumb.');"></span>
                        <span class="blog-title">'.$postTitle.'</span>
                    </a>
                    ';
                }
            ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>