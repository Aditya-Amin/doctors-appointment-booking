<?php
/**
 * Doctors Controller Class
 */
namespace Tp\HealthVisit\Controllers;

defined('ABSPATH') || exit;

class Doctors
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_filter('template_include', [$this, 'load_template'], 99);
        add_action('save_post_tp_doctors', [$this, 'save_meta_fields'], 10, 1);
    }

    /**
     * Get doctors
     *
     * @return array
     */
    public function getDoctors()
    {
        
    }

    /**
     * Load the template for displaying doctors
     *
     * @param string $template
     * @return string
     */
    public function load_template( $template )
    {

        if ( is_post_type_archive('tp_doctors') ) {
            $new_template = HEALTHVISIT_WP_DIR . 'inc/Views/frontend/archive-doctors.php';
            if ( file_exists( $new_template ) ) {
                return $new_template;
            }
        } else if( is_singular('tp_doctors') ) {
            $new_template = HEALTHVISIT_WP_DIR . 'inc/Views/frontend/single-doctors.php';
            if ( file_exists( $new_template ) ) {
                return $new_template;
            }
        }

        return $template;
        
    }


    /**
     * Save meta fields for doctor post type
     */
    public static function save_meta_fields($post_id) {
        // echo '<pre>';
        // var_dump($_POST);
        // exit;
        if (!isset($_POST['doctor_meta_nonce']) || !wp_verify_nonce($_POST['doctor_meta_nonce'], 'save_doctor_meta')) {
            return;
        }

        // Save basic fields
        update_post_meta($post_id, '_doctor_phone', sanitize_text_field($_POST['doctor_phone'] ?? ''));
        update_post_meta($post_id, '_doctor_email', sanitize_email($_POST['doctor_email'] ?? ''));
        update_post_meta($post_id, '_doctor_price', floatval($_POST['doctor_price'] ?? 0));
        update_post_meta($post_id, '_doctor_designation', sanitize_text_field($_POST['doctor_designation'] ?? ''));

        // Save social media links (repeater)
        $socials = [];
        if (!empty($_POST['doctor_socials']) && is_array($_POST['doctor_socials'])) {
            foreach ($_POST['doctor_socials'] as $item) {
                if (!empty($item['platform']) && !empty($item['url'])) {
                    $socials[] = [
                        'platform' => sanitize_text_field($item['platform']),
                        'url'      => esc_url_raw($item['url']),
                    ];
                }
            }
        }
        update_post_meta($post_id, '_doctor_socials', $socials);

        // Save availability (repeater)
        $availability = [];
        if (!empty($_POST['doctor_availability']) && is_array($_POST['doctor_availability'])) {
            foreach ($_POST['doctor_availability'] as $item) {
                if (!empty($item['day']) && isset($item['from']) && isset($item['to'])) {
                    $availability[] = [
                        'day'  => sanitize_text_field($item['day']),
                        'from' => sanitize_text_field($item['from']),
                        'to'   => sanitize_text_field($item['to']),
                    ];
                }
            }
        }
        update_post_meta($post_id, '_doctor_availability', $availability);
    }




}