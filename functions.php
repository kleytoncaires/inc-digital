<?php

// -----------
// ACF local JSON
// -----------
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}

// -----------
// OPTIONS PAGE
// -----------

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title'    => 'Central de Informações',
        'menu_title'    => 'Central de Informações',
        'menu_slug'     => 'about',
        'capability'    => 'edit_posts',
        'redirect'      => false,
        'icon_url'      => 'dashicons-admin-site',
        'position'      => 2
    ));
}


// ----------- 
// REMOVE DASHBOARD WIDGETS 
// -----------
remove_action('welcome_panel', 'wp_welcome_panel'); //remove WordPress Welcome Panel
add_action('admin_init', 'remove_dashboard_widgets');
function remove_dashboard_widgets()
{
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); // At a Glance
    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); // Quick Draft
    remove_meta_box('dashboard_primary', 'dashboard', 'core'); // WordPress News
    remove_meta_box('dashboard_secondary', 'dashboard', 'core'); // WordPress News
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); // Activity
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core'); // Drafts Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core'); // Incoming Links Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core'); // Plugins Widget

    if (!is_admin()) {
        wp_deregister_script('jquery');                                     // De-Register jQuery
        wp_register_script('jquery', '', '', '', true);                     // Register as 'empty', because we manually insert our script in header.php
    }
}

// ----------- 
// MANAGE MENU 
// -----------
function remove_menus()
{

    //remove_menu_page( 'index.php' );                  //Dashboard
    //remove_menu_page( 'jetpack' );                    //Jetpack* 
    //remove_menu_page( 'upload.php' );                 //Media
    //remove_menu_page( 'edit.php?post_type=page' );    //Pages
    //remove_menu_page( 'themes.php' );                 //Appearance
    //remove_menu_page( 'plugins.php' );                //Plugins
    //remove_menu_page( 'users.php' );                  //Users
    //remove_menu_page( 'tools.php' );                  //Tools
    //remove_menu_page( 'options-general.php' );        //Settings
    //remove_menu_page('edit.php');                     //Posts
    remove_menu_page('edit-comments.php');          //Comments

}
add_action('admin_menu', 'remove_menus');

// ----------- 
// INCLUDE NAVIGATION MENUS
// -----------
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-nav' => __('Menu Principal'),
            // 'footer-nav' => __('Menu do Rodapé'),
        )
    );
}
add_action('init', 'register_my_menus');

// ----------- 
// ADD CLASSES IN MENU ITEMS
// -----------
function add_menu_link_class($atts, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

function add_menu_list_item_class($classes, $item, $args)
{
    if (property_exists($args, 'list_item_class')) {
        $classes[] = $args->list_item_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_list_item_class', 1, 3);

// ----------- 
// REGISTER WIDGETS
// -----------
// function my_widget()
// {
//     register_sidebar(array(
//         'name' => __('Sidebar', 'yourtheme'),
//         'id' => 'sidebar',
//         'description' => __('This is description', 'yourtheme'),
//         'before_widget' => '<aside>',
//         'after_widget' => '</aside>',
//         'before_title' => '<h3>',
//         'after_title' => '</h3>',
//     ));
// }
// add_action('widgets_init', 'my_widget');

// ----------- 
// DISPLAY POST EXCERPT BY DEFAULT
// -----------
function wpse_edit_post_show_excerpt()
{
    $user = wp_get_current_user();
    $unchecked = get_user_meta($user->ID, 'metaboxhidden_post', true);
    if (!empty($unchecked)) {
        $key = array_search('postexcerpt', $unchecked);
        if (FALSE !== $key) {
            array_splice($unchecked, $key, 1);
            update_user_meta($user->ID, 'metaboxhidden_post', $unchecked);
        }
    }
}
add_action('admin_init', 'wpse_edit_post_show_excerpt', 10);

function show_excerpt_meta_box($hidden, $screen)
{
    if ('post' == $screen->base) {
        foreach ($hidden as $key => $value) {
            if ('postexcerpt' == $value) {
                unset($hidden[$key]);
                break;
            }
        }
    }
    return $hidden;
}
add_filter('default_hidden_meta_boxes', 'show_excerpt_meta_box', 10, 2);

// ----------- 
// DISABLE SELF PINGBACKS
// -----------
function wpsites_disable_self_pingbacks(&$links)
{
    foreach ($links as $l => $link)
        if (0 === strpos($link, get_option('home')))
            unset($links[$l]);
}

add_action('pre_ping', 'wpsites_disable_self_pingbacks');

// ----------- 
// DISABLE FEED
// -----------
function itsme_disable_feed()
{
    wp_die(__('No feed available, please visit the homepage!'));
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);


// ----------- 
// CUSTOM ADMIN LOGO
// -----------
function my_login_logo()
{ ?>
    <style type="text/css">
        #login,
        .login {
            background-color: #fff;
        }

        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/wp-login.png);
            background-size: 320px 240px;
            background-repeat: no-repeat;
            height: 240px;
            padding-bottom: 30px;
            width: 320px;
        }

        .login #backtoblog a,
        .login #nav a {
            color: #000 !important;
        }
    </style>
    <?php }
add_action('login_enqueue_scripts', 'my_login_logo');

// -----------
// CONTACT FORM 7 REMOVE SPAN WRAPPER
// -----------
add_filter('wpcf7_autop_or_not', '__return_false');


// -----------
// REMOVE STRING WHITESPACE
// -----------
function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^a-zA-Z0-9]+/', '', $string); // Removes special chars.
}

// -----------
// ADD EXCERPT TO PAGES
// -----------
function add_excerpt_to_pages()
{
    add_post_type_support('page', 'excerpt');
}
add_action('init', 'add_excerpt_to_pages');

// -----------
// MODIFY EXCERPT LENGTH
// -----------
function custom_excerpt_length($length)
{
    return 25;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

// -----------
// CHANGE MORE EXCERPT
// -----------
// function custom_more_excerpt($more)
// {
//     return '...';
// }
// add_filter('excerpt_more', 'custom_more_excerpt');


// -----------
// SVG SUPPORT
// -----------
function allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

function svg_thumbnail_support()
{
    if (function_exists('add_theme_support')) {
        add_theme_support('post-thumbnails');
        add_filter('wp_generate_attachment_metadata', 'svg_attachment_metadata', 10, 2);
    }
}

function svg_attachment_metadata($metadata, $attachment_id)
{
    $attachment = get_post($attachment_id);
    $mime_type  = get_post_mime_type($attachment);

    if ('image/svg+xml' === $mime_type) {
        $metadata['width']  = 0;
        $metadata['height'] = 0;
    }

    return $metadata;
}

add_action('after_setup_theme', 'svg_thumbnail_support');


// -----------
// GET VIDEO THUMBNAILS
// -----------
function get_video_thumbnail($video_link)
{
    if (strpos($video_link, 'vimeo.com') !== false) {
        $link_parts = explode("/", parse_url($video_link, PHP_URL_PATH));
        $video_id = end($link_parts);
        return "https://i.vimeocdn.com/video/" . $video_id . "_1280.jpg";
    } elseif (strpos($video_link, 'youtube.com') !== false || strpos($video_link, 'youtu.be') !== false) {
        $link = explode("?v=", $video_link);
        $link = $link[1];
        return "https://img.youtube.com/vi/" . $link . "/hqdefault.jpg";
    } else {
        return '';
    }
}

// -----------
// GET VIDEO IDS
// -----------

function get_youtube_video_id($url)
{
    $query_string = parse_url($url, PHP_URL_QUERY);
    parse_str($query_string, $params);
    if (isset($params['v'])) {
        return $params['v'];
    }
    return false;
}

function get_vimeo_video_id($url)
{
    preg_match('/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/', $url, $matches);
    if (isset($matches[2])) {
        return $matches[2];
    }
    return false;
}


// -----------
// LOAD DASHICONS
// -----------
// function ww_load_dashicons()
// {
//     wp_enqueue_style('dashicons');
// }
// add_action('wp_enqueue_scripts', 'ww_load_dashicons');

// -----------
// REMOVE DASHICONS
// -----------
function wpdocs_dequeue_dashicon()
{
    if (current_user_can('update_core')) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action('wp_enqueue_scripts', 'wpdocs_dequeue_dashicon');

// -----------
// REMOVE JQUERY MIGRATE
// -----------
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate'
            ));
        }
    }
}

add_action('wp_default_scripts', 'remove_jquery_migrate');

// -----------
// REPLACE/REMOVE JQUERY VERSION
// -----------
function replace_core_jquery_version()
{
    wp_deregister_script('jquery');
    // Change the URL if you want to load a local copy of jQuery from your own server.
    // wp_register_script('jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js", array(), '3.6.0');
}
add_action('wp_enqueue_scripts', 'replace_core_jquery_version');

// -----------
// REMOVE WP EMOJI
// -----------
function disable_wp_emojicons()
{
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
    add_filter('emoji_svg_url', '__return_false');
}
add_action('init', 'disable_wp_emojicons');

function disable_emojicons_tinymce($plugins)
{
    return is_array($plugins) ? array_diff($plugins, array('wpemoji')) : array();
}

// -----------
// ENQUEUE SCRIPTS
// -----------
function inc_scripts()
{
    wp_enqueue_script('jquery', "https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js", array(), '3.7.1');
    wp_enqueue_script('jQueryMask', 'https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js', array(), '1.14.16', false);
    wp_enqueue_script('fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0.36/dist/fancybox/fancybox.umd.min.js', array(), '5.0.36', false);
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js', array(), '11.1.14', false);
    wp_enqueue_script('aos', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.min.js', array(), '2.3.4', false);
    wp_enqueue_script('custom', get_template_directory_uri() . '/scripts.js');
}
add_action('wp_enqueue_scripts', 'inc_scripts');


// -----------
// DISABLE BLOCK LIBRARY
// -----------
// function wpassist_remove_block_library_css()
// {
//     wp_dequeue_style('wp-block-library');
// }
// add_action('wp_enqueue_scripts', 'wpassist_remove_block_library_css');

// ----------- 
// REMOVE WORDPRESS JUNKS 
// -----------
remove_action('wp_head', 'wp_generator');     //  wordpress version from header
remove_action('wp_head', 'rsd_link');       // link to Really Simple Discovery service endpoint
remove_action('wp_head', 'wlwmanifest_link');   // link to Windows Live Writer manifest file
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'start_post_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('template_redirect', 'wp_shortlink_header', 11); // Remove WordPress Shortlinks from HTTP Headers

// ----------- 
// ADD PAGE SLUG TO BODY CLASS
// -----------
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// ----------- 
// ENQUEUE STYLES
// -----------
function inc_styles()
{
    //wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('main', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
}
add_action('wp_enqueue_scripts', 'inc_styles');


// -----------
// MOVE YOAST TO THE BOTTOM IN ADMIN
// -----------
function yoasttobottom()
{
    return 'low';
}
add_filter('wpseo_metabox_prio', 'yoasttobottom');

// -----------
// YOAST SOCIAL LINKS
// -----------

/**
 * Social Links
 * Uses Social URLs specified in Yoast SEO. See SEO > Social
 *
 */
function ea_social_links()
{
    $options = array(
        'facebook'   => array(
            'key'  => 'facebook_site',
            'icon'         => '<i class="fa-brands fa-facebook-f"></i>',
        ),
        'twitter'    => array(
            'key'     => 'twitter_site',
            'prepend' => 'https://twitter.com/',
            'icon'    => '<i class="fa-brands fa-twitter"></i>',
        ),
    );

    $options = apply_filters('ea_social_link_options', $options);

    $output = array();

    $seo_data = get_option('wpseo_social');

    foreach ($options as $social => $settings) {
        $url = !empty($seo_data[$settings['key']]) ? $seo_data[$settings['key']] : false;

        if (!empty($url) && !empty($settings['prepend']))
            $url = $settings['prepend'] . $url;

        if ($url && !empty($settings['icon'])) {
            $output[] = '<a href="' . esc_url_raw($url) . '" target="_blank" rel="noopener">' . $settings['icon'] . '<span class="visually-hidden">' . $social . '</span></a>';
        } elseif ($url) {
            $output[] = '<a href="' . esc_url_raw($url) . '" target="_blank" rel="noopener">' . $social . '</a>';
        }
    }

    foreach ($seo_data['other_social_urls'] as $social => $url) {
        $icon = '';

        if (stripos($url, 'whatsapp') !== false) {
            $icon = '<i class="icon-whatsapp"></i>';
        } elseif (stripos($url, 'linkedin') !== false) {
            $icon = '<i class="icon-linkedin-in"></i>';
        } elseif (stripos($url, 'instagram') !== false) {
            $icon = '<i class="icon-instagram"></i>';
        } elseif (stripos($url, 'youtube') !== false) {
            $icon = '<i class="icon-youtube"></i>';
        } elseif (stripos($url, 'tiktok') !== false) {
            $icon = '<i class="icon-tiktok"></i>';
        }

        if (!empty($icon)) {
            $output[] = '<a href="' . esc_url_raw($url) . '" target="_blank" rel="noopener">' . $icon . '<span class="visually-hidden">' . $social . '</span></a>';
        } else {
            $output[] = '<a href="' . esc_url_raw($url) . '" target="_blank" rel="noopener">' . $social . '</a>';
        }
    }


    if (!empty($output))
        return '<div class="social-links">' . join(' ', $output) . '</div>';
}

add_shortcode('social_links', 'ea_social_links');


// -----------
// AJAX TO LOAD MORE POSTS WITHOUT RELOADING
// -----------
function load_more_posts()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;

    $args = array(
        'post_type'      => 'post', // CHANGE if needed
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'paged'          => $paged,
    );

    $posts_query = new WP_Query($args);

    if ($posts_query->have_posts()) :
        while ($posts_query->have_posts()) : $posts_query->the_post(); ?>

            <h2><?php the_title(); ?></h2>
            <div class="remove-last-margin">
                <?php the_content(); ?>
            </div>

<?php if (has_post_thumbnail()) :
                $image_args = array(
                    'class' => 'img-fluid',
                    'loading' => 'lazy',
                );
                the_post_thumbnail('full', $image_args);
            endif;

        endwhile;
        wp_reset_postdata();
    else :
        wp_send_json(false); // Send false if no more posts
    endif;

    die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');
