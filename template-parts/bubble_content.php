<?php 
    $heading = get_sub_field('heading');
    $upperContent = get_sub_field('upper_content');
    $leftContent = get_sub_field('left_column_content');
    $rightContent = get_sub_field('right_column_content');   
?>
<section class="bubble-content-container">
    <div class="content-wrapper">
        <div class="main-content">
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
            <div class="grid-container">
                <h2><?php echo $heading; ?></h2>
                <div class="content-wrapper">
                    <?php if(isset($upperContent) && $upperContent != ''){ ?>
                        <div class="upper-content">
                            <?php echo $upperContent; ?>
                        </div>
                    <?php } ?>
                    <?php if((isset($leftContent) && $leftContent != '') || (isset($rightContent) && $rightContent != '')){ ?>
                    <div class="grid-x">
                        <div class="medium-6">
                            <?php echo $leftContent; ?>
                        </div>
                        <div class="medium-6">
                            <?php echo $rightContent; ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>