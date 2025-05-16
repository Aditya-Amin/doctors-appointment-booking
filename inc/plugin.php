<?php
/**
 * Main plugin file for Health Visit    
 */
defined('ABSPATH') || exit;

use Tp\HealthVisit\Models\Doctors;
use Tp\HealthVisit\Controllers\Doctors as DoctorsController;

class Plugin{
    /**
     * Constructor
     */
    public function __construct() {
        // Load the plugin text domain for translations
        add_action('init', [$this, 'load_textdomain']);
        // Load models
        $this->load_models();
        $this->load_controllers();
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
    }

    /**
     * Load controllers
     */
    public function load_controllers() {
       new DoctorsController();
    }
}


// Initialize the plugin
new Plugin();