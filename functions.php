<?php

/**
 * Enqueue scripts and styles
 */
function sambasci_custom_scripts()
{
	wp_enqueue_style('child-style', get_stylesheet_uri(), array(), false);

	if (is_post_type_archive('support') || is_singular('support') || is_tax(['support-category', 'support-tag'])) {
		wp_enqueue_script('support', get_stylesheet_directory_uri() . '/support.js', array('jquery'), null, true);
	}
}
add_action('wp_enqueue_scripts', 'sambasci_custom_scripts');

/**
 * Allows svg upload to the media library
 */
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Remove post type, this block can be removed if we introduce this functionality in the future
 */

/**
 * Remove side menu
 */
/*
function remove_default_post_type() {
    remove_menu_page( 'edit.php' );
}

add_action( 'admin_menu', 'remove_default_post_type' );
*/
/**
 * Remove +New post in top Admin Menu Bar
 */
/*
function remove_default_post_type_menu_bar( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'new-post' );
}

add_action( 'admin_bar_menu', 'remove_default_post_type_menu_bar', 999 );
*/
/**
 * Replace # with js so link can be navigated to via keyboard
 * @param string $menu_item item HTML
 * @return string item HTML
 */
function wpse_226884_replace_hash($menu_item)
{
	if (strpos($menu_item, 'href="#"') !== false) {
		$menu_item = str_replace('href="#"', 'href="javascript:void(0);"', $menu_item);
	}
	return $menu_item;
}

add_filter('walker_nav_menu_start_el', 'wpse_226884_replace_hash', 999);

/**
 * Remove Quick Draft Dashboard Widget
 */
function remove_draft_widget()
{
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}

add_action('wp_dashboard_setup', 'remove_draft_widget', 999);

/**
 * End remove post type
 */

/**
 * Add custom Elementor widgets
 */
require_once('sg-widgets/sg-widgets.php');
add_filter('wp_lazy_loading_enabled', '__return_false');

// disable srcset on frontend
function disable_wp_responsive_images()
{
	return 1;
}
add_filter('max_srcset_image_width', 'disable_wp_responsive_images');

add_filter('pa_display_conditions_values', function ($apply) {
	return false;
});

/**
 * Remove "Category:", "Tag:", "Author:" from the_archive_title
 */
function remove_archive_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	}

	return $title;
}
add_filter('get_the_archive_title', 'remove_archive_title');

/**
 * Support post type template chooser
 */
function render_search_template($template)
{
	global $wp_query;
	$post_type = get_query_var('post_type');
	$taxonomy = get_query_var('taxonomy');

	if (!empty($wp_query->is_search) && ($post_type == 'support' || is_page('technical-resources'))) {
		return locate_template('search-support.php');
	}

	if (!empty($wp_query->is_tax) && $taxonomy  == 'support-category') {
		return locate_template('archive-support.php');
	}

	return $template;
}
add_filter('template_include', 'render_search_template');

/**
 * Relevanssi indexing attachment file names
 */
function rlv_add_filenames($content, $post)
{
	if ('attachment' === $post->post_type) {
		$content .= ' ' . basename($post->guid);
	}
	return $content;
}
add_filter('relevanssi_content_to_index', 'rlv_add_filenames', 10, 2);

/**
 * Override Relevanssi default styles
 */
add_filter('relevanssi_live_search_base_styles', '__return_false');

/**
 * Shortcode to display user meta and logout link
 */
function hs_user_meta_shortcode($atts, $content = null)
{
	$atts = shortcode_atts(
		array(
			'name'	  	  => true,
			'email'	  	  => true,
			'company' 	  => true,
			'logout_link' => true,
		),
		$atts,
		'user_meta'
	);

	$customer = new \stdClass;
	$current_user = wp_get_current_user();
	$customer->user_email = $current_user->user_email;
	$contact = new SambaHubSpotHelper\Singular\Contact($customer);
	$hs_contact = $contact->get_contact();

	ob_start();

?>

	<div class="user-meta-container">

		<ul class="user-meta">

			<?php if ($atts['name']) :

				if ($hs_contact->first_name || $hs_contact->last_name) : ?>

					<li><?php echo $hs_contact->first_name . ' ' . $hs_contact->last_name; ?></li>

				<?php else : ?>

					<li><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname; ?></li>

				<?php endif;

			endif;

			if ($atts['email']) :

				if ($hs_contact->email) : ?>

					<li><?php echo $hs_contact->email; ?></li>

				<?php else : ?>

					<li><?php echo $current_user->user_email; ?></li>

				<?php endif;

			endif;

			if ($hs_contact->company) : ?>

				<li><?php echo $hs_contact->company; ?></li>

			<?php endif;

			if ($atts['logout_link']) : ?>

				<li><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Log out', 'hello-elementor'); ?></a></li>

			<?php endif; ?>

		</ul>

	</div>

<?php

	$output = ob_get_contents();

	ob_end_clean();

	return $output;
}
add_shortcode('user_meta', 'hs_user_meta_shortcode');

/**
 * Shortcode to display user meta and logout link
 */
function searchform_shortcode($atts)
{

	// Attributes
	$atts = shortcode_atts(
		array(
			'post_type' => '',
		),
		$atts,
		'searchform'
	);

	$output = '<form role="search" action="' . esc_url(home_url('/')) . '" method="get" class="search-form" id="searchform">
					<input type="search" class="search-field" name="s" placeholder="' . esc_attr_x('Search for answers', 'placeholder') . '" value="' . esc_html(get_search_query()) . '" data-rlvlive="true" data-rlvparentel="#rlvlive" data-rlvconfig="default" />';

	if ($atts['post_type']) {
		$output .= '<input type="hidden" name="post_type" value="' . esc_html($atts['post_type']) . '" />';
	}

	$output .= '<div id="rlvlive"></div></form>';

	return $output;
}
add_shortcode('searchform', 'searchform_shortcode');
