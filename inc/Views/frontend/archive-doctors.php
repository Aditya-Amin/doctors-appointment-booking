<?php get_header(); ?>

<section class="doctors-list-area">
    <div class="container">
        <?php if(have_posts()): ?>
        <div class="list">
            <?php while(have_posts()): the_post(); ?>
            <?php
                /**
                 * Doctor Meta Info
                 */
                $doctor_designation = get_post_meta(get_the_ID(), '_doctor_designation', true);
                $doctor_phone = get_post_meta(get_the_ID(), '_doctor_phone', true);
                $doctor_email = get_post_meta(get_the_ID(), '_doctor_email', true);
                $doctor_price = get_post_meta(get_the_ID(), '_doctor_price', true);
                $doctor_socials = get_post_meta(get_the_ID(), '_doctor_socials', true);
                $doctor_socials = is_array($doctor_socials) ? $doctor_socials : [];
            ?>
            <div class="list-item">
                <div class="user-main">

                    <div class="user-img">
                        <?php the_post_thumbnail(); ?>
                    </div>

                    <div class="user-name">
                        <div class="user-headline">
                            <a href="<?php the_permalink(); ?>">
                                <h3><?php echo esc_html(get_the_title()); ?></h3>
                            </a>
                            <span class="user-designation"><?php echo esc_html($doctor_designation); ?></span>
                            <div class="user_contact">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                                    </svg>
                                    <?php echo esc_html($doctor_phone); ?>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                                    </svg>
                                    <?php echo esc_html($doctor_email); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if(!empty($doctor_socials)): ?>
                    <div class="user_social ul-li-block">
                        <ul>
                            <?php foreach($doctor_socials as $social): ?>
                            <li>
                                <a href="<?php echo esc_url($social['url']); ?>">
                                    <i class="fa-brands <?php echo esc_attr($social['platform']); ?>"></i>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="s2-share_btn text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5"/>
                            </svg>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endwhile; wp_reset_query(); ?>
            <div class="pagination">
                <?php
                // Pagination
                $big = 999999999; // an unlikely integer
                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $wp_query->max_num_pages,
                    'prev_text' => __('« Previous', 'health-visit'),
                    'next_text' => __('Next »', 'health-visit'),
                ));
                ?>
            </div>
        </div>
        <?php else : ?>
        <div class="no-doctors">
            <h2><?php esc_html_e('No doctors found', 'health-visit'); ?></h2>
            <p><?php esc_html_e('Please check back later.', 'health-visit'); ?></p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();