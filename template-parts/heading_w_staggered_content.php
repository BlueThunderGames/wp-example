<?php 
    $heading = get_sub_field('heading');
    $icon = get_sub_field('icon');
    $copy = get_sub_field('copy');

    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';
    $maxCopyWidth = get_sub_field('max_copy_width');

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }

    $copyWidthStyles = '';

    if(isset($maxCopyWidth) && $maxCopyWidth != '' && is_numeric($maxCopyWidth))
    {
        $copyWidthStyles = 'style="width: '.$maxCopyWidth.'px;"';
    }

    $displayWhiteBubble = get_sub_field('display_white_bubble');
?>
<section class="heading-staggered-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <?php if(isset($displayWhiteBubble) && $displayWhiteBubble == true){ ?>
        <div class="bubble">
            <svg viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg" width="300" height="300">
                <defs>
                    <clipPath id="theClipPath">
                        <circle id="masker" r="0" fill="purple" cx="75" cy="75"/>
                    </clipPath>
                </defs>
                <g id="clipPathReveal" clip-path="url(#theClipPath)">
                    <circle r="6000" fill="#F7F6FB" cx="75" cy="75"/>
                </g>
            </svg>
        </div>
    <?php } ?>
    <div class="grid-container">
        <?php 
            $upperClass = '';

            if(isset($icon) && $icon != '' && isset($heading) && $heading != '')
            {
                $upperClass = 'grid-x';
            }
        ?>
        <div class="upper-content <?php echo $upperClass; ?>">
            <?php if(isset($heading) && $heading != ''){ ?> 
            <div class="heading-wrapper" data-aos="fade-right" data-aos-offset="250">
                <?php echo $heading; ?>
            </div>
            <?php } ?>
            <?php if(isset($icon) && $icon != ''){ ?>
            <div class="icon-wrapper" data-aos="fade-left" data-aos-offset="250">
                <img src="<?php echo $icon; ?>" alt="Icon" />
            </div>
            <?php } ?>
        </div>
        <?php if(isset($copy) && $copy != ''){ ?>
        <div class="lower-content" data-aos="fade" data-aos-offset="300" <?php echo $copyWidthStyles; ?>>
            <?php echo $copy; ?>
        </div>
        <?php } ?>
    </div>
</section>