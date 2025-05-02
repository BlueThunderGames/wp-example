<section class="fund-sheets-container breadcrumbs-only">
    <div class="grid-container">
        <div class="funds-upper-actions">
            <div class="grid-x">
                <div class="crumb-wrapper">
                    <?php 
                        if(function_exists('yoast_breadcrumb')) 
                        {
                            yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>