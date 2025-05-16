<?php
/**
 * Plugin Name: Health Visit
 * Plugin URI: https://healthvisit.com
 * Description: A WordPress plugin to manage health visits and appointments.
 * Version: 1.0.0
 * Author: ThemePure
 * Author URI: https://themepure.net
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: health-visit
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 8.2
 * Tested up to: 6.8
 */

defined('ABSPATH') || die('Ahh Ahh Ahh! You are not allowed to access this file directly!');

define('HEALTHVISIT_WP_VERSION', '1.0.0');
define('HEALTHVISIT_WP_DIR', plugin_dir_path(__FILE__));
define('HEALTHVISIT_WP_URL', plugin_dir_url(__FILE__));
define('HEALTHVISIT_WP_ADMIN_URL', HEALTHVISIT_WP_URL . 'admin/');
define('HEALTHVISIT_WP_PUBLIC_URL', HEALTHVISIT_WP_URL . 'frontend/');


// Autoload Vendor Autoload.php
if (file_exists(HEALTHVISIT_WP_DIR . 'vendor/autoload.php')) {
    require_once HEALTHVISIT_WP_DIR . 'vendor/autoload.php';
} else {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>' . __('HealthVisit WP requires the vendor dependencies to be installed. Please run <code>composer install</code> in the plugin directory.', 'health-visit') . '</p></div>';
    });
    return;
}


// Load the main plugin class
require_once HEALTHVISIT_WP_DIR . 'inc/plugin.php';

