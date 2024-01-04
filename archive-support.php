<?php

/**
 * The template for displaying support doc archive pages.
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
get_header();
?>
<main id="content" class="sd-site-main">

	<?php get_template_part( 'template-parts/archive-heading' ); ?>

	<div class="page-content container py-5">
		<div class="row">
			<div class="aside col-25">
				<?php get_template_part( 'template-parts/vertical-menu' ); ?>
			</div>
			<div class="main col-75">
				
				<?php get_template_part( 'template-parts/archive-hero' ); ?>
				
				<?php get_template_part( 'template-parts/searchform' ); ?>

				<?php if (apply_filters('hello_elementor_page_title', true)) : ?>
					<header class="sd-page-header">
						<?php
						the_archive_title('<h2 class="entry-title">', '</h2>');
						the_archive_description();
						?>
					</header>
					<div class="sep-line my-4"></div>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/archive-query-loop' ); ?>

			</div>
		</div>
	</div>

	<?php wp_link_pages(); ?>

</main>

<?php get_footer(); ?>