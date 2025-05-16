<?php
while( have_posts() ){
    the_post();

    echo '<a href="' . get_permalink() . '">'.get_the_title().'</a>';
    the_content();
    the_post_thumbnail();
}