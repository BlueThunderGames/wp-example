<?php 
    $heading = get_sub_field('heading');
    $copy = get_sub_field('copy');
?>
<section class="home-banner-container">
    <div class="banner-shade"></div>
    <div class="banner-anim-wrapper">
        <div class="video-overlay"></div>
        <video id="bannerVideo" playsinline="true" <?php /* autoplay="true"  loop="true" */ ?> webkit-playsinline="true" preload="auto" muted="muted">
            <source type="video/mp4;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/videos/banner-vid-sequenced.mp4"></source>
        </video>
    </div>
    <div class="grid-container">
        <span><?php echo $heading; ?></span>
        <div class="grid-x content-wrapper">
            <div class="banner-content">
                <h1><?php echo $copy; ?></h1>
                <?php if(have_rows('buttons')){ ?>
                <ul>
                    <?php 
                        $btnCounter = 0;

                        while(have_rows('buttons'))
                        {
                            the_row();

                            $btnCounter++;

                            $button = get_sub_field('button');
                            $btnTarget = 'target="_self"';
                            $btnClass = 'btn-secondary';

                            if(isset($button['target']) && $button['target'] != '')
                            {
                                $btnTarget = 'target="'.$button['target'].'"';
                            }

                            if($btnCounter == 2)
                            {
                                $btnClass = 'btn-transp';
                            }

                            echo '<li><a href="'.$button['url'].'" class="btn '.$btnClass.'" '.$btnTarget.'>'.$button['title'].'</a></li>';
                        }
                    ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</section>