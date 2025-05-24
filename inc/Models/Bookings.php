<?php
/**
 * Booking Model
 *
 * This class handles the booking-related functionality of the HealthVisit plugin.
 *
 * @package Tp\HealthVisit\Models
 */
namespace Tp\HealthVisit\Models;

class Bookings{

    public function __construct()
    {
        add_action( 'init', [$this, 'register_posttype'], 0 );
    }

    /**
     * Register the booking post type
     */
    public function register_posttype() {
        $labels = array(
            'name'                  => _x( 'Bookings', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Booking', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Bookings', 'text_domain' ),
            'name_admin_bar'        => __( 'Booking', 'text_domain' ),
            'archives'              => __( 'Booking Archives', 'text_domain' ),
            'attributes'            => __( 'Booking Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Booking:', 'text_domain' ),
            'all_items'             => __( 'All Bookings', 'text_domain' ),
            'add_new_item'          => __( 'Add New Booking', 'text_domain' ),
            'add_new'               => __( 'Add Booking', 'text_domain' ),
            'new_item'              => __( 'New Booking', 'text_domain' ),
            'edit_item'             => __( 'Edit Booking', 'text_domain' ),
            'update_item'           => __( 'Update Booking', 'text_domain' ),
            'view_item'             => __( 'View Booking', 'text_domain' ),
            'view_items'            => __( 'View Bookings', 'text_domain' ),
            'search_items'          => __( 'Search Booking', 'text_domain' ),
            // Other labels...
        );

        $args = array(
            // Arguments for the post type...
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-calendar-alt',
            'supports'          => array( 'title', 'custom-fields' ),
            'capability_type'   => 'post',
        );

        register_post_type( 'tp_bookings', $args );
    }
}