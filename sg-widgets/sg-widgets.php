<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register SG Button Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
/** function register_sg_button_widget( $widgets_manager ) {

	require_once( __DIR__ . '/sg-button-widget.php' );

	$widgets_manager->register( new \SG_Button_Widget() );

}
add_action( 'elementor/widgets/register', 'register_sg_button_widget' );
*/

/**
 * Register SG Hero Animation Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_sg_hero_animation_widget( $widgets_manager ) {

	require_once( __DIR__ . '/sg-hero-animation-widget.php' );

	$widgets_manager->register( new \SG_Hero_Animation_Widget() );

}
add_action( 'elementor/widgets/register', 'register_sg_hero_animation_widget' );

/**
 * Register SG ScrollTrigger Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_sg_scrolltrigger_widget( $widgets_manager ) {

	require_once( __DIR__ . '/sg-scrolltrigger-widget.php' );

	$widgets_manager->register( new \SG_ScrollTrigger_Widget() );

}
add_action( 'elementor/widgets/register', 'register_sg_scrolltrigger_widget' );

/**
 * Register SG ScrollCounter Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_sg_scrollcounter_widget( $widgets_manager ) {

	require_once( __DIR__ . '/sg-scrollcounter-widget.php' );

	$widgets_manager->register( new \SG_ScrollCounter_Widget() );

}
add_action( 'elementor/widgets/register', 'register_sg_scrollcounter_widget' );
