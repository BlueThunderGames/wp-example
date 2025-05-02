<?php 
function custom_theme_setup()
{
    add_theme_support('post-thumbnails');
    
    // Add Theme Settings page for ACF
    if (function_exists('acf_add_options_page')) {

        acf_add_options_page(array(
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug' => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect' => false,
        ));
    }

    // Register WordPress Navigation Menus
    register_nav_menus(array(
        'footer_menu' => 'Footer Menu',
        'footer_menu_two' => 'Footer Menu Two',
        'footer_menu_three' => 'Footer Menu Three',
        'footer_menu_four' => 'Footer Menu Four',
        'footer_menu_five' => 'Footer Menu Five',
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

// Register Custom Taxonomies for Funds
function register_custom_taxonomies()
{
    $familyLabels = array(
        'name' => _x('Fund Families', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Fund Family', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Fund Families', 'textdomain'),
        'all_items' => __('All Fund Families', 'textdomain'),
        'parent_item' => __('Parent Family', 'textdomain'),
        'parent_item_colon' => __('Parent Family:', 'textdomain'),
        'edit_item' => __('Edit Fund Family', 'textdomain'),
        'update_item' => __('Update Fund Family', 'textdomain'),
        'add_new_item' => __('Add New Fund Family', 'textdomain'),
        'new_item_name' => __('New Family Name', 'textdomain'),
        'menu_name' => __('Fund Families', 'textdomain'),
    );

    $familyArgs = array(
        'hierarchical' => true,
        'labels' => $familyLabels,
        'show_ui' => true,
        'show_admin_column' => true,
    );

    register_taxonomy(
        'family',
        'funds',
        $familyArgs
    );

    $fundCatLabels = array(
        'name' => _x('Fund Categories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Fund Category', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Fund Categories', 'textdomain'),
        'all_items' => __('All Fund Categories', 'textdomain'),
        'parent_item' => __('Parent Category', 'textdomain'),
        'parent_item_colon' => __('Parent Category:', 'textdomain'),
        'edit_item' => __('Edit Category', 'textdomain'),
        'update_item' => __('Update Category', 'textdomain'),
        'add_new_item' => __('Add New Category', 'textdomain'),
        'new_item_name' => __('New Category Name', 'textdomain'),
        'menu_name' => __('Categories', 'textdomain'),
    );

    $fundCatArgs = array(
        'hierarchical' => true,
        'labels' => $fundCatLabels,
        'show_ui' => true,
        'show_admin_column' => true,
    );

    register_taxonomy(
        'fund_categories',
        'funds',
        $fundCatArgs
    );

    $postTypeCatLabels = array(
        'name' => _x('Types', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Type', 'taxonomy singular name', 'textdomain'),
        'search_items' => __('Search Types', 'textdomain'),
        'all_items' => __('All Types', 'textdomain'),
        'parent_item' => __('Parent Type', 'textdomain'),
        'parent_item_colon' => __('Parent Type:', 'textdomain'),
        'edit_item' => __('Edit Type', 'textdomain'),
        'update_item' => __('Update Type', 'textdomain'),
        'add_new_item' => __('Add New Type', 'textdomain'),
        'new_item_name' => __('New Type Name', 'textdomain'),
        'menu_name' => __('Types', 'textdomain'),
    );

    $postTypeCatArgs = array(
        'hierarchical' => true,
        'labels' => $postTypeCatLabels,
        'show_ui' => true,
        'show_admin_column' => true,
    );

    register_taxonomy(
        'types',
        'post',
        $postTypeCatArgs
    );
}
add_action('init', 'register_custom_taxonomies');

// Register Custom Post Type for Funds
function register_custom_posts()
{
    register_post_type(
        'funds',
        array(
            'labels' => array(
                'name' => __('Funds'),
                'singular_name' => __('Fund'),
                'menu_name' => __('Funds'),
                'name_admin_bar' => __('Fund'),
                'add_new' => __('Add New Fact Sheet'),
                'add_new_item' => __('Add New Fact Sheet'),
                'new_item' => __('New Fact Sheet'),
                'edit_item' => __('Edit Fact Sheet'),
                'view_item' => __('View Fact Sheet'),
                'all_items' => __('All Funds'),
                'search_items' => __('Search Funds'),
                'parent_item_colon' => __('Parent Funds:'),
                'not_found' => __('No funds found.'),
                'not_found_in_trash' => __('No funds found in Trash.'),
            ),
            'public' => true,
            'query_var' => true,
            'has_archive' => false,
        )
    );

}
add_action('init', 'register_custom_posts');


// Update Labels for Default Post Type
function update_post_type_labels($args, $post_type) {
    if ($post_type === 'post') {
        $args['labels'] = array(
            'name' => __('Resources'),
            'singular_name' => __('Resource'),
            'menu_name' => __('Resources'),
            'name_admin_bar' => __('Resource'),
            'add_new' => __('Add New Resource'),
            'add_new_item' => __('Add New Resource'),
            'new_item' => __('New Resource'),
            'edit_item' => __('Edit Resource'),
            'view_item' => __('View Resource'),
            'all_items' => __('All Resources'),
            'search_items' => __('Search Resources'),
            'parent_item_colon' => __('Parent Resources:'),
            'not_found' => __('No Resources found.'),
            'not_found_in_trash' => __('No Resources found in Trash.'),
        );
    }
    return $args;
}
add_filter('register_post_type_args', 'update_post_type_labels', 10, 2);