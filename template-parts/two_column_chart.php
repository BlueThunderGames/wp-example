<?php 
    $leftTitle = strip_tags(get_sub_field('left_column_title'), '<strong>');
    $rightTitle = strip_tags(get_sub_field('right_column_title'), '<strong>');

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
<section class="two-column-chart-container" style="<?php echo $topPaddingStyle; ?><?php echo $bottomPaddingStyle; ?>">
    <div class="grid-container">
        <div class="desktop-charts">
            <div class="grid-x desktop-chart-titles">
                <div class="medium-6 left-chart-title">
                    <h4><?php echo $leftTitle; ?></h4>
                </div>
                <div class="medium-6 right-chart-title">
                    <h4><?php echo $rightTitle; ?></h4>
                </div>
            </div>
            <div class="charts-wrapper">
                <?php  
                    $itemsArray = array();
                    $itemsArrayCounter = 0;
                    $leftCounter = 1;
                    $rightCounter = 2;

                    while(have_rows('left_column_items'))
                    {
                        the_row();

                        $itemCopy = get_sub_field('item_copy');

                        $itemsArray[$itemsArrayCounter]['copy'] = $itemCopy;
                        $itemsArray[$itemsArrayCounter]['number'] = $leftCounter;

                        $itemsArrayCounter++;
                        $leftCounter = $leftCounter + 2;
                    }

                    while(have_rows('right_column_items'))
                    {
                        the_row();

                        $itemCopy = get_sub_field('item_copy');

                        $itemsArray[$itemsArrayCounter]['copy'] = $itemCopy;
                        $itemsArray[$itemsArrayCounter]['number'] = $rightCounter;

                        $itemsArrayCounter++;
                        $rightCounter = $rightCounter + 2;
                    }

                    if(isset($itemsArray) && !empty($itemsArray))
                    {
                        usort($itemsArray, function($a, $b) {
                            return $a['number'] <=> $b['number'];
                        });

                        $columnCounter = 0;
                        $numColumns = count($itemsArray);
                        foreach($itemsArray as $item)
                        {
                            $columnCounter++;
                            
                            if($columnCounter == 1)
                            {
                                echo '<div class="chart-row grid-x">';
                            }

                            $chartClass = 'left-chart';

                            if($item['number'] % 2 == 0)
                            {
                                $chartClass = 'right-chart';
                            }

                            echo '<div class="medium-6 '.$chartClass.'"><div class="chart-item"><div class="item-copy">'.$item['copy'].'</div></div></div>';


                            if($columnCounter %2 == 0 && $columnCounter != $numColumns) 
                            {
                                echo '<div class="line"></div></div><div class="chart-row grid-x">';
                            }
                            elseif($columnCounter == $numColumns)
                            {
                                echo '<div class="line"></div></div>';
                            }
                            
                        }
                    }
                ?>
                <div class="final-line"></div>
            </div>
        </div>
        <div class="grid-x mobile-charts">
            <div class="medium-6 chart-column left-chart">
                <h4><?php echo $leftTitle; ?></h4>
                <div class="chart-items left-items">
                    <?php  
                        while(have_rows('left_column_items'))
                        {
                            the_row();

                            $itemCopy = get_sub_field('item_copy');

                            echo '<div class="chart-item"><div class="item-copy">'.$itemCopy.'</div><span class="line"></span></div>';
                        }
                    ?>
                </div>
                <div class="final-line"></div>
            </div>
            <div class="medium-6 chart-column right-chart">
                <h4><?php echo $rightTitle; ?></h4>
                <!-- Add your chart or content for the right column here -->
                <div class="chart-items right-items">
                    <?php  
                        while(have_rows('right_column_items'))
                        {
                            the_row();

                            $itemCopy = get_sub_field('item_copy');

                            echo '<div class="chart-item"><span class="line"></span><div class="item-copy">'.$itemCopy.'</div></div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>