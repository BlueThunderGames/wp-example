<?php 
/* Template Name: Generic Content */
    get_header();

?>
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