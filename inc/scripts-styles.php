<?php
// Register Scripts and Styles
function add_custom_items()
{
    $versionNumber = "1.0";
    $templateDirectory = get_template_directory_uri();

    wp_register_style('foundation', $templateDirectory . '/assets/foundation/css/foundation.min.css', array(), '1.0', 'all');

    wp_enqueue_style('foundation');
    wp_enqueue_style('base-styles', $templateDirectory . '/assets/css/style.css', array(), $versionNumber, 'all');
    wp_enqueue_style('aos', $templateDirectory . '/assets/js/src/aos/aos.css', array(), $versionNumber, 'all');
    wp_enqueue_style('fancy-css', $templateDirectory . '/assets/js/src/fancybox/fancybox.css', array(), $versionNumber, 'all');
    wp_enqueue_style('swiper-css', $templateDirectory . '/assets/js/src/swiper/swiper-bundle.min.css', array(), $versionNumber, 'all');
    wp_enqueue_style('to-top', $templateDirectory . '/assets/js/src/to-top/to-top.css', array(), $versionNumber, 'all');

    wp_register_script('unit-values', $templateDirectory . '/assets/js/src/unit-values.js', array('jquery'), $versionNumber);

    wp_register_script('custom', $templateDirectory . '/assets/js/dist/bundle.js', array('jquery'), $versionNumber);

    wp_enqueue_script('custom');

    if (is_page(1736)) {
        wp_enqueue_script('unit-values');
    }
}
add_action('wp_enqueue_scripts', 'add_custom_items', 11);

// Register stylesheet for login page
function custom_login_stylesheet()
{
    $versionNumber = time();

    wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/assets/css/login.css', array(), $versionNumber, 'all');
}
add_action('login_enqueue_scripts', 'custom_login_stylesheet');