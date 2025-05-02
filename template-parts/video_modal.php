<?php 
    $videoUrl = get_sub_field('video_url');
    $videoThumb = get_sub_field('video_thumbnail');
    $videoFile = get_sub_field('video_file');
    $videoLink = '';

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

    if(isset($videoUrl) && $videoUrl != '')
    {
        $videoLink = $videoUrl;
    }
    else if(isset($videoFile) && $videoFile != '')
    {
        $videoLink = $videoFile['url'];
    }
?>
<section class="video-modal-container">
    <a href="<?php echo $videoLink; ?>" data-fancybox class="video" style="background-image:url(<?php echo $videoThumb; ?>);<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
        <div class="video-shade"></div>
        <span class="video-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="148" height="148" viewBox="0 0 148 148" fill="none">
                <circle cx="74" cy="74" r="73.5" stroke="#F7F6FB"/>
                <path d="M96 74L60 94.7846L60 53.2154L96 74Z" fill="#D9D9D9"/>
            </svg>
        </span>
        <span class="watch-copy">
            Watch Video
        </span>
    </a>
</section>