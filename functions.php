<?php
/**
 * TNW REST Starter functions and definitions for headless REST API use
 *
 * @package REST_API_Starter
 */

if ( ! defined( '_REST_API_STARTER_VERSION' ) ) {
	define( '_REST_API_STARTER_VERSION', '1.0.0' );
}

/**
 * Basic theme setup for REST API
 */
function rest_api_starter_setup() {
	// Enable support for Post Thumbnails 
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'rest_api_starter_setup' );

// Disable unnecessary frontend features
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Disable the admin bar for non-logged-in users
add_action('after_setup_theme', function () {
    show_admin_bar(false);
});

// Enable CORS
add_action('init', function() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
});

// Handle preflight requests
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        return $value;
    });
});

/**
 * Redirect all frontend requests to /wp-json
 */
function rest_api_starter_redirect_frontend() {
    // Don't redirect admin or REST API requests
    if (is_admin() || defined('REST_REQUEST')) {
        return;
    }

    // Don't redirect WP-CLI requests
    if (defined('WP_CLI') && WP_CLI) {
        return;
    }

    // Get the current URL
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    // Get the site URL without path
    $site_url = get_site_url(null, '', 'http');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $site_url = str_replace('http://', 'https://', $site_url);
    }

    // If this is a frontend request, redirect to /wp-json
    if (strpos($current_url, '/wp-json') === false) {
        wp_redirect($site_url . '/wp-json');
        exit;
    }
}
add_action('template_redirect', 'rest_api_starter_redirect_frontend');
