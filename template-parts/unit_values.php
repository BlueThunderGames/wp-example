<?php 
    $documentID = $_GET['id'];

    $documentArgs = array(
        'post_type' => 'funds',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'document_id',
                'value' => $documentID,
                'compare' => '='
            )
        )
    );

    $documentQuery = new WP_Query($documentArgs);  
    $documentTitle = '';

    if($documentQuery->have_posts())
    {
        while($documentQuery->have_posts())
        {
            $documentQuery->the_post();

            $documentTitle = get_the_title();
        }
    }
?>
<section class="fund-sheets-container unit-values-container">
    <div class="grid-container">
        <div class="funds-upper-actions">
            <div class="grid-x">
                <div class="crumb-wrapper">
                    <?php 
                        if(function_exists('yoast_breadcrumb')) 
                        {
                            yoast_breadcrumb( '<p id="breadcrumbs">','<span class="final-crumb">For '.$documentTitle.'</span></p>' );
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="values-data-wrapper">
        <div class="heading_uv">Daily <span class="r_data">{[data.fundClass]}</span></div><!--<br clear="all" /> -->
        <div class="pone_c extra-space">
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.dailyList[0].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.dailyList[0].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.dailyList[1].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.dailyList[1].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.dailyList[2].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.dailyList[2].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.dailyList[3].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.dailyList[3].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.dailyList[4].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.dailyList[4].unitValue]}</span></div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
        </div>

        <!-- <br clear="all" /> -->
        <div class="heading_uv">Monthly <span class="r_data">{[data.fundClass]}</span></div><!--<br clear="all" /> -->

        <div class="pone_c">
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[0].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[0].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[1].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[1].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[2].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[2].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[3].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[3].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[4].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[4].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[5].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[5].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[6].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[6].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[7].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[7].unitValue]}</span></div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
        </div>

        <!--<br clear="all" />
        <br clear="all" /> -->

        <div class="pone_c extra-space">
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[8].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[8].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[9].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[9].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[10].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[10].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[11].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[11].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[12].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[12].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[13].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[13].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[14].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[14].unitValue]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.monthlyList[15].tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.monthlyList[15].unitValue]}</span></div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
        </div>

        <!-- <br clear="all" /> -->
        <div class="heading_uv">Year-End <span class="r_data">{[data.fundClass]}</span></div><!--<br clear="all" /> -->

        <div class="pone_c extra-space">
            <div class="cfour">
                <div class="pfour_c"><span class="r_data">{[data.yearEndVO.tradeDate]}</span></div>
                <div class="pfour"><span class="r_data">{[data.yearEndVO.unitValue]}</span></div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
            <div class="cfour disno">
                <div class="pfour_c">&nbsp;</div>
                <div class="pfour">&nbsp;</div>
            </div>
        </div>

        <!-- <br clear="all" /> -->
        <div class="heading_uv">2022 Performance</div><!--<br clear="all" /> -->

        <div class="pone_c">
            <div class="cfour">
                <div class="pfour_c">As Of</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.tradeDate]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">Class Name</div>
                <div class="pfour"><span class="r_data">{[data.fundClass]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">MTD</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.monthToDateReturnPct]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">QTD</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.quarterToDateReturnPct]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">YTD</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.yearToDateReturnPct]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">1 Year</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.oneYear]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">3 Year</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.threeYear]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">5 Year</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.fiveYear]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">10 Year</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.tenYear]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">Inception Annualized</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.inceptionAnnualized]}</span></div>
            </div>
            <div class="cfour">
                <div class="pfour_c">Inception Cumulative</div>
                <div class="pfour"><span class="r_data">{[data.asOfVO.inceptionCumulative]}</span> </div>
            </div>
        </div>
        </div>
    </div>
</section>
<?php 
    wp_reset_query();
?>