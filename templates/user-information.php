<?php
/*
 * Template Name: Get Instagram Access Token
 */
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
        
        ?>
            <p>
                <strong>Username</strong>
                <?php //echo get_post_meta($_GET['ticket'], ) ?>
            </p>
        <?php
    }
}
get_footer();
