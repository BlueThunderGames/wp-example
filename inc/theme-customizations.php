<?php
// Customize the login screen
function my_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');

function my_login_logo_url_title()
{
    return 'Chariot Creative Inc.';
}
add_filter('login_headertitle', 'my_login_logo_url_title');

function custom_loginfooter()
{?>
	<p class="custom-footer-link"><a href="https://chariotcreative.com" target="new" title="Site by Chariot Creative Inc."><img src="https://chariotcreative.com/zperm-imgs-dont-delete/cc-login-logo-2x.png" width="132" height="25" /></a>
	</p>
<?php }
add_action('login_footer', 'custom_loginfooter');

// Add Chariot Widget to the Dashboard
function my_custom_dashboard_widgets()
{

    global $wp_meta_boxes;

    $themePath = get_stylesheet_directory_uri();
    $themeName = substr($themePath, strrpos($themePath, '/') + 1);

    wp_add_dashboard_widget('custom_help_widget', '<img width="29" height="15" src="/wp-content/themes/' . $themeName . '/assets/images/chariot-widget-logo-small.png"> &nbsp; Chariot &nbsp; &#8250; &nbsp; Welcome to Your Dashboard! ', 'custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function custom_dashboard_help()
{
    $themePath = get_stylesheet_directory_uri();
    $themeName = substr($themePath, strrpos($themePath, '/') + 1);

    echo '<p>Welcome to your Admin Dashboard. Here are some quick tips &amp; tools that will come in handy.<br><br><strong>1) External links should open in new windows:</strong> It’s recommended to have links that point to external websites open in a NEW browser window. This will help to decrease bounce rate and/or encourage users to continue browsing.<br><br><strong>2) Compress &amp; Optimize Images:</strong> The size of a website’s images can affect <a href="https://www.growthmarketingpro.com/why-website-speed-is-game-changer/" target="new">load speed</a>, which in turn can affect UX and even search rankings (SEO). It’s recommended to compress all images as much as possible without losing visual image quality, before uploading them to the website. E.g. <a href="https://tinyjpg.com/" target="new">tinyjpg.com</a>  or  <a href="https://compressor.io/" target="new">compressor.io</a><br><br><strong>3) Editing Page Content:</strong> Page content is separated into navigable tabs within each page&#39;s editing screens. The "Visual" editor view is the default. If you need to examine or edit the html code for any reason, use the "Text" view.<br /><br /><hr /><br />Please refer to the tutorial videos supplied to you for detailed guidance. <br /><br />If you need additional help or have any questions, feel free to email us at <a href="mailto:support@chariotcreative.com?subject=Need Help with Website Dashboard">support@chariotcreative.com</a> or call 919-818-1181. <br><br>Thanks,<br>The Chariot Team<br><br><a href="https://chariotcreative.com" target="new"><img width="221" height="113" src="/wp-content/themes/' . $themeName . '/assets/images/chariot-widget-logo.png"></a></p>';
}

// Function to change email address
function wpb_sender_email($original_email_address)
{
    return 'noreply@greatgray.com';
}

// Function to change sender name
function wpb_sender_name($original_email_from)
{
    return 'Great Gray Trust Company';
}
add_filter('wp_mail_from', 'wpb_sender_email');
add_filter('wp_mail_from_name', 'wpb_sender_name');

// Allow SVG
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext' => $filetype['ext'],
        'type' => $filetype['type'],
        'proper_filename' => $data['proper_filename'],
    ];

}, 10, 4);

function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function fix_svg()
{
    echo '<style type="text/css">
		  .attachment-266x266, .thumbnail img {
			   width: 100% !important;
			   height: auto !important;
		  }
		  </style>';
}
add_action('admin_head', 'fix_svg');

/* Add Buttons to TinyMCE */
function my_mce_buttons_2($buttons)
{
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

// Add Custom Formats to TinyMCE
function insert_custom_formats($init_array)
{
    // Define the style_formats array
    $style_formats = array(
        array(
            'title' => 'Button',
            'classes' => 'btn btn-primary',
            'selector' => 'a',
            'wrapper' => false,
        ),
        array(
            'title' => 'Secondary Button',
            'classes' => 'btn btn-secondary',
            'selector' => 'a',
            'wrapper' => false,
        ),
        array(
            'title' => 'Transparent Button',
            'classes' => 'btn btn-transp',
            'selector' => 'a',
            'wrapper' => false,
        ),
        array(
            'title' => 'White Button',
            'classes' => 'btn btn-white',
            'selector' => 'a',
            'wrapper' => false,
        ),
        array(
            'title' => 'White Button Alt',
            'classes' => 'btn btn-white-alt',
            'selector' => 'a',
            'wrapper' => false,
        ),
    );

    $init_array['style_formats'] = json_encode($style_formats);

    return $init_array;
}
add_filter('tiny_mce_before_init', 'insert_custom_formats');

// Add Custom Styles to TinyMCE
add_action('after_setup_theme', 'add_tinymce_styles');
function add_tinymce_styles()
{
    add_theme_support('editor-styles');
    //add_editor_style('tiny-styles-modified.css');
}

add_filter('gform_display_add_form_button', '__return_true');

// Change the Gravity Forms submit button to a button element
function wd_gf_update_submit_button($button_input, $form)
{

    //save attribute string to $button_match[1]
    preg_match("/<input([^\/>]*)(\s\/)*>/", $button_input, $button_match);

    //remove value attribute (since we aren't using an input)
    $button_atts = str_replace("value='" . $form['button']['text'] . "' ", "", $button_match[1]);

    // create the button element with the button text inside the button element instead of set as the value
    return '<button ' . $button_atts . '>' . $form['button']['text'] . '</button>';

}
add_filter('gform_submit_button', 'wd_gf_update_submit_button', 10, 2);

// Disable scroll to confirmation 
add_filter( 'gform_confirmation_anchor', '__return_false' );

// Add the Class column to WordPress Fund posts
add_filter('manage_funds_posts_columns', 'add_fund_columns');
function add_fund_columns($columns)
{
    $columns['class'] = 'Class';

    return $columns;
}

// Populate the Class column with the class name for each Fund
add_action('manage_funds_posts_custom_column', 'add_fund_column_data', 10, 2);
function add_fund_column_data($column, $post_id)
{
    switch ($column) {
        case 'class':
            $className = get_field('class_name', $post_id);

            if (isset($className) && $className != '') {
                echo $className;
            } else {
                echo 'N/A';
            }
            break;
    }
}
/* Code to Hide Proxy Voting and Annual Reports from Dashboard */
add_action('pre_get_posts', 'exclude_categories_from_admin');
function exclude_categories_from_admin($query) {
    // Check if we are in the admin area and on the post list screen
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'post' && $query->get('cat') === '') {
        // Exclude categories 912 and 911
        $query->set('category__not_in', array(912, 911));
    }
}