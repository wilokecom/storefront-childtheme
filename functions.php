<?php

use WilcityService\Admin\RegisterUpdatePostType;

add_action('wp_head', 'wilcityServiceRemoveActions');
function wilcityServiceRemoveActions()
{
    remove_action('storefront_footer', 'storefront_credit', 20);
    remove_action('storefront_sidebar', 'storefront_get_sidebar', 10);
    if (is_singular('wiloke_plugins')) {
        remove_action('storefront_single_post', 'storefront_post_meta', 20);
    }
}

add_action('storefront_header', 'wilcityRenderTopSearchField', 42);
if (!function_exists('wilcityRenderTopSearchField')) {
    function wilcityRenderTopSearchField()
    {
        ?>
        <div class="wil-top-search-form-wrapper">
            <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
        </div>
        <?php
    }
}

add_action('wp_head', function () {
    ?>
    <meta property="fb:app_id" content="2207503519495658"/>
    <?php
    if (is_tax()) :
        $termID = get_queried_object()->term_id;
        $featuredImg = get_term_meta($termID, 'wilcity_featured_img', true);
        if (!empty($featuredImg)) :
            ?>
            <meta property="og:image" content="<?php echo esc_url($featuredImg); ?>"/>
        <?php
        endif;
    endif;
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('storefront-childtheme', get_stylesheet_directory_uri().'/assets/script.js', ['jquery'], '1.0',
      true);
});

add_action('storefront_footer', function () {
    ?>
    <div class="site-info">
        <?php echo esc_html(apply_filters('storefront_copyright_text',
          $content = '&copy; '.get_bloginfo('name').' '.date('Y'))); ?>
        <?php if (apply_filters('storefront_credit_link', true)) { ?>
            <br/>
            <?php
            if (apply_filters('storefront_privacy_policy_link', true) && function_exists('the_privacy_policy_link')) {
                the_privacy_policy_link('', '<span role="separator" aria-hidden="true"></span>');
            }
            ?>
        <?php } ?>
    </div><!-- .site-info -->
    <?php
});

function wilcityUpdatePluginGuide()
{
    global $post;
    if (!isset($post->post_type) || $post->post_type !== 'wiloke_plugins') {
        return false;
    }
    
    return false;
    
    if (class_exists('WilcityService\Admin\RegisterUpdatePostType')) {
        $isWSOnly = get_post_meta($post->ID, RegisterUpdatePostType::$prefix.'is_update_via_ws_only', true);
        if ($isWSOnly === 'yes') {
            return false;
        }
    }
    
    $updatePluginGuide = \WilcityService\Controllers\ThemeOptionController::getOptionDetail('update_plugins_guide');
    if (!empty($updatePluginGuide)) {
        $updatePluginGuide = str_replace('%pluginName%', get_the_title(get_the_ID()), $updatePluginGuide);
        echo '<blockquote>'.$updatePluginGuide.'</blockquote>';
    }
}

add_action('storefront_single_post', 'wilcityUpdatePluginGuide', 25);

add_action('wp_enqueue_scripts', function () {
    wp_register_style('semantic-ui', WICITY_SERVICE_ASSETS_URL.'semantic/form.min.css');
    
    if (is_page_template('templates/subscription-customer.php') || is_page_template
      ('templates/instagram-access-token.php')) {
        wp_enqueue_style('semantic-ui');
    }
});
