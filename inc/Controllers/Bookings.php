<?php
/**
 * Booking Controller
 *
 * This class handles the booking-related functionality of the EasyStay WP plugin.
 *
 * @package Tp\HealthVisit\Controllers
 */
namespace Tp\HealthVisit\Controllers;

class Bookings{

    public function __construct()
    {
        // var_dump('Bookings Controller');
        add_filter('manage_tp_bookings_posts_columns', [self::class, 'custom_columns']);
        add_action('manage_tp_bookings_posts_custom_column', [self::class, 'custom_column_content'], 10, 2);
    }

    public static function custom_columns($columns) {
        return [
            'cb'                   => $columns['cb'],
            'title'                => __('Booking Title'),
            'doctor_name'          => __('Doctor'),
            'patient_name'         => __('Patient'),
            'appointment_datetime' => __('Date & Time'),
            'payment_method'       => __('Payment'),
        ];
    }

    public static function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'doctor_name':
                echo esc_html(get_post_meta($post_id, 'doctor_name', true));
                break;

            case 'patient_name':
                echo esc_html(get_post_meta($post_id, 'patient_name', true));
                break;

            case 'appointment_datetime':
                $datetime = get_post_meta($post_id, 'appointment_datetime', true);
                echo esc_html(date('d M Y, h:i A', strtotime($datetime)));
                break;

            case 'payment_method':
                $method = get_post_meta($post_id, 'payment_method', true);
                echo ucfirst(esc_html($method));
                break;
        }
    }
}