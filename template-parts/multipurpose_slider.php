<?php 
    $upperCopy = get_sub_field('upper_copy');
    $sliderType = get_sub_field('slider_type');

    $quoteHTML = '';
    $nameHTML = '';
    $sliderClass = 'general';

    if($sliderType == 'Testimonials')
    {
        $sliderClass = 'testimonial';
        $quoteHTML = '
        <div class="quote">
            <svg xmlns="http://www.w3.org/2000/svg" width="116" height="92" viewBox="0 0 116 92" fill="none">
                <path d="M50.3771 1.13306L50.5518 0.5H49.8951H23.5874H23.2503L23.1239 0.812571L7.71127 38.9302L7.70969 38.9342C5.76004 43.8778 4.2518 47.8545 3.18605 50.8624C2.1167 53.8805 1.39843 56.5579 1.03781 58.8912C0.678979 61.0369 0.5 63.2694 0.5 65.5882C0.5 73.2914 2.93252 79.6014 7.82196 84.4719L7.82851 84.4784L7.83531 84.4847C12.8978 89.1674 19.2236 91.5 26.7762 91.5C34.1551 91.5 40.3066 89.165 45.1923 84.4785L45.1925 84.4782C50.2617 79.609 52.7867 73.2971 52.7867 65.5882C52.7867 57.7132 50.3565 51.4806 45.4509 46.956C43.5008 45.1573 41.3221 43.7199 38.9179 42.6416L50.3771 1.13306ZM113.09 1.13306L113.265 0.5H112.608H86.3007H85.9635L85.8372 0.812571L70.4246 38.9302L70.423 38.9342C68.4733 43.8778 66.9651 47.8545 65.8993 50.8624C64.83 53.8805 64.1117 56.5579 63.7511 58.8911C63.3923 61.0369 63.2133 63.2694 63.2133 65.5882C63.2133 73.2914 65.6458 79.6014 70.5352 84.4719L70.5418 84.4784L70.5486 84.4847C75.611 89.1674 81.9369 91.5 89.4895 91.5C96.8684 91.5 103.02 89.165 107.906 84.4785L107.906 84.4782C112.975 79.609 115.5 73.2971 115.5 65.5882C115.5 57.7132 113.07 51.4806 108.164 46.956C106.214 45.1573 104.035 43.7199 101.631 42.6416L113.09 1.13306Z" stroke="#336D81"/>
            </svg>
        </div>
        ';
    }

    $topPadding = get_sub_field('top_padding');
    $topPaddingStyle = '';

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    $bgStyle = get_sub_field('background_style');
    $bgClass = '';

    if(isset($bgStyle) && $bgStyle != '')
    {
        if($bgStyle == 'Transparent') 
        {
            $bgClass = 'transparent-bg';
        }
    }

    if(have_rows('slides')){
?>
<section class="testimonial-slider <?php echo $bgClass; ?>" style="<?php echo $topPaddingStyle; ?>">
    <div class="grid-container">
        <div class="heading">
            <?php echo $upperCopy; ?>
        </div>
    </div>
    <div class="stat-slide-outer">
        <div class="stat-slide-inner">
            <div class="slider-wrapper <?php echo $sliderClass; ?> swiper">
                <div class="swiper-wrapper">
                    <?php 
                        $totalSlides = 0;

                        while(have_rows('slides'))
                        {
                            the_row();

                            $totalSlides++;

                            $slideContent = get_sub_field('slide_content');
                            $iconOverride = get_sub_field('quote_icon_override');
                            $overrideClass = '';

                            if($sliderType == 'Testimonials')
                            {
                                $name = get_sub_field('testimonial_name');

                                if(isset($name) && $name != '')
                                {
                                    $nameHTML = '<div class="testimonial-name"><p>'.$name.'</p></div>';
                                }
                            }

                            if(isset($iconOverride) && !empty($iconOverride))
                            {
                                $iconExtension = pathinfo($iconOverride['url'], PATHINFO_EXTENSION);
                                $overrideClass = 'override-icon';

                                $quoteHTML = '
                                <div class="quote">';
                                if($iconExtension == 'svg')
                                {
                                    $quoteHTML .= file_get_contents($iconOverride['url']);
                                }
                                else
                                {
                                    $quoteHTML .= '<img src="'.$iconOverride.'" alt="Slide Icon">';
                                }
                                
                                $quoteHTML .= '</div>';
                            }

                            echo '
                            <div class="slide swiper-slide '.$overrideClass.'">
                                '.$quoteHTML.'
                                '.$slideContent.'
                                '.$nameHTML.'
                            </div>
                            ';
                        }
                    ?>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="progress-wrapper">
                <div class="progress-bg"></div>
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>
</section>
<?php } ?>