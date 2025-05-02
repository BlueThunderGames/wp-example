<?php 
    $moduleStyle = get_sub_field('module_style');  
    $title = get_sub_field('title');
    $upperCopy = get_sub_field('upper_copy');
    $img = get_sub_field('large_image');
    $copyHeadline = get_sub_field('copy_headline');
    $copy = get_sub_field('copy');

    $moduleClass = '';
    $upperStyles = '';
    $upperStyleFull = '';

    if($moduleStyle == 'Title Only')
    {
        $moduleClass = 'title-only';

        $upperMaxWidth = get_sub_field('upper_copy_max_width');
        $centerUpperArea = get_sub_field('center_upper_area');

        if(isset($upperMaxWidth) && $upperMaxWidth != '')
        {
            $upperStyles .= 'max-width:'.$upperMaxWidth.'px;';
        }

        if(isset($centerUpperArea) && $centerUpperArea == 1)
        {
            $upperStyles .= 'margin:0 auto;';
        }

        if($upperStyles != '')
        {
            $upperStyleFull = 'style="'.$upperStyles.'"';
        }
    }
    elseif($moduleStyle == 'Image on Right') 
    {
        $moduleClass = 'image-right';
    }
    elseif($moduleStyle == 'Image on Left') 
    {
        $moduleClass = 'image-left';
    }
?>
<section class="page-intro-container <?php echo $moduleClass; ?>">
    <div class="page-intro-upper">
        <div class="grid-container">
            <?php if($moduleStyle == 'Title Only'){ ?>
            <div class="upper-wrapper-container">
                <div class="upper-wrapper" <?php echo $upperStyleFull; ?>>
                    <div class="title-wrapper" data-aos="fade-right" data-aos-delay="400">
                        <h1><?php echo $title; ?></h1>
                    </div>
                    <?php if(isset($upperCopy) && $upperCopy != ''){ ?>
                    <div class="upper-copy" data-aos="fade-right" data-aos-delay="400">
                        <?php echo $upperCopy; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php }else{ ?>
            <div class="title-wrapper" data-aos="fade-right" data-aos-delay="400">
                <h1><?php echo $title; ?></h1>
            </div>
            <?php if(isset($upperCopy) && $upperCopy != ''){ ?>
            <div class="upper-copy" data-aos="fade-right" data-aos-delay="400">
                <?php echo $upperCopy; ?>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
    <?php if($moduleStyle == 'Image on Right'){ ?>
    <div class="copy-wrapper-transp">
        <div class="img" data-aos="fade-left" data-aos-delay="250"  style="background-image:url(<?php echo $img; ?>);"></div>
        <div class="grid-container">
            <div class="grid-x">
                <div class="medium-6 copy-column" data-aos="fade-right"  data-aos-offset="-500" data-aos-delay="500">
                    <?php if(isset($copyHeadline) && $copyHeadline != ''){ ?>
                    <div class="headline-wrapper">
                        <h4><?php echo $copyHeadline; ?></h4>
                    </div>
                    <?php } ?>
                    <div class="copy">
                        <?php echo $copy; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php if($moduleStyle == 'Image on Left'){ ?>
    <div class="img" data-aos="fade-right" data-aos-delay="250" style="background-image:url(<?php echo $img; ?>);"></div>
    <div class="copy-wrapper-color">
        <div class="grid-container">
            <div class="grid-x">
                <div class="medium-6 copy-column" data-aos="fade-right" data-aos-offset="-500" data-aos-delay="500">
                    <?php if(isset($copyHeadline) && $copyHeadline != ''){ ?>
                    <div class="headline-wrapper">
                        <h4><?php echo $copyHeadline; ?></h4>
                    </div>
                    <?php } ?>
                    <div class="copy">
                        <?php echo $copy; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="color-bg"></div>
    </div>
    <?php } ?>
</section>