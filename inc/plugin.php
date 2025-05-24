<?php
/**
 * Main plugin file for Health Visit    
 */
defined('ABSPATH') || exit;

use Tp\HealthVisit\Models\Doctors;
use Tp\HealthVisit\Controllers\Doctors as DoctorsController;
use Tp\HealthVisit\Models\Bookings;
use Tp\HealthVisit\Controllers\Bookings as BookingsController;

use Tp\HealthVisit\TemplatesManager;

class Plugin{
    /**
     * Constructor
     */
    public function __construct() {
        // Load the plugin text domain for translations
        add_action('init', [$this, 'load_textdomain']);

        // Load Frontend Assets
        add_action('wp_enqueue_scripts', [$this, 'load_frontend_assets']);

        // Load Admin Assets
        add_action('admin_enqueue_scripts', [$this, 'load_admin_assets']);
        // Load models
        $this->load_models();
        $this->load_controllers();
        TemplatesManager::init();
    }

    /**
     * Load plugin text domain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain('health-visit', false, HEALTHVISIT_WP_DIR . '/languages/');
    }

    /**
     * Load models
     */
    public function load_models(){
        new Doctors();
        new Bookings();
    }

    /**
     * Load controllers
     */
    public function load_controllers() {
        new DoctorsController();
        new BookingsController();
    }

    /**
     * Load FrontEnd Assets
     */
    public function load_frontend_assets() {
        // css
        wp_enqueue_style('font-wesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');
        wp_enqueue_style('health-visit-style', HEALTHVISIT_WP_URL . 'frontend/css/style.css', [], HEALTHVISIT_WP_VERSION);
        
        // js
        wp_enqueue_script('health-visit-script', HEALTHVISIT_WP_URL . 'frontend/js/main.js', ['jquery'], HEALTHVISIT_WP_VERSION, true);
        wp_localize_script('health-visit-script', 'healthVisit', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('health_visit_nonce')
        ]);
    }

    /**
     * Load Admin Assets
     */
    public function load_admin_assets() {
        // css
        wp_enqueue_style('health-visit-admin-style', HEALTHVISIT_WP_URL . 'admin/css/admin.css', [], HEALTHVISIT_WP_VERSION);
        
        // js
        wp_enqueue_script('metabox', HEALTHVISIT_WP_URL . 'admin/js/metabox.js', ['jquery'], HEALTHVISIT_WP_VERSION, true);
        wp_enqueue_script('health-visit-admin-script', HEALTHVISIT_WP_URL . 'admin/js/admin.js', ['jquery'], HEALTHVISIT_WP_VERSION, true);
        wp_localize_script('health-visit-admin-script', 'healthVisitAdmin', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('health_visit_admin_nonce')
        ]);
    }
}


// Initialize the plugin
new Plugin();