<?php
/**
 * The template for displaying singular post-types: support doc custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

while ( have_posts() ) : the_post(); ?>

<main id="content" class="sd-site-main" <?php post_class( 'site-main' ); ?>>

	<?php get_template_part( 'template-parts/archive-heading' ); ?>

	<div class="page-content container py-5">
		<div class="row">
			<div class="aside col-25">
				<?php get_template_part( 'template-parts/vertical-menu' ); ?>
			</div>
			<div class="main col-75">
				
				<?php get_template_part( 'template-parts/archive-hero' ); ?>

				<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
					<header class="sd-page-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>
				<?php endif; ?>

				<?php the_content(); ?>

				<div class="sep-line my-4"></div>

				<?php get_template_part( 'template-parts/relatedposts' ); ?>

				<?php wp_link_pages(); ?>

				<?php comments_template(); ?>

			</div>
		</div>
	</div>
</main>

<?php endwhile;

get_footer();
