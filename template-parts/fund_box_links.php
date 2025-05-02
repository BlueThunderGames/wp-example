<?php 
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

    $numLinks = count(get_sub_field('box_links'));
    $numLinks = $numLinks - 1;

    if(have_rows('box_links')){
?>
<section class="box-links-wrapper" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <div class="box-links-inner">
            <?php 
                $boxCounter = 0;
                $boxColumnsCounter = 0;
                $boxClass = 'rounded-items';
            ?>
            <?php 
                while(have_rows('box_links'))
                {
                    the_row();

                    $boxLink = get_sub_field('link');
                    $linkTarget = 'target="_self"';

                    if(isset($boxLink['target']) && $boxLink['target'] != '')
                    {
                        $linkTarget = 'target="'.$boxLink['target'].'"';
                    }

                    $boxCounter++;

                    if($boxCounter == 1)
                    {
                        echo '<div class="grid-x box-row initial-row">';

                        echo '<a class="box-link" href="'.$boxLink['url'].'" '.$linkTarget.'><span class="box-title">'.$boxLink['title'].'</span></a>';

                        echo '</div>';
                    }
                    else 
                    {
                        $boxColumnsCounter++;

                        if($boxColumnsCounter == 1)
                        {
                            echo '<div class="grid-x box-row rounded-items">';
                        }

                        echo '<a class="box-link" href="'.$boxLink['url'].'" '.$linkTarget.'><span class="box-title">'.$boxLink['title'].'</span></a>';

                        if($boxColumnsCounter %2 == 0 && $boxColumnsCounter != $numLinks)
                        {
                            if($boxClass == 'rounded-items')
                            {
                                $boxClass = 'staggered-items';
                            }
                            else 
                            {
                                $boxClass = 'rounded-items';
                            }

                            echo '</div>';
                            echo '<div class="grid-x box-row '.$boxClass.'">';
                        }
                        elseif($boxColumnsCounter == $numLinks)
                        {
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
</section>
<?php } ?>