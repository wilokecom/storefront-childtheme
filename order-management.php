<?php
/*
 * Template Name: Order Management
 */

get_header(); ?>

	<div id="primary" class="content-area" style="width: 90%">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) :
				get_template_part( 'loop' );
			else :
				get_template_part( 'content', 'none' );
			endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
