<?php
/**
 * Template Name: Book Appointment
 */
get_header();

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

if (!$doctor_id || get_post_type($doctor_id) !== 'tp_doctors') {
  echo '<div style="padding: 40px; font-size: 20px; color: red;">Invalid doctor selected.</div>';
  get_footer();
  exit;
}

$doctor_name = get_the_title($doctor_id);
$doctor_price = get_post_meta($doctor_id, '_doctor_price', true);
$doctor_image = get_the_post_thumbnail_url($doctor_id, 'medium');
$doctor_designation = get_post_meta($doctor_id, '_doctor_designation', true);
?>

<div class="appointment-form">
  <div class="doctor-info">
    <?php if($doctor_image): ?>
    <img src="<?php echo esc_url($doctor_image); ?>" alt="<?php echo esc_attr($doctor_name); ?>">
    <?php endif; ?>
    <div class="doctor-details">
      <h2><?php echo esc_html($doctor_name); ?></h2>
      <p class="designation"><?php echo esc_html($doctor_designation); ?></p>
    </div>
  </div>

 <form method="post">
  <input type="hidden" name="doctor_id" value="<?php echo esc_attr($doctor_id); ?>">

  <label for="patient_name">Your Name</label>
  <input type="text" name="patient_name" required>

  <label for="patient_email">Your Email</label>
  <input type="email" name="patient_email" required>

  <label for="patient_phone">Phone</label>
  <input type="tel" name="patient_phone" required>

  <label for="appointment_datetime">Preferred Date & Time</label>
  <input type="datetime-local" name="appointment_datetime" required>

  <label for="notes">Notes</label>
  <textarea name="notes" rows="4" placeholder="Mention any symptoms, concerns, etc..."></textarea>

  <div class="price-section">
    <strong>Consultation Price:</strong>
    <span class="price">৳<?php echo esc_html(number_format($doctor_price, 2)); ?></span>
  </div>

  <label for="payment_method">Payment Method</label>
  <select name="payment_method" required>
    <option value="">Select a payment method</option>
    <option value="cash">Cash on visit</option>
    <option value="online">Online Payment</option>
  </select>

  <button type="submit" name="submit_booking">Book Appointment</button>
</form>

</div>

<?php
if (isset($_POST['submit_booking'])) {
    $doctor_id = intval($_POST['doctor_id']);
    $doctor_name = get_the_title($doctor_id);

    $patient_name  = sanitize_text_field($_POST['patient_name']);
    $patient_email = sanitize_email($_POST['patient_email']);
    $patient_phone = sanitize_text_field($_POST['patient_phone']);
    $datetime      = sanitize_text_field($_POST['appointment_datetime']);
    $notes         = sanitize_textarea_field($_POST['notes']);
    $payment       = sanitize_text_field($_POST['payment_method']);

    $booking_post = [
        'post_title'  => 'Booking by ' . $patient_name,
        'post_type'   => 'tp_bookings',
        'post_status' => 'publish',
        'meta_input'  => [
            'doctor_id'     => $doctor_id,
            'doctor_name'   => $doctor_name,
            'patient_name'  => $patient_name,
            'patient_email' => $patient_email,
            'patient_phone' => $patient_phone,
            'appointment_datetime' => $datetime,
            'notes'         => $notes,
            'payment_method' => $payment,
        ]
    ];

    wp_insert_post($booking_post);

    echo '<script>alert("Booking submitted successfully!"); window.location.href="' . get_permalink($doctor_id) . '";</script>';
}

?>

<?php get_footer(); ?>
