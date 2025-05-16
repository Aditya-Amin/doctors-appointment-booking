<?php
namespace Tp\HealthVisit\Models;

defined('ABSPATH') || exit;
/**
 * Class Doctors
 *
 * This class handles the doctor-related functionality of the HealthVisit plugin.
 *
 * @package Tp\HealthVisit\Models
 */
class Doctors
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action( 'init', [$this, 'register_posttype'], 0 );
    }

    /**
     * Example method to get doctors
     *
     * @return array
     */
    public function getDoctors()
    {
        // This is a placeholder for actual logic to retrieve doctors.
        return [
            ['id' => 1, 'name' => 'Dr. John Doe'],
            ['id' => 2, 'name' => 'Dr. Jane Smith'],
        ];
    }


    // Register Custom Post Type
    public function register_posttype() {

        $labels = array(
            'name'                  => _x( 'Doctors', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Doctor', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Doctors', 'text_domain' ),
            'name_admin_bar'        => __( 'Doctors', 'text_domain' ),
            'archives'              => __( 'Doctors Archives', 'text_domain' ),
            'attributes'            => __( 'Doctors Attributes', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
            'all_items'             => __( 'All Doctors', 'text_domain' ),
            'add_new_item'          => __( 'Add New Doctor', 'text_domain' ),
            'add_new'               => __( 'Add Doctor', 'text_domain' ),
            'new_item'              => __( 'New Doctor', 'text_domain' ),
            'edit_item'             => __( 'Edit Doctor', 'text_domain' ),
            'update_item'           => __( 'Update Doctor', 'text_domain' ),
            'view_item'             => __( 'View Doctor', 'text_domain' ),
            'view_items'            => __( 'View Doctors', 'text_domain' ),
            'search_items'          => __( 'Search Doctor', 'text_domain' ),
            'not_found'             => __( 'Not found', 'text_domain' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
            'featured_image'        => __( 'Featured Image', 'text_domain' ),
            'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
            'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
            'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
            'insert_into_item'      => __( 'Insert into doctor', 'text_domain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this doctor', 'text_domain' ),
            'items_list'            => __( 'Doctors list', 'text_domain' ),
            'items_list_navigation' => __( 'Doctors list navigation', 'text_domain' ),
            'filter_items_list'     => __( 'Filter doctor list', 'text_domain' ),
        );
        $args = array(
            'label'                 => __( 'Doctor', 'text_domain' ),
            'description'           => __( 'Manage doctor\'s profiles', 'text_domain' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => 'doctors',
            'rewrite'               => array(
                'slug'       => 'doctors',
                'with_front' => false,
            ),
        );
        register_post_type( 'tp_doctors', $args );
    }
}