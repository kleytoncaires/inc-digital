<?php


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
    wp_enqueue_script('cidades', get_template_directory_uri() . '/assets/js/vendor/cidades.js');
}
add_action('wp_enqueue_scripts', 'inc_scripts');
