<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SG ScrollCounter Widget.
 *
 * SG ScrollCounter
 *
 * @since 1.0.0
 */
class SG_ScrollCounter_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'sg_scrollcounter_widget';
	}

	public function get_title() {
		return esc_html__( 'SG ScrollCounter Widget', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-scroll';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'scroll', 'scrolltrigger', 'animation', 'counter' ];
	}

	public function get_script_depends() {
		wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js' );
		wp_register_script( 'scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js' );
		
		return [
			'gsap',
			'scrolltrigger'
		];
	}

	public function get_style_depends() {
		// wp_register_style( 'scrolltrigger-style', get_theme_file_uri() . '/sg-widgets/scrolltrigger.css');

		return [
			// 'scrolltrigger-style'
		];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text (use $$$ for counter)', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( '', 'plugin-name' ),
				'placeholder' => esc_html__( 'Text', 'plugin-name' )
			]
		);

		$this->add_control(
			'from',
			[
				'label' => esc_html__( 'From', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 0
			]
		);

		$this->add_control(
			'to',
			[
				'label' => esc_html__( 'To', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 1,
				'default' => 100
			]
		);

		$this->add_control(
			'startoffset',
			[
				'label' => esc_html__( 'Start offset % (default: 0)', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 25,
				'default' => 0
			]
		);

		$this->add_control(
			'endoffset',
			[
				'label' => esc_html__( 'End offset % (default: 0)', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'step' => 25,
				'default' => 0
			]
		);
		
		$this->end_controls_section();
	}

	protected function render() {
		$id = "sg-scrolltrigger-" . uniqid();
		$settings = $this->get_settings_for_display();

		?>

		<div class="sg-scrollcounter" id="<?php echo $id; ?>">
			<?php echo str_replace('$$$', '<span>' . $settings['from'] . '</span>', $settings['text']); ?>
		</div>
		
		<script>
			window.addEventListener("load", () => {
				const el = document.getElementById("<?php echo $id; ?>");

				ScrollTrigger.saveStyles("#<?php echo $id; ?>");

				ScrollTrigger.matchMedia({
					"(min-width: 960px)": function() {
						const frameCount = <?php echo abs($settings['to'] - $settings['from']) + 1; ?>;
						const sequence = {
							frame: 0
						};
						const from = <?php echo $settings['from']; ?>;
						const to = <?php echo $settings['to']; ?>;

						gsap.to(sequence, {
							frame: frameCount - 1,
							snap: "frame",
							ease: "none",
							scrollTrigger: {
								trigger: el.closest("section"),
								start: "top+=<?php echo $settings['startoffset']; ?>% top",
								end: "bottom+=<?php echo $settings['endoffset']; ?>% top",
								scrub: 0.5
							},
							onUpdate: () => {
								el.querySelector("span").textContent = from + ((to - from) / ( frameCount - 1)) * sequence.frame;
							}
						});
					}
				});
			});
		</script>

		<?php
	}

	protected function content_template() {
		?>

		<div class="sg-scrollcounter">
			{{ settings.text.replace("$$$", settings.from) }}
		</div>

		<?php
	}
}
