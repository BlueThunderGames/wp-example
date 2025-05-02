<?php if(have_rows('slides')){ ?>
<section class="stat-slider-container">
    <div class="stat-slide-outer">
        <div class="stat-slide-inner">
            <div class="stat-slide-wrapper swiper">
                <div class="swiper-wrapper">
                    <?php 
                        while(have_rows('slides'))
                        {
                            the_row();

                            $greenHTML = '';
                            $leftHTML = '';
                            $rightHTML = '';

                            $greenText = get_sub_field('green_text');
                            $leftText = get_sub_field('left_column_text');
                            $finePrint = get_sub_field('fine_print');
                            $finePrintHTML = '';
                            $rightText = get_sub_field('right_column_text');

                            if($greenText != '')
                            {
                                $greenHTML = '<h2>'.$greenText.'</h2>';
                            }

                            if($leftText != '')
                            {
                                $leftHTML = '<p>'.$leftText.'</p>';
                            }

                            if($rightText != '')
                            {
                                $rightHTML = '<p>'.$rightText.'</p>';
                            }

                            if($finePrint != '')
                            {
                                $finePrintHTML = '<div class="fine-print"><p>'.$finePrint.'</p></div>';
                            }

                            echo '
                            <div class="stat-slide swiper-slide">
                                <div class="grid-x">
                                    <div class="stat-cell">
                                        '.$greenHTML.'
                                        '.$leftHTML.'
                                        '.$finePrintHTML.'
                                    </div>
                                    <div class="date-cell">
                                        '.$rightHTML.'
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="progress-wrapper">
                <div class="progress-bg"></div>
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>
</section>
<?php } ?>