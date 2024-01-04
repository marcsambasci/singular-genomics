<?php
/**
 * The template for displaying search results.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
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
				
				<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
				<div class="sd-hero">
					<h2 class="sd-hero-title">
						<?php echo esc_html__( 'Search results for: ', 'hello-elementor' ); ?>
						<span><?php echo get_search_query(); ?></span>
					</h2>
				</div>
				<?php endif; ?>

				<?php if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						$post_link = get_permalink();
						?>
						<article class="post">
							<?php
							printf( '<h2 class="%s"><a href="%s">%s</a></h2>', 'entry-title', esc_url( $post_link ), wp_kses_post( get_the_title() ) );
							if ( has_post_thumbnail() ) {
								printf( '<a href="%s">%s</a>', esc_url( $post_link ), get_the_post_thumbnail( $post, 'large' ) );
							}
							the_excerpt();
							?>
						</article>
						<?php
					endwhile;
					?>
				<?php else : ?>
					<p><?php echo esc_html__( 'It seems we can\'t find what you\'re looking for.', 'hello-elementor' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php wp_link_pages(); ?>

	<?php
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
		?>
		<nav class="pagination">
			<?php /* Translators: HTML arrow */ ?>
			<div class="nav-previous"><?php next_posts_link( sprintf( __( '%s older', 'hello-elementor' ), '<span class="meta-nav">&larr;</span>' ) ); ?></div>
			<?php /* Translators: HTML arrow */ ?>
			<div class="nav-next"><?php previous_posts_link( sprintf( __( 'newer %s', 'hello-elementor' ), '<span class="meta-nav">&rarr;</span>' ) ); ?></div>
		</nav>
	<?php endif; ?>

</main>
<?php get_footer(); ?>