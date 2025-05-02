<?php 
/* Template Name: Script Template */
    get_header();

?>
<section class="general-content-block">
    <div class="grid-container">
        <?php 
        /* Script to find all media attachments by url and associate them as File fields to their respective posts 
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
            );

            $postQuery = new WP_Query($args);

            if($postQuery->have_posts())
            {
                while($postQuery->have_posts())
                {
                    $postQuery->the_post();

                    $resourceID = get_the_id();
                    $postLink = get_the_permalink();
                    $postTitle = get_the_title();

                    $fileName = trim(get_field('resource_file_name', $resourceID));

                    if($fileName) 
                    {
                        $cleanFileName = preg_replace('/[()%,]/', '', $fileName);

                        $fileReference = 'https://ggt.chariotcr.com/wp-content/uploads/2024/12/' . $cleanFileName;

                        $attachmentID = attachment_url_to_postid($fileReference);

                        if($attachmentID)
                        {
                            update_field('resource_file', $attachmentID, $resourceID);
                        }
                    }
                }
            }
        */
        ?>
        <?php 
        /* Script for making child families 
            $allFundArgs = array(
                'post_type' => 'funds',
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'orderby' => 'menu_order',
                'order' => 'ASC',
            );
        
            $allFunds = new WP_Query($allFundArgs);
        
            if($allFunds->have_posts())
            {
                while($allFunds->have_posts())
                {
                    $allFunds->the_post();
        
                    $fundID = get_the_ID();
                    $fundName = get_the_title();
                    $fundCategories = get_the_terms(get_the_ID(), 'family');
        
                    $parentFund = '';
                    $parentCounter = 0;
        
                    if(isset($fundCategories) && !empty($fundCategories))
                    {
                        foreach($fundCategories as $fundCategory)
                        {
                            $parentCounter++;
        
                            $parentFund = $fundCategory->term_id;
                        }
                    }
        
                    if($parentFund != '')
                    {
                        $existingFund = get_term_by('name', $fundName, 'family');
        
                        if($existingFund == false)
                        {
                           $newFundID =  wp_insert_term($fundName, 'family', array('parent' => $parentFund));
        
                            wp_set_object_terms($fundID, $newFundID['term_id'], 'family');
                        }
                        else 
                        {
                            $existingFundID = $existingFund->term_id;
        
                            wp_set_object_terms($fundID, $existingFundID, 'family');
                        }
                    }
                }
            }
            */

            /*
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
            );

            $postQuery = new WP_Query($args);

            if($postQuery->have_posts())
            {
                while($postQuery->have_posts())
                {
                    $postQuery->the_post();
                    $postID = get_the_id();

                    $resourceType = get_field('resource_type');

                    if($resourceType == 'Article')
                    {
                        wp_set_object_terms($postID, 1657, 'types');
                    }
                }
            }
                */
            ?>
    </div>
</section>
<?php 
    get_footer(); 
?>