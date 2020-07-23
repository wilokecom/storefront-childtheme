<?php
get_header();
$oTerm = get_queried_object();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="entry-header">
                <h1 class="entry-title"><?php echo $oTerm->name; ?> - <?php echo date(get_option('date_format',
                      get_term_meta($oTerm->term_id, 'wilcity_updated_at', true))); ?></h1>
            </div>
            <blockquote>
                <h3>How to update to new version of Wilcity?</h3>
                <ul>
                    <ul>
                        <li>Step 1: <a target="_blank" href="https://wilcityservice.com/wilcity-service/"
                                       target="_blank">Setting up
                                Wilcity Service plugin</a></li>
                        <li>Log into your site</li>
                        <li><a target="_blank"
                               href="https://documentation.wilcity.com/knowledgebase/how-can-i-backup-my-loco-translation-file/">Backup
                                Translation file of this plugin</a></li>
                        <li>Click on Wilcity Service from admin sidebar -&gt; Update Wilcity Theme or go to <a
                                    href="https://themeforest.net/downloads">https://themeforest.net/downloads</a> ->
                            Download Wilcity -> Extract it -> Re-upload wilcity folder to your themes folder manually
                        </li>
                    </ul>
                </ul>
            </blockquote>
            <div style="text-align: center">-------------------------------------</div>
            <div class="entry-content">
                <?php
                echo term_description($oTerm->term_id, $oTerm->taxonomy);
                ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();
