<?php
/**
 * Templates Manager Class
 */
namespace Tp\HealthVisit;

defined('ABSPATH') || exit;

class TemplatesManager {
    protected static $templates;

    public static function init() {
        self::$templates = [
            'templates/book-appointment.php' => 'Book Appointment',
        ];

        add_filter('theme_page_templates', [__CLASS__, 'add_plugin_templates']);
        add_filter('template_include', [__CLASS__, 'load_plugin_template']);
    }

    // Add plugin templates to the dropdown in page editor
    public static function add_plugin_templates($templates) {
        return array_merge($templates, self::$templates);
    }

    // Load the template from plugin folder when assigned
    public static function load_plugin_template($template) {
        if (is_page()) {
            global $post;
            $page_template = get_page_template_slug($post->ID);

            if ($page_template && isset(self::$templates[$page_template])) {
                $plugin_template = HEALTHVISIT_WP_DIR . $page_template;
                if (file_exists($plugin_template)) {
                    return $plugin_template;
                }
            }
        }
        return $template;
    }
}
