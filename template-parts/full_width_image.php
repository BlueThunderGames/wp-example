<?php 
    $bgImg = get_sub_field('background_image');

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
<section class="full-bg-img-container" style="background-image:url(<?php echo $bgImg; ?>);<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>"></section>