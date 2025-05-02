<?php 
    $displayWhiteBubble = get_sub_field('display_white_bubble');

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
<?php if(have_rows('panels')){ ?>
<section class="scroll-panels-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="scroll-panels-inner">
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
            <div class="scroll-panels-wrapper">
                <?php 
                    $panelCounter = 0;
                    while(have_rows('panels'))
                    {
                        the_row();
                        $panelCounter++;

                        $panelColor = get_sub_field('panel_color');
                        $panelHeading = get_sub_field('panel_heading');
                        $panelCopy = get_sub_field('panel_copy');
                        $fontStyle = strtolower(get_sub_field('font_style'));
                        $panelClass = '';

                        $headingHTML = '';

                        if($panelHeading != '')
                        {
                            $headingHTML = ''.$panelHeading.'';
                        }

                        if($panelCounter == 1)
                        {
                            $panelClass = 'first-panel';
                        }

                        echo '
                        <div class="scroll-panel '.$fontStyle.' '.$panelClass.'" style="background-color:'.$panelColor.';">
                            '.$headingHTML.'
                            <div class="grid-x">
                                <div class="panel-inner">
                                    <div class="panel-content">
                                        '.$panelCopy.'
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>