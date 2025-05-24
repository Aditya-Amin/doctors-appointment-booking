<?php
/**
 * Single Doctors Template
 */
defined('ABSPATH') || exit;
get_header();
?>

<div class="doctor-profile">
    <!-- LEFT SECTION -->
    <div class="doctor-left">
        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="Doctor Photo">

        <div class="social-links">
            <?php
                $doctor_socials = get_post_meta(get_the_ID(), '_doctor_socials', true);
            ?>
            <ul>
                <?php foreach($doctor_socials as $social): ?>
                <li>
                    <a href="<?php echo esc_url($social['url']); ?>">
                        <i class="fa-brands <?php echo esc_attr($social['platform']); ?>"></i>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="description">
            <?php the_content(); ?>
        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="doctor-right">
        <h2><?php the_title(); ?></h2>
        <div class="designation">
            <?php echo esc_html(get_post_meta(get_the_ID(), '_doctor_designation', true)); ?>
        </div>

        <div class="contact">
            📞 Phone: <a href="tel:<?php echo esc_attr(get_post_meta(get_the_ID(), '_doctor_phone', true)); ?>">
                <?php echo esc_html(get_post_meta(get_the_ID(), '_doctor_phone', true)); ?>
            </a><br>
            📧 Email: <a href="mailto:<?php echo esc_attr(get_post_meta(get_the_ID(), '_doctor_email', true)); ?>">
                <?php echo esc_html(get_post_meta(get_the_ID(), '_doctor_email', true)); ?>
            </a>
        </div>

        <div class="price">
            💰 Consultation Fee: <strong>
                <?php echo number_format((float)get_post_meta(get_the_ID(), '_doctor_price', true), 2); ?> BDT
            </strong>
        </div>

        <a href="<?php echo home_url('/book-appointment?doctor_id=' . get_the_ID()); ?>" class="appointment-btn">
            Make Appointment
        </a>


    </div>
</div>
<?php
get_footer();
