<?php
/*Load styles and scripts*/
function load_style_script()
{
    wp_enqueue_style('selectric', get_template_directory_uri() . '/css/selectric.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/css/slick.css');
    wp_enqueue_style('jquery-ui.min', get_template_directory_uri() . '/css/jquery-ui.min.css');
    wp_enqueue_style('jquery-ui.structure.min', get_template_directory_uri() . '/css/jquery-ui.theme.min.css');
    wp_enqueue_style('jquery-ui.theme.min', get_template_directory_uri() . '/css/jquery.timepicker.min.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('styleMain', get_template_directory_uri() . '/css/compiled-css/style.css');

    wp_enqueue_script('jquery-3.3.1', get_template_directory_uri() . '/js/jquery-3.3.1.js');
    wp_enqueue_script('selectric', get_template_directory_uri() . '/js/jquery.selectric.min.js');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js');
    wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.js');
    wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js');
    wp_enqueue_script('jquery-timepicker', get_template_directory_uri() . '/js/jquery.timepicker.min.js');
    wp_enqueue_script('slick-init', get_template_directory_uri() . '/js/custom/slick-init.js');
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js');
}



add_action("wp_enqueue_scripts", "load_style_script");
/*END Load styles and scripts*/

//Make possible to use **thumbnails** and **menus** in our theme, put this code in **functions.php**:
add_theme_support('post-thumbnails');
add_theme_support("menus");
//


//To register Your menu
register_nav_menu("menuHeader", "Header Menu");
register_nav_menu("menuitemRumbasPaviljons", "Rumbas Paviljons");



///*Make ACF Options*/
if (function_exists('acf_add_options_page')) {
    $args = ['page_title' => 'Options', 'menu_title' => 'Options'];
    acf_add_options_page($args);
}
///*End Make ACF Options*/

// Modify TinyMCE editor
function tiny_mce_remove_unused_formats($initFormats)
{
    // Add block format elements you want to show in dropdown
    $initFormats['block_formats'] = 'Paragraph=p;Heading(h2)=h2;Heading(h3)=h3';
    return $initFormats;
}

add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats');

function tinymce_paste_as_text($init)
{
    $init['paste_as_text'] = true;
    return $init;
}

add_filter('tiny_mce_before_init', 'tinymce_paste_as_text');
// End Modify TinyMCE editor


// Email address encoder hook
if (function_exists('eae_encode_emails')) {
    add_filter('acf/load_value', 'eae_encode_emails');
}
// END Email address encoder hook

/*Remove Autocomplete URL*/
remove_filter('template_redirect', 'redirect_canonical');
/*End Remove Autocomplete URL*/


/*SVG Through admin-panel*/
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');
/*END SVG Through admin-panel*/

/*Remove default sizes*/
function remove_default_image_sizes($sizes)
{
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

add_filter('intercourseste_image_sizes_advanced', 'remove_default_image_sizes');
/*END Remove default sizes*/

/*New thumb size*/
if (function_exists('add_image_size')) {
    add_image_size('modal-thumb', 1500, 1000);
}
/*END New thumb size*/

/*Excerpt ending*/
add_filter('excerpt_more', function ($more) {
    return '...';
});
/*End Excerpt ending*/


/*Date shortcode*/
function year_current_function()
{
    $output = date("Y", time());
    return $output;
}

add_shortcode('current_year', 'year_current_function');
/*END Date shortcode*/

// Shortcode in text fields
add_filter('acf/format_value/type=text', 'do_shortcode');
// END Shortcode in text fields

// Hide content editor
function hide_editor()
{
    $template_file = basename(get_page_template());
    if ($template_file == 'index.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'gallery.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'menu.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'events.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'reservation.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'contact-us.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'banquets.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'about-us.php') { // template
        remove_post_type_support('page', 'editor');
    } elseif ($template_file == 'rumbas_paviljons.php') { // template
        remove_post_type_support('page', 'editor');
    }
}

add_action('admin_head', 'hide_editor');
// END Hide content editor


/*Container for content video*/
function custom_video_html($html)
{
    return '<div class="video-wysiwyg">' . $html . '</div>';
}

add_filter('embed_oembed_html', 'custom_video_html', 10, 3);
add_filter('video_embed_html', 'custom_video_html');
/*END Container for content video*/


/*Custom Default Wordpress Gallery*/
add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr)
{
    static $funcCounter = 0;

    // Don't change code
    extract(shortcode_atts([
        'include' => '',
    ], $attr));

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(['include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'post__in']);
        $attachments = [];
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }
    if (empty($attachments)) return '';
    // END Don't change code

    ob_start();
    require(ABSPATH . 'wp-content/themes/bangerts/components-php/custom-gallery.php');
    $output = ob_get_clean();
    $funcCounter++;
    return $output;
}


/*END Custom Default Wordpress Gallery*/





/*Fix API key Google map*/
function my_acf_init()
{
    $googleMap = get_field('google_map_key', 'options');
    acf_update_setting('google_api_key', $googleMap);
}

add_action('acf/init', 'my_acf_init');
/*END Fix API key Google map*/


/*AJAX SUBSCRIBE FORM*/
add_action('wp_ajax_subscribeFormFunc', 'subscribeFormFunc');
add_action('wp_ajax_nopriv_subscribeFormFunc', 'subscribeFormFunc');
function subscribeFormFunc()
{
    global $wpdb;
    $tableName = $wpdb->prefix . "subscribers";
    $formEmail = (preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $_POST['subscribeFormEmail']) == false) ? false : true;
    $json["email-exists"] = true;
    if ($formEmail == true) {
        $query = "SELECT * FROM $tableName WHERE `email` = %s";
        $result = $wpdb->get_results($wpdb->prepare($query, $_POST['subscribeFormEmail']));
        if (empty($result)) {
            $query = "INSERT INTO $tableName (`email`) VALUES (%s)";
            $wpdb->query($wpdb->prepare($query, $_POST['subscribeFormEmail']));
            $json["email-exists"] = false;
        }
    }
    $json['form-email'] = $formEmail;
    wp_send_json($json);
    print_r($_POST);
    wp_die();
}



/*END AJAX SUBSCRIBE FORM*/

/*CUSTOM POST TYPES*/

/* Pasākumi Post Type */
function pasakumi_init()
{
    // set up pasakumi labels
    $labels = array(
        'name' => 'Pasākums',
        'singular_name' => 'Pasākums',
        'add_new' => 'Add New Pasākums',
        'add_new_item' => 'Add New Pasākums',
        'edit_item' => 'Edit pasakumi',
        'new_item' => 'New pasakumi',
        'all_items' => 'All pasakumi',
        'view_item' => 'View pasakumi',
        'search_items' => 'Search pasakumi',
        'not_found' => 'No pasakumi Found',
        'not_found_in_trash' => 'No pasakumi found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Pasākumi',
    );

    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'pasakumi'),
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes'
        )
    );
    register_post_type('pasakumi', $args);

    // register taxonomy
    register_taxonomy('pasakumi_category', 'pasakumi', array('hierarchical' => true, 'label' => 'Category', 'query_var' => true, 'rewrite' => array('slug' => 'pasakumi-category')));
}

add_action('init', 'pasakumi_init');
/* END pasakumi Post Type */


/*CUSTOM POST TYPES END */


##########################################

/* edienkarte Post Type */
add_action("init", "edienkarte_post_type");
function edienkarte_post_type()
{
    register_post_type("edienkarte", [
        "public" => true,
        "supports" => ["title", "thumbnail"],
        "labels" => [
            "name" => "Ēdienkarte",
            "add_new_item" => "Add"
        ],
        'rewrite' => [
            'with_front' => false
        ],
    ]);
}

add_rewrite_rule('^edienkarte/page/([0-9]+)', 'index.php?pagename=edienkarte&paged=$matches[1]', 'top');
/* END edienkarte Post Type */

/*Food type*/
add_action('init', 'food_type_categories');
function food_type_categories()
{
    register_taxonomy("ediena-veids", ["edienkarte"], [
        'label' => "Ēdiena veids",
        'hierarchical' => true,
        'show_admin_column' => true,
//        'meta_box_cb' => false,
    ]);
}

/*Food type*/

/*Food diversity */
add_action('init', 'food_diversity_categories');
function food_diversity_categories()
{
    register_taxonomy("ediena-dazadiba", ["edienkarte"], [
        'label' => "Ēdiena dažādība",
        'hierarchical' => true,
        'show_admin_column' => true,
//        'meta_box_cb' => false,
    ]);
}
/*Food diversity*/

/*CUSTOM POST TYPES END */


/*Ajax Contact Form*/
add_action('wp_ajax_contactFormHandler', 'contactFormHandler');
add_action('wp_ajax_nopriv_contactFormHandler', 'contactFormHandler');
function contactFormHandler()
{
    $params = [];
    parse_str($_POST['contactFormData'], $params);
    $falseCounter = 0;
    $json = [];
    $dateInputVal = parse_str($_POST['dateInput']);
    $timeInputVal = parse_str($_POST['timeInput']);



    $formName = ($params['form-name'] == "") ? false : true;
    if ($formName == false) $falseCounter++;
    $json['form-name'] = $formName;

    $formEmail = (preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $params['form-email']) == false) ? false : true;
    if ($formEmail == false) $falseCounter++;
    $json['form-email'] = $formEmail;

    // add next condition to make this field optional instead required --> && strlen($params['form-phone']) > 0
    $formPhone = (preg_match('/^[0-9\-\(\)\/\+\s]*$/', $params['form-phone']) == false || strlen($params['form-phone']) < 8) ? false : true;
    if ($formPhone == false) $falseCounter++;
    $json['form-phone'] = $formPhone;


    $formGuests = ($params['form-guest-count'] == "") ? false : true;
    if ($formGuests == false) $falseCounter++;
    $json['form-guest-count'] = $formGuests;


    $formMessage = ($params['form-message'] == "") ? false : true;
    if ($formMessage == false) $falseCounter++;
    $json['form-message'] = $formMessage;


    if ($falseCounter == 0) {
        $subject = "New message from Contact Form";
        $email_to = "recipient@gmail.com";
        $headers = [
            'content-type: text/html',
            'From: ' . $_SERVER['HTTP_HOST'] . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>',
            'Reply-To: ' . $params["form-email"] . ''
        ];
        $message = "<strong>Name: </strong>" . $params["form-name"] . "<br>
                    <strong>Date: </strong>" . $dateInputVal . "<br>
                    <strong>Time: </strong>" . $timeInputVal . "<br>
                    <strong>Email: </strong>" . $params["form-email"] . "<br>
                    <strong>Phone: </strong>" . $params["form-phone"] . "<br>
			        <strong>Message: </strong>" . nl2br(htmlspecialchars($params["form-message"])) . "<br>";
        wp_mail($email_to, $subject, $message, $headers);
    }
    wp_send_json($json);
    wp_die();
}



/*END Ajax Contact Form*/





//
//
///*Ajax Contact Form*/
//add_action('wp_ajax_contactFormHandler', 'contactFormHandler');
//add_action('wp_ajax_nopriv_contactFormHandler', 'contactFormHandler');
//function contactFormHandler()
//{
//
//    $params = [];
//    parse_str($_POST['contactFormData'], $params);
//    $falseCounter = 0;
//    $json = [];
//
//    $date = $_POST['date'];
//
//
//
//    $formName = ($params['form-name'] == "") ? false : true;
//    if ($formName == false) $falseCounter++;
//    $json['form-name'] = $formName;
//
//    $formEmail = (preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $params['form-email']) == false) ? false : true;
//    if ($formEmail == false) $falseCounter++;
//    $json['form-email'] = $formEmail;
//
//    // add next condition to make this field optional instead required --> && strlen($params['form-phone']) > 0
//    $formPhone = (preg_match('/^[0-9\-\(\)\/\+\s]*$/', $params['form-phone']) == false || strlen($params['form-phone']) < 8) ? false : true;
//    if ($formPhone == false) $falseCounter++;
//    $json['form-phone'] = $formPhone;
//
//    $formGuestCount = ($params['form-guest-count'] > 0) ? false : true;
//    if ($formGuestCount == false) $falseCounter++;
//    $json['form-guest-count'] = $formGuestCount;
//
//    $formDate = (datepicker("getDate") == "") ? false : true;
//    if ($formDate == false) $falseCounter++;
//    $json['form-guest-count'] = $formDate;
//
//    if ($falseCounter == 0) {
//        $subject = "New message from Contact Form";
//        $email_to = "recipient@gmail.com";
//        $headers = [
//            'content-type: text/html',
//            'From: ' . $_SERVER['HTTP_HOST'] . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>',
//            'Reply-To: ' . $params["form-email"] . ''
//        ];
//        $message = "<strong>Name: </strong>" . $params["form-name"] . "<br>
//                   <strong>Email: </strong>" . $params["form-email"] . "<br>
//                   <strong>Number of Guests: </strong>" . $params['form-guest-count'] . "<br>
//                   <strong>Phone: </strong>" . $params["form-phone"] . "<br>
//                   <strong>Phone: </strong>" . $params["form-phone"] . "<br>
//									 <strong>Message: </strong>" . nl2br(htmlspecialchars($params["form-message"])) . "<br>";
//        wp_mail($email_to, $subject, $message, $headers);
//    }
//    wp_send_json($json);
//    wp_die();
//}
//
///*END Ajax Contact Form*/
