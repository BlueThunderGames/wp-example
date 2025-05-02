<?php 
    $img = get_sub_field('overlapping_image');
    $copy = get_sub_field('copy');
    $imgSide = get_sub_field('image_side');

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
?>
<section class="overlapping-img-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <div class="grid-x">
            <?php if($imgSide == 'Left'){ ?>
            <div class="left-col img" data-aos="fade" data-aos-offset="350">
                <div class="img-wrapper">
                    <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>">
                </div>
            </div>
            <div class="right-col copy-column" data-aos="fade" data-aos-delay="300" data-aos-offset="350">
                <div class="copy">
                    <?php echo $copy; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($imgSide == 'Right'){ ?>
                <div class="left-col copy-column" data-aos="fade" data-aos-delay="300" data-aos-offset="350">
                <div class="copy">
                    <?php echo $copy; ?>
                </div>
            </div>
            <div class="right-col img" data-aos="fade" data-aos-offset="350">
                <div class="img-wrapper">
                    <img src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" >
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>