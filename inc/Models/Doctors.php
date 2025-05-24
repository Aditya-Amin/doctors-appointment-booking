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
        add_action( 'add_meta_boxes', [$this, 'register_meta_boxes'] );
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

    /**
     * Add meta boxes for doctor details
     */
    public static function register_meta_boxes() {
        add_meta_box('doctor_info', 'Doctor Info', [self::class, 'render'], 'tp_doctors', 'normal', 'default');
    }

    public static function render($post) {
        wp_nonce_field('save_doctor_meta', 'doctor_meta_nonce');

        // Get saved values
        $socials = get_post_meta($post->ID, '_doctor_socials', true);
        $socials = is_array($socials) ? $socials : [];

        $availability = get_post_meta($post->ID, '_doctor_availability', true);
        $availability = is_array($availability) ? $availability : [];

        $phone = get_post_meta($post->ID, '_doctor_phone', true);
        $email = get_post_meta($post->ID, '_doctor_email', true);
        $price = get_post_meta($post->ID, '_doctor_price', true);

        $designation = get_post_meta($post->ID, '_doctor_designation', true);

        echo '<label>Designation / Specialty:</label>';
        echo '<input type="text" name="doctor_designation" value="' . esc_attr($designation) . '" /><br>';


        echo '<label>Phone: </label><input type="text" name="doctor_phone" value="' . esc_attr($phone) . '" /><br>';
        echo '<label>Email: </label><input type="email" name="doctor_email" value="' . esc_attr($email) . '" /><br>';
        echo '<label>Visiting Price: </label><input type="number" name="doctor_price" value="' . esc_attr($price) . '" /><br><br>';

        echo '<h4>Social Media Links</h4>';
        echo '<div id="social-repeater">';
        foreach ($socials as $i => $row) {
            echo '<div class="social-row">';
            self::social_dropdown($row['platform'] ?? '', $row['url'] ?? '', $i);
            echo '</div>';
        }
        echo '</div>';
        echo '<button type="button" id="add-social">Add Social Link</button><br><br>';

        echo '<h4>Weekly Availability</h4>';
        echo '<div id="availability-container">';
        foreach ($availability as $i => $slot) {
            self::availability_row($slot['day'] ?? '', $slot['from'] ?? '', $slot['to'] ?? '', $i);
        }
        echo '</div>';
        echo '<button type="button" id="add-availability">Add Availability</button>';
    }

    private static function social_dropdown($platform = '', $url = '', $index = 0) {
        $platforms = ['fa-facebook-f', 'fa-linkedin-in', 'fa-instagram', 'fa-youtube'];
        echo '<select name="doctor_socials[' . $index . '][platform]">';
        foreach ($platforms as $p) {
            $selected = $platform === $p ? 'selected' : '';
            echo "<option value='$p' $selected>$p</option>";
        }
        echo '</select>';
        echo '<input type="url" name="doctor_socials[' . $index . '][url]" value="' . esc_attr($url) . '" placeholder="https://..." />';
        echo '<button type="button" class="remove-row">Remove</button>';
    }

    private static function availability_row($day = '', $from = '', $to = '', $index = 0) {
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        echo '<div class="availability-row">';
        echo '<label>Day:</label>';
        echo '<select name="doctor_availability[' . $index . '][day]">';
        foreach ($days as $d) {
            $selected = $d === $day ? 'selected' : '';
            echo "<option value='$d' $selected>$d</option>";
        }
        echo '</select>';

        echo '<label>From:</label>';
        echo '<input type="time" name="doctor_availability[' . $index . '][from]" value="' . esc_attr($from) . '" />';

        echo '<label>To:</label>';
        echo '<input type="time" name="doctor_availability[' . $index . '][to]" value="' . esc_attr($to) . '" />';

        echo '<button type="button" class="remove-row">Remove</button>';
        echo '</div>';
    }



}