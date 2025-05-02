<?php 
    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';
    $pdfSource = get_sub_field('pdf_source');

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }

    $hideSearch = get_sub_field('hide_search');
    $searchPlaceholder = 'Search';
    $searchFieldText = get_sub_field('search_field_text');

    if(isset($searchFieldText) && $searchFieldText != '')
    {
        $searchPlaceholder = $searchFieldText;
    }
?>
<section class="fund-sheets-container pdfs-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
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
                <?php if(!isset($hideSearch) || $hideSearch == false){ ?>
                <div class="fund-search-wrapper">
                    <form action="/" method="POST" id="pdf-search-form">
                        <label for="pdf-search">Search</label>
                        <input type="text" name="pdf_search" id="pdf-search" placeholder="<?php echo $searchPlaceholder; ?>">
                        <button type="submit" id="pdf-search-submit">Search
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                            <path d="M17.549 20.1631C15.7323 21.457 13.5102 22.219 11.1095 22.219C4.97462 22.219 0 17.2444 0 11.1095C0 4.97462 4.97462 0 11.1095 0C17.2444 0 22.219 4.97462 22.219 11.1095C22.219 13.5105 21.457 15.7325 20.1631 17.549L27.4628 24.8487C28.1816 25.5676 28.1765 26.7191 27.4628 27.4314L27.4327 27.4615C26.7218 28.1725 25.5623 28.1752 24.85 27.4615L17.5503 20.1618L17.549 20.1631ZM11.1095 19.605C15.8015 19.605 19.605 15.8018 19.605 11.1095C19.605 6.4172 15.8018 2.614 11.1095 2.614C6.4172 2.614 2.614 6.4172 2.614 11.1095C2.614 15.8018 6.4172 19.605 11.1095 19.605Z" fill="#2F3942"/>
                        </svg>
                        </button>
                        <div class="fund-results-wrapper">
                        
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            $numberOfItems = 0;
            $pdfArray = array();
            $pdfCounter = 0;

            if($pdfSource == 'Manual Links')
            {
                if(have_rows('pdfs'))
                {
                    while(have_rows('pdfs'))
                    {
                        the_row();
        
                        $numberOfItems++;
        
                        $pdfName = get_sub_field('pdf_name');
                        $pdfFile = get_sub_field('pdf_file');
        
                        $pdfArray[$pdfCounter]['name'] = $pdfName;
                        $pdfArray[$pdfCounter]['file'] = $pdfFile;
        
                        $pdfCounter++;
                    }
                }
            }
            elseif($pdfSource == 'Perspectives')
            {
                $pdfCategory = get_sub_field('perspectives_source_category');

                $pdfArgs = array(
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'meta_query' => array( 
                        array(
                            'key' => 'resource_file',
                            'compare' => 'EXISTS'
                        )
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $pdfCategory
                        )
                    ),
                    'orderby' => 'title',
                    'order' => 'ASC'
                );

                $pdfPosts = new WP_Query($pdfArgs);

                if($pdfPosts->have_posts())
                {
                    while($pdfPosts->have_posts())
                    {
                        $pdfPosts->the_post();

                        $pdfName = get_the_title();
                        $pdfFile = get_field('resource_file');

                        if(isset($pdfFile) && !empty($pdfFile))
                        {
                            $pdfArray[$pdfCounter]['name'] = $pdfName;
                            $pdfArray[$pdfCounter]['file'] = $pdfFile;

                            $pdfCounter++;
                        }
                    }
                }

                wp_reset_query();
            }

            $numberOfItems = count($pdfArray);
            $itemsPerColumn = ceil($numberOfItems / 2);
            $leftCounter = 0;
            $rightCounter = 0;
        ?>
        <?php if(!empty($pdfArray)){ ?>
        <div class="pdfs-wrapper">
            <div class="grid-x">
                <div class="left-col medium-6">
                        <ul class="pdf-list">
                            <?php 
                                foreach($pdfArray as $key => $pdfItem)
                                {
                                    if($leftCounter == $itemsPerColumn)
                                    {
                                        break;
                                    }

                                    $leftCounter++;

                                    $pdfName = $pdfItem['name'];
                                    $pdfFile = $pdfItem['file'];

                                    echo '
                                    <li>
                                        <a href="'.$pdfFile['url'].'" target="_blank" class="pdf-link">
                                            <span class="pdf-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="30" viewBox="0 0 22 30" fill="none">
                                                    <path d="M5.96582 10.0299H11.8371" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5.96582 13.1931H16.352" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5.96582 16.3518H16.352" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M1.90117 29H20.4161C20.9168 29 21.3173 28.5949 21.3173 28.0988V6.87126L15.4506 1H1.90117C1.40052 1 1 1.40507 1 1.90117V28.0943C1 28.5949 1.40507 28.9954 1.90117 28.9954V29Z" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M21.3224 6.87125H15.9018C15.6514 6.87125 15.4512 6.67099 15.4512 6.42066V4.61377" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </span>
                                            '.$pdfName.'
                                        </a>
                                    </li>
                                    ';

                                    unset($pdfArray[$key]);
                                }
                            ?>
                        </ul>
                </div>
                <?php if($numberOfItems > 1){ ?>
                <div class="right-col medium-6">
                    <ul class="pdf-list">
                        <?php 
                            foreach($pdfArray as $key => $pdfItem)
                            {
                                $rightCounter++;

                                $pdfName = $pdfItem['name'];
                                $pdfFile = $pdfItem['file'];

                                echo '
                                <li>
                                    <a href="'.$pdfFile['url'].'" target="_blank" class="pdf-link">
                                        <span class="pdf-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="30" viewBox="0 0 22 30" fill="none">
                                                <path d="M5.96582 10.0299H11.8371" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5.96582 13.1931H16.352" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5.96582 16.3518H16.352" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M1.90117 29H20.4161C20.9168 29 21.3173 28.5949 21.3173 28.0988V6.87126L15.4506 1H1.90117C1.40052 1 1 1.40507 1 1.90117V28.0943C1 28.5949 1.40507 28.9954 1.90117 28.9954V29Z" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M21.3224 6.87125H15.9018C15.6514 6.87125 15.4512 6.67099 15.4512 6.42066V4.61377" stroke="#2F3942" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                        '.$pdfName.'
                                    </a>
                                </li>
                                ';

                                unset($pdfArray[$key]);
                            }
                        ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>