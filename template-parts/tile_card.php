<?php 
    $upperCopy = get_sub_field('upper_copy');
    $leftCopy = get_sub_field('left_column_copy');
    $rightCopy = get_sub_field('right_column_copy');

    $overlapLower = get_sub_field('overlap_lower_module');
    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';
    $overlapClass = '';

    if(isset($overlapLower) && $overlapLower == true)
    {
        $overlapClass = 'overlap-lower';
    }

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
<section class="tile-card-container">
    <div class="grid-container">
        <div class="tile-card-wrapper <?php echo $overlapClass; ?> <?php echo $bgClass; ?>" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
            <?php if(isset($upperCopy) && $upperCopy != ''){ ?>
                <div class="upper-copy">
                    <?php echo $upperCopy; ?>
                </div>
            <?php } ?>
            <div class="grid-x">
                <?php if(isset($leftCopy) && $leftCopy != ''){ ?>
                <div class="left-copy">
                    <?php echo $leftCopy; ?>
                </div>
                <?php } ?>
                <?php if(isset($rightCopy) && $rightCopy != ''){ ?>
                <div class="right-copy">
                    <?php echo $rightCopy; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>