<?php 
    $greenColLabel = get_sub_field('green_column_label');
    $blackColLabel = get_sub_field('black_column_label');

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
<section class="three-col-chart-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <div class="chart-title-row grid-x">
            <div class="chart-title-column">
                <h4><?php echo $greenColLabel; ?></h4>
            </div>
            <div class="chart-title-column">
                <h4><?php echo $blackColLabel; ?></h4>
            </div>
        </div>
        <?php if(have_rows('table_rows')){ ?>
        <div class="chart-wrapper">
            <?php 
                while(have_rows('table_rows'))
                {
                    the_row();

                    $leftColCopy = get_sub_field('left_column_copy');
                    $middleColCopy = get_sub_field('middle_column_copy');
                    $rightColCopy = get_sub_field('right_column_copy');

                    echo '
                    <div class="chart-row grid-x">
                        <div class="chart-cell">
                            '.$leftColCopy.'
                        </div>
                        <div class="chart-cell">
                            <div class="chart-cell-inner">
                                <h4 class="mobile-chart-label">'.$greenColLabel.'</h4>
                                '.$middleColCopy.'
                            </div>
                        </div>
                        <div class="chart-cell">
                            <div class="chart-cell-inner">
                                <h4 class="mobile-chart-label">'.$blackColLabel.'</h4>
                                '.$rightColCopy.'
                            </div>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
        <?php } ?>
    </div>
</section>