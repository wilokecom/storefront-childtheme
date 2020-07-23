<?php
/*
 * Template Name: Get Instagram Access Token
 */

if (isset($_POST['client_id'])
    && !empty($_POST['client_id'])
) {
    if (!isset($_POST['client_id'])
        || !wp_verify_nonce($_POST['wilcity_instagram_nonce_security'], 'wilcity_instagram_nonce_action')
    ) {
        echo 'Hey man, please do not not spam our site';
        exit;
    } else {
        $clientID = trim($_POST['client_id']);
        $redirect = add_query_arg(
          [
            'client_id'     => $clientID,
            'redirect_uri'  => get_permalink($post->ID),
            'response_type' => 'code',
            'scope'         => 'user_profile,user_media'
          ],
          'https://api.instagram.com/oauth/authorize'
        );
        
        wp_redirect($redirect);
        exit;
    }
}

get_header();

if (have_posts()) : while (have_posts()): the_post();
    ?>
    <div class="controller">
        <?php the_content(); ?>
        <div class="wil-instagram-wrapper">
            <?php
            if (isset($_GET['access_token'])) {
                ?>
                <div class="ui segment">
                    <h5 class="ui top attached header">Your access Token is</h5>
                    <div class="text">
                        <textarea><?php echo trim($_GET['access_token']); ?></textarea>
                    </div>
                </div>
                <?php
            }
            ?>
            <form method="POST" action="<?php the_permalink(); ?>" class="ui form">
                <div class="field">
                    <label for="client-id">Your Instagram Client ID</label>
                    <input id="client-id" type="text" name="client_id">
                </div>
                <?php wp_nonce_field('wilcity_instagram_nonce_action', 'wilcity_instagram_nonce_security'); ?>
                <button class="ui button" type="submit">Submit</button>
            </form>
        </div>
    </div>
<?php
endwhile; endif;
wp_reset_postdata();
?>
<?php
get_footer();
