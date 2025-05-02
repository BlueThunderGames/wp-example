<?php 
    $menuOneH = get_field('menu_one_heading', 'option');
    $menuTwoH = get_field('menu_two_heading', 'option');
    $menuThreeH = get_field('menu_three_heading', 'option');
    $menuFourH = get_field('menu_four_heading', 'option');
    $formH = get_field('form_heading', 'option');
    $copyrightText = get_field('copyright_text', 'option');

    $copyrightText = strip_tags($copyrightText, '<a>');

    $footerStyle = get_field('footer_style');
    $lOneText = get_field('line_one_text');
    $lTwoText = get_field('line_two_text');
    $lThreeText = get_field('line_three_text');
    $lFourText = get_field('line_four_text');
    $lFiveText = get_field('line_five_text');
    $lSixText = get_field('line_six_text');
    $ctaMaxWidth = get_field('cta_max_width');
    $ctaHeading = get_field('cta_heading');
    $ctaCopy = get_field('cta_copy');
    $feedTitle = get_field('feed_title');
    $ctaWidthStyle = '';

    if(isset($ctaMaxWidth) && $ctaMaxWidth != '')
    {
        $ctaWidthStyle = 'style="width:'.$ctaMaxWidth.'px;margin-left:auto;margin-right:auto;"';
    }
?>

<section class="footer-container">
    <footer>
    <?php if(isset($footerStyle) && $footerStyle == 'Blog Feed'){ ?>
    <div class="blog-feed-container">
        <div class="grid-container">
            <?php 
                $feedTitle = get_field('feed_title');
                if(isset($feedTitle) && $feedTitle != ''){ 
            ?>
            <?php echo $feedTitle; ?>
            <?php } ?>
        </div>
        <?php 
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
        
            $featuredPosts = [];
            $featuredPostsCounter = 0;
        
            $featuredArgs = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 4,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => 1658
                    )
                ),
                'meta_query' => array(
                    array( 
                        'key' => 'hide_on_perspectives',
                        'value' => '1',
                        'compare' => '!='
                    )
                )
            );
        
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

            if(!empty($featuredPosts))
            {
        ?>
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
                            echo '
                            <a href="'.$featuredPost['link'].'" class="blog-cell swiper-slide">
                                <span class="blog-thumb" style="background-image:url('.$featuredPost['thumbnail'].');">

                                </span>
                                <span class="blog-title">'.$postTitle.'</span>
                            </a>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
        <div class="grid-container">
            <div class="footer-upper">
                <?php if(isset($footerStyle) && $footerStyle == 'Homepage'){ ?>
                <div class="home-footer">
                    <?php 
                        $lineHeading = get_field('line_heading');
                    ?>
                    <h2><?php echo $lineHeading; ?></h2>
                    <div class="features">
                        <div class="grid-x feature-row desktop-only">
                            <ul>
                                <li><?php echo $lOneText; ?></li>
                                <li><?php echo $lTwoText; ?></li>
                                <li><?php echo $lThreeText; ?></li>
                            </ul>
                        </div>
                        <div class="grid-x feature-row desktop-only">
                            <ul>
                                <li><?php echo $lFourText; ?></li>
                                <li><?php echo $lFiveText; ?></li>
                                <li><?php echo $lSixText; ?></li>
                            </ul>
                        </div>
                        <div class="feature-row mobile-only">
                            <ul>
                                <?php 
                                    if(have_rows('line_items_mobile'))
                                    {
                                        while(have_rows('line_items_mobile'))
                                        {
                                            the_row();

                                            $lineItem = get_sub_field('line_item');

                                            echo '<li>'.$lineItem.'</li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="feature-bg">
                            <div class="bg-desktop">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer-lines-desktop.png" width="810px" alt="Footer Feature Image">
                            </div>
                            <div class="bg-mobile">
                                <svg width="45" height="428" viewBox="0 0 45 428" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1.7778e-08L0.999999 13C0.999999 29.5685 14.4315 43 31 43L45 43" stroke="#A7A9B4"/>
                                    <path d="M1 8L0.999999 85C0.999999 101.569 14.4315 115 31 115L45 115" stroke="#A7A9B4"/>
                                    <path d="M1 80L0.999999 157C0.999999 173.569 14.4315 187 31 187L45 187" stroke="#A7A9B4"/>
                                    <path d="M1 149L0.999999 249C0.999999 265.569 14.4315 279 31 279L45 279" stroke="#A7A9B4"/>
                                    <path d="M1 221L0.999999 321C0.999999 337.569 14.4315 351 31 351L45 351" stroke="#A7A9B4"/>
                                    <path d="M1 293L0.999999 393C0.999999 409.569 14.4315 423 31 423L45 423" stroke="#A7A9B4"/>
                                    <circle cx="40" cy="43" r="5" fill="#A7A9B4"/>
                                    <circle cx="40" cy="115" r="5" fill="#A7A9B4"/>
                                    <circle cx="40" cy="187" r="5" fill="#A7A9B4"/>
                                    <circle cx="40" cy="279" r="5" fill="#A7A9B4"/>
                                    <circle cx="40" cy="351" r="5" fill="#A7A9B4"/>
                                    <circle cx="40" cy="423" r="5" fill="#A7A9B4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if((isset($ctaHeading) && $ctaHeading != '') || (isset($ctaCopy) && $ctaCopy != '')){ ?>
                <div class="cta" <?php echo $ctaWidthStyle; ?>>
                    <?php if(isset($ctaHeading) && $ctaHeading != ''){ ?>
                    <span class="title">
                        <?php echo $ctaHeading; ?>
                    </span>
                    <?php } ?>
                    <?php echo $ctaCopy; ?>
                </div>
                <?php } ?>
            </div>
            <div class="footer-middle">
                <div class="grid-x">
                    <div class="line"></div>
                    <div class="logo-wrapper">
                        <a href="/" class="footer-logo-upper" aria-label="Go Home">
                            <svg xmlns="http://www.w3.org/2000/svg" width="220" height="67" viewBox="0 0 220 67" fill="none">
                                <path d="M21.9961 22.2051H43.9932V44.2021C31.839 44.2021 21.9961 34.3518 21.9961 22.2051Z" fill="#D0D1DB"/>
                                <path d="M21.9961 0.208008C21.9961 12.3621 31.8464 22.2051 43.9932 22.2051V0.208008H21.9961Z" fill="#D0D1DB"/>
                                <path d="M198.003 22.2061C198.003 34.3528 188.153 44.2031 176.006 44.2031V22.2061H198.003Z" fill="#D0D1DB"/>
                                <path d="M198.003 0.208008H176.006V22.2051C188.153 22.2051 198.003 12.3548 198.003 0.208008Z" fill="#D0D1DB"/>
                                <path d="M0 0.208984C0 12.3631 9.85032 22.2061 21.9971 22.2061V0.208984H0Z" fill="#A7A9B4"/>
                                <path d="M219.999 0.208008C219.999 12.3621 210.149 22.2051 198.002 22.2051V0.208008H219.999Z" fill="#A7A9B4"/>
                                <path d="M110 22.2056L94.4414 6.64744C103.036 -1.94758 116.963 -1.94758 125.55 6.64744L109.992 22.2056H110Z" fill="#F7F6FB"/>
                                <path d="M88.0039 22.2051C88.0039 10.0583 78.1536 0.208008 66.0068 0.208008H44.0098C44.0098 12.3548 53.8601 22.2051 66.0068 22.2051H44.0098C44.0098 34.3592 53.8601 44.2021 66.0068 44.2021H105.822C95.6685 42.2085 88.0113 33.259 88.0113 22.5226V22.1977L88.0039 22.2051Z" fill="#F7F6FB"/>
                                <path d="M110 44.21L125.558 59.7681C116.963 68.3632 103.037 68.3632 94.4495 59.7681L110.008 44.21H110Z" fill="#F7F6FB"/>
                                <path d="M132.004 22.53C132.004 33.2664 124.346 42.2158 114.193 44.2095H154.008C166.155 44.2095 176.005 34.3592 176.005 22.2125H154.008C166.148 22.2051 175.998 12.3621 175.998 0.208008H154.001C141.854 0.208008 132.004 10.0583 132.004 22.2051V22.53Z" fill="#F7F6FB"/>
                            </svg>
                        </a>
                    </div>
                    <div class="line"></div>
                </div>
            </div>
            <div class="footer-nav-connect">
                <div class="grid-x">
                    <div class="medium-6 footer-navs-wrapper">
                        <div class="grid-x">
                            <div class="footer-nav-column">
                                <h5><?php echo $menuOneH; ?></h5>
                                <?php 
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer_menu',
                                        'container' => false,
                                        'menu_class' => 'footer-nav',
                                    ));
                                ?>
                            </div>
                            <div class="footer-nav-column">
                                <h5><?php echo $menuTwoH; ?></h5>
                                <?php 
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer_menu_two',
                                        'container' => false,
                                        'menu_class' => 'footer-nav',
                                    ));
                                ?>
                            </div>
                            <div class="footer-nav-column">
                                <h5><?php echo $menuThreeH; ?></h5>
                                <?php 
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer_menu_three',
                                        'container' => false,
                                        'menu_class' => 'footer-nav',
                                    ));
                                ?>
                            </div>
                            <div class="footer-nav-column">
                                <h5><?php echo $menuFourH; ?></h5>
                                <?php 
                                    wp_nav_menu(array(
                                        'theme_location' => 'footer_menu_four',
                                        'container' => false,
                                        'menu_class' => 'footer-nav',
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="medium-6 footer-subscribe-wrapper">
                        <h5><?php echo $formH; ?></h5>
                        <?php if(have_rows('social_links', 'option')){ ?>
                        <ul class="social-list">
                            <?php 
                                while(have_rows('social_links', 'option'))
                                {
                                    the_row();

                                    $link = get_sub_field('link');
                                    $icon = get_sub_field('icon');

                                    $linkTarget = 'target="_self"';

                                    if(isset($link['target']) && $link['target'] != '')
                                    {
                                        $linkTarget = 'target="'.$link['target'].'"';
                                    }

                                    $iconExtension = pathinfo($icon['url'], PATHINFO_EXTENSION);

                                    if($iconExtension == 'svg')
                                    {
                                        echo '<li><a aria-label="Visit Social Media Page" href="'.$link['url'].'" '.$linkTarget.'>'.file_get_contents($icon['url']).'</a></li>';
                                    }
                                    else 
                                    {
                                        echo '<li><a aria-label="Visit Social Media Page" href="'.$link['url'].'" '.$linkTarget.'><img src="'.$icon['url'].'" alt="'.$icon['alt'].'"></a></li>';
                                    }
                                }
                            ?>
                        </ul>
                        <?php } ?>
                        <div class="subscribe-form-wrapper">
                            <?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="grid-x">
                    <div class="footer-logo-wrapper medium-5">
                        <a href="/" class="footer-logo" aria-label="Go Home">
                            <svg xmlns="http://www.w3.org/2000/svg" width="153" height="66" viewBox="0 0 153 66" fill="none">
                                <path d="M36.8848 9.79492H46.6778V19.5879C41.2668 19.5879 36.8848 15.2026 36.8848 9.79492Z" fill="#D0D1DB"/>
                                <path d="M36.8848 0.00292969C36.8848 5.41391 41.2701 9.79596 46.6778 9.79596V0.00292969H36.8848Z" fill="#D0D1DB"/>
                                <path d="M115.238 9.79492C115.238 15.2026 110.853 19.5879 105.445 19.5879V9.79492H115.238Z" fill="#D0D1DB"/>
                                <path d="M115.238 0.00292969H105.445V9.79596C110.853 9.79596 115.238 5.41063 115.238 0.00292969Z" fill="#D0D1DB"/>
                                <path d="M27.0876 0.00292969C27.0876 5.41391 31.473 9.79596 36.8807 9.79596V0.00292969H27.0876Z" fill="#D0D1DB"/>
                                <path d="M125.031 0.00292969C125.031 5.41391 120.646 9.79596 115.238 9.79596V0.00292969H125.031Z" fill="#D0D1DB"/>
                                <path d="M76.0593 9.79631L69.1328 2.86986C72.9593 -0.95662 79.1592 -0.95662 82.9824 2.86986L76.056 9.79631H76.0593Z" fill="#D0D1DB"/>
                                <path d="M66.2657 9.79693C66.2657 4.38924 61.8804 0.00390625 56.4727 0.00390625H46.6797C46.6797 5.4116 51.065 9.79693 56.4727 9.79693H46.6797C46.6797 15.2079 51.065 19.59 56.4727 19.59H74.1981C69.678 18.7024 66.269 14.7181 66.269 9.93829V9.79364L66.2657 9.79693Z" fill="#D0D1DB"/>
                                <path d="M76.0599 19.5928L82.9863 26.5192C79.1599 30.3457 72.9599 30.3457 69.1367 26.5192L76.0632 19.5928H76.0599Z" fill="#D0D1DB"/>
                                <path d="M85.8549 9.94158C85.8549 14.7214 82.4459 18.7057 77.9258 19.5932H95.6512C101.059 19.5932 105.444 15.2079 105.444 9.80022H95.6512C101.059 9.79693 105.444 5.41489 105.444 0.00390625H95.6512C90.2402 0.00390625 85.8549 4.38924 85.8549 9.79693V9.94158Z" fill="#D0D1DB"/>
                                <path d="M7.63652 45.6679L9.53332 46.1577V49.9711C9.1487 50.142 8.63916 50.2899 8.14935 50.2899C5.33866 50.2899 3.50761 48.2255 3.50761 44.1163C3.50761 40.3062 5.10526 38.5146 7.14999 38.5146C8.79038 38.5146 10.0231 39.6422 11.4729 42.3674L12.2618 42.3247L12.0712 37.3838H11.3479L10.6247 38.107C9.79303 37.7027 8.7082 37.4693 7.38668 37.4693C3.10655 37.4693 0 40.6646 0 44.6883C0 48.712 2.72522 51.6706 6.51553 51.6706C8.02772 51.6706 9.17829 51.2466 10.3256 50.5628L11.8575 51.5424L12.4952 51.457V46.1544L13.9647 45.6646V44.9842H7.63981V45.6646L7.63652 45.6679Z" fill="#D0D1DB"/>
                                <path d="M31.6332 50.6513C30.9527 50.4804 30.4201 50.224 30.0158 49.7769C29.526 49.2246 29.1414 48.4981 28.6515 47.2226C28.1847 46.0293 27.3728 45.2009 25.7127 44.882V44.5829C28.4181 44.1161 29.6936 42.8143 29.6936 41.1344C29.6936 39.0273 27.8396 37.7715 24.7527 37.7715H17.2148V38.475L19.2168 38.9451V50.1681L17.2148 50.6349V51.3384H24.3911V50.6349L22.4121 50.1681V45.3127H22.8592C24.0098 45.3127 24.6476 45.6546 25.1571 46.8446L26.0743 48.9945C26.8402 50.7401 27.33 51.3351 28.9901 51.3351H31.6299V50.6546L31.6332 50.6513ZM23.6055 44.264L22.4121 44.2837V38.8333C22.5601 38.7906 23.3293 38.8103 23.5397 38.8103C25.2853 38.8727 26.4556 39.642 26.4556 41.473C26.4556 43.3041 25.305 44.2213 23.6022 44.264H23.6055Z" fill="#D0D1DB"/>
                                <path d="M47.0479 47.0316L46.5384 46.9461L44.9407 48.9481C44.2602 49.7798 43.7901 50.1414 42.5146 50.1842L39.4903 50.2696V45.0526H40.4699C41.5975 45.0526 41.9163 45.3715 42.4062 46.8212L42.6198 47.4392H43.2148V41.6272H42.6396L42.4062 42.3077C41.8966 43.7771 41.5975 44.0533 40.4699 44.0533H39.4903V38.8165L41.7257 38.879C43.1097 38.9217 43.537 39.2406 44.3457 40.2432L45.8349 42.14L46.3444 42.0118L45.9598 37.7744H34.293V38.4779L36.295 38.9447V50.1677L34.293 50.6345V51.338H46.5778L47.0479 47.0382V47.0316Z" fill="#D0D1DB"/>
                                <path d="M58.7162 37.6429H56.4611L51.6287 49.9705L49.9883 50.6313V51.3348H54.63V50.697L53.1836 50.1217L54.3111 46.9264H58.9956L60.1659 50.2466L58.3973 50.6937V51.3315H65.1035V50.628L63.4204 50.0527L58.7129 37.6396L58.7162 37.6429ZM54.6728 45.8613L56.5268 40.5588H56.7175L58.6143 45.8613H54.676H54.6728Z" fill="#D0D1DB"/>
                                <path d="M75.5403 38.7705L76.2636 38.7935C77.3057 38.8362 77.71 39.2208 78.7751 40.6476L80.2446 42.6496L80.7968 42.5444L80.1361 37.7744H67.6803L67.0195 42.5444L67.5718 42.6496L69.0413 40.6476C70.0406 39.2833 70.5107 38.8362 71.5528 38.7935L72.3418 38.7705V50.1612L70.2346 50.6313V51.3347H77.6443V50.6313L75.5371 50.1612V38.7705H75.5403Z" fill="#D0D1DB"/>
                                <path d="M101.303 46.1577L102.772 45.6679V44.9874H96.4475V45.6679L98.3411 46.1577V49.9711C97.9564 50.142 97.4469 50.2899 96.9571 50.2899C94.1464 50.2899 92.3153 48.2255 92.3153 44.1163C92.3153 40.3062 93.913 38.5146 95.9577 38.5146C97.5981 38.5146 98.8309 39.6422 100.281 42.3674L101.07 42.3247L100.879 37.3838H100.156L99.4325 38.107C98.6008 37.7027 97.5159 37.4693 96.1944 37.4693C91.9143 37.4693 88.8044 40.6646 88.8044 44.6883C88.8044 48.712 91.5297 51.6706 95.32 51.6706C96.8322 51.6706 97.9827 51.2466 99.1333 50.5628L100.665 51.5424L101.303 51.457V46.1544V46.1577Z" fill="#D0D1DB"/>
                                <path d="M120.442 51.3318V50.6513C119.762 50.4804 119.229 50.224 118.825 49.7769C118.335 49.2246 117.951 48.4981 117.464 47.2226C116.994 46.0293 116.185 45.2009 114.525 44.882V44.5829C117.231 44.1161 118.506 42.8143 118.506 41.1344C118.506 39.0273 116.655 37.7715 113.565 37.7715H106.027V38.475L108.029 38.9451V50.1681L106.027 50.6349V51.3384H113.204V50.6349L111.225 50.1681V45.3127H111.672C112.822 45.3127 113.46 45.6546 113.973 46.8446L114.89 48.9945C115.656 50.7401 116.146 51.3351 117.806 51.3351H120.446L120.442 51.3318ZM112.415 44.264L111.221 44.2837V38.8333C111.369 38.7906 112.139 38.8103 112.349 38.8103C114.095 38.8727 115.265 39.642 115.265 41.473C115.265 43.3041 114.114 44.2213 112.411 44.264H112.415Z" fill="#D0D1DB"/>
                                <path d="M131.175 37.6429H128.916L124.084 49.9705L122.443 50.6313V51.3348H127.085V50.697L125.639 50.1217L126.766 46.9264H131.451L132.621 50.2466L130.852 50.6937V51.3315H137.559V50.628L135.875 50.0527L131.171 37.6396L131.175 37.6429ZM127.128 45.8613L128.979 40.5588H129.169L131.066 45.8613H127.128Z" fill="#D0D1DB"/>
                                <path d="M148.187 37.7686V38.4096L149.571 39.0703L146.697 44.3071L143.611 38.9421L145.208 38.4096V37.7686H138.285V38.472L140.139 39.1328L144.163 45.862V50.0764L142.075 50.632V51.3322H149.465V50.632L147.358 50.0764V45.3919L151.316 39.1328L152.999 38.472V37.7686H148.187Z" fill="#D0D1DB"/>
                                <path d="M29.6328 61.3747H31.2831V65.7074H32.4797V61.3747H34.1332V60.2734H29.6328V61.3747Z" fill="#D0D1DB"/>
                                <path d="M41.5215 62.0809V62.0644C41.5215 61.5516 41.3572 61.1242 41.0547 60.8218C40.6964 60.4635 40.1639 60.2695 39.4702 60.2695H36.9883V65.7035H38.1849V63.9645H39.1251L40.2888 65.7035H41.6859L40.3578 63.764C41.0482 63.5076 41.5215 62.9553 41.5215 62.0809ZM40.3118 62.1433C40.3118 62.6003 39.9765 62.9126 39.3946 62.9126H38.1849V61.3511H39.3716C39.9535 61.3511 40.3118 61.6141 40.3118 62.1269V62.1433Z" fill="#D0D1DB"/>
                                <path d="M47.9949 63.3866C47.9949 64.2478 47.5511 64.6916 46.8214 64.6916C46.0916 64.6916 45.6478 64.2347 45.6478 63.3504V60.2767H44.4512V63.38C44.4512 64.9776 45.3453 65.7929 46.8016 65.7929C48.2579 65.7929 49.185 64.9842 49.185 63.3405V60.2734H47.9884V63.3866H47.9949Z" fill="#D0D1DB"/>
                                <path d="M54.5564 62.4567C53.6162 62.2167 53.3828 62.0983 53.3828 61.7433V61.7269C53.3828 61.4639 53.6228 61.2535 54.0798 61.2535C54.5367 61.2535 55.0101 61.454 55.4933 61.7893L56.1146 60.8886C55.5624 60.4448 54.8884 60.1982 54.0962 60.1982C52.9851 60.1982 52.1961 60.8491 52.1961 61.8353V61.8518C52.1961 62.93 52.9029 63.2325 53.9976 63.5119C54.9049 63.7453 55.0923 63.8998 55.0923 64.2022V64.2187C55.0923 64.5375 54.7964 64.7315 54.3099 64.7315C53.6886 64.7315 53.1757 64.4751 52.6892 64.0707L51.9824 64.9156C52.6333 65.4975 53.465 65.7867 54.2869 65.7867C55.4604 65.7867 56.2823 65.1819 56.2823 64.1036V64.0872C56.2823 63.1404 55.661 62.7459 54.5597 62.4567H54.5564Z" fill="#D0D1DB"/>
                                <path d="M58.7578 61.3747H60.4114V65.7074H61.6047V61.3747H63.2582V60.2734H58.7578V61.3747Z" fill="#D0D1DB"/>
                                <path d="M72.9697 64.6985C72.0394 64.6985 71.3951 63.9226 71.3951 62.9923V62.9759C71.3951 62.0456 72.0558 61.2829 72.9697 61.2829C73.5121 61.2829 73.9395 61.5163 74.3603 61.8976L75.1196 61.0199C74.6167 60.5235 74.0019 60.1816 72.9763 60.1816C71.3063 60.1816 70.1426 61.4473 70.1426 62.9923V63.0088C70.1426 64.5703 71.3293 65.803 72.9303 65.803C73.9789 65.803 74.6002 65.4315 75.1591 64.8332L74.3997 64.064C73.9723 64.4519 73.591 64.7018 72.973 64.7018L72.9697 64.6985Z" fill="#D0D1DB"/>
                                <path d="M80.5524 60.1816C78.8759 60.1816 77.6562 61.4473 77.6562 62.9923V63.0088C77.6562 64.5538 78.8594 65.803 80.536 65.803C82.2125 65.803 83.4321 64.5374 83.4321 62.9923V62.9759C83.4321 61.4308 82.229 60.1816 80.5524 60.1816ZM82.1829 63.0055C82.1829 63.9358 81.5156 64.6985 80.5524 64.6985C79.5892 64.6985 78.9054 63.9226 78.9054 62.9923V62.9759C78.9054 62.0456 79.5728 61.2829 80.536 61.2829C81.4992 61.2829 82.1829 62.0587 82.1829 62.989V63.0055Z" fill="#D0D1DB"/>
                                <path d="M89.1561 62.5713L87.7261 60.2734H86.4375V65.7074H87.6111V62.1834L89.1233 64.4813H89.1561L90.6848 62.1604V65.7074H91.8715V60.2734H90.5829L89.1561 62.5713Z" fill="#D0D1DB"/>
                                <path d="M97.3381 60.2734H95.1191V65.7074H96.3157V64.0769H97.223C98.4427 64.0769 99.419 63.426 99.419 62.167V62.1505C99.419 61.0394 98.6366 60.2734 97.3381 60.2734ZM98.206 62.19C98.206 62.6568 97.8575 63.0118 97.2592 63.0118H96.3125V61.3517H97.2362C97.8345 61.3517 98.206 61.6377 98.206 62.1735V62.19Z" fill="#D0D1DB"/>
                                <path d="M103.562 60.2344L101.234 65.7078H102.454L102.95 64.4882H105.248L105.745 65.7078H106.994L104.666 60.2344H103.565H103.562ZM103.378 63.433L104.101 61.6709L104.824 63.433H103.381H103.378Z" fill="#D0D1DB"/>
                                <path d="M113.421 63.62L110.877 60.2734H109.775V65.7074H110.956V62.2524L113.585 65.7074H114.601V60.2734H113.421V63.62Z" fill="#D0D1DB"/>
                                <path d="M119.983 62.4562L118.684 60.2734H117.287L119.378 63.5641V65.7074H120.571V63.5411L122.659 60.2734H121.301L119.983 62.4562Z" fill="#D0D1DB"/>
                            </svg>
                        </a>
                    </div>
                    <div class="footer-nav-wrapper medium-7">
                            <?php 
                                wp_nav_menu(array(
                                    'theme_location' => 'footer_menu_five',
                                    'container' => false,
                                    'menu_class' => 'footer-nav',
                                ));
                            ?>
                    </div>
                </div>
                <div class="copyright-wrapper">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo $copyrightText; ?></p>
                </div>
            </div>
        </div>
    </footer>
</section>
<?php 
    /* Terms Popup for Funds */
    if(is_page(1729) || is_page(1736))
    {
        $fundModalCopy = get_field('fund_information_modal_copy', 'option');
?>
<section class="fund-information-modal" id="fund-modal">
    <div class="information-modal-inner">
        <?php echo $fundModalCopy; ?>
        <ul class="btn-list">
            <li><a class="btn btn-transp modal-redirect-btn">Decline</a></li>
            <li><a class="btn btn-primary modal-accept-btn">Continue</a></li>
        </ul>
    </div>
</section>
<?php 
    } 
?>
<?php wp_footer(); ?>
</body>