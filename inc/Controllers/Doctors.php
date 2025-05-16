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



}