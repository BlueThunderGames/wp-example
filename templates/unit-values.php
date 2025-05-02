<?php 
/* Template Name: Unit Values */

    $documentID = $_GET['id'];

    if(!isset($documentID))
    {
        wp_redirect('/cit-fund-info/collective-funds-fact-sheets/');
        exit;
    }
    else 
    {
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
        else 
        {
            wp_redirect('/cit-fund-info/collective-funds-fact-sheets/');
            exit();
        }
    }

    get_header();

    $pageHeading = get_field('page_heading');
?>
<section class="page-intro-container <?php echo $moduleClass; ?>">
    <div class="page-intro-upper">
        <div class="grid-container">
            <div class="upper-wrapper" style="width:800px;margin:0 auto;">
                <div class="title-wrapper" data-aos="fade-right" data-aos-delay="400">
                    <h1><?php echo $pageHeading; ?> <?php echo $documentTitle; ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
           // the_content();

           if(have_rows('modules'))
           {
                while(have_rows('modules'))
                {
                    the_row();

                    $moduleName = get_row_layout();

                    include get_template_directory() . '/template-parts/'.$moduleName.'.php';
                }
           }
        ?>
    <?php endwhile;
endif;
wp_reset_query(); ?>
<?php 
    get_footer(); 
?>