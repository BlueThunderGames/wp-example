<?php 
    $copy = get_sub_field('copy');
    $topPadding = get_sub_field('top_padding');
    $bottomPadding = get_sub_field('bottom_padding');
    $topPaddingStyle = '';
    $bottomPaddingStyle = '';
    $bgColor = get_sub_field('background_color');
    $bgColorStyle = '';
    $textColor = get_sub_field('text_color');
    $textColorStyle = '';

    if(isset($topPadding) && $topPadding != '' && is_numeric($topPadding))
    {
        $topPaddingStyle = 'padding-top: '.$topPadding.'vh;';
    }

    if(isset($bottomPadding) && $bottomPadding != '' && is_numeric($bottomPadding))
    {
        $bottomPaddingStyle = 'padding-bottom: '.$bottomPadding.'vh;';
    }

    if(isset($bgColor) && $bgColor != '')
    {
        $bgColorStyle = 'background-color: '.$bgColor.';';
    }

    if(isset($textColor) && $textColor != '')
    {
        $textColorStyle = 'style="color: '.$textColor.';"';
    }

?>
<section class="notice-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?><?php echo $bgColorStyle; ?>">
    <div class="grid-container">
        <div class="copy-container" <?php echo $textColorStyle; ?>>
            <?php echo $copy; ?>
        </div>
    </div>
</section>