<?php 
    $copy = get_sub_field('copy');

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
<section class="overlapping-copy-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>" data-aos="fade" data-aos-offset="300">
    <div class="background"></div>
    <div class="grid-container">
        <div class="copy-wrapper">
            <div class="copy-inner">
                <?php echo $copy; ?>
            </div>
        </div>
    </div>
</section>