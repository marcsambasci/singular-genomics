<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SG ScrollTrigger Widget.
 *
 * SG ScrollTrigger
 *
 * @since 1.0.0
 */
class SG_ScrollTrigger_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'sg_scrolltrigger_widget';
	}

	public function get_title() {
		return esc_html__( 'SG ScrollTrigger Widget', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-scroll';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'scroll', 'scrolltrigger', 'animation' ];
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
		wp_register_style( 'scrolltrigger-style', get_theme_file_uri() . '/sg-widgets/scrolltriggers.css');

		return [
			'scrolltrigger-style'
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
			'images',
			[
				'label' => esc_html__( 'Add Images', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		for ($i = 1; $i <= 3; $i++) {
			$this->add_control(
				'hr' . $i,
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
				]
			);

			$this->add_control(
				'animation' . $i . '_active',
				[
					'label' => esc_html__( 'Activate animation ' . $i . '?', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::SWITCHER
				]
			);

			$this->add_control(
				'animation' . $i . '_property',
				[
					'label' => esc_html__( 'Property', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'opacity',
					'options' => [
						'opacity'  => esc_html__( 'Opacity', 'plugin-name' ),
						'xPercent'  => esc_html__( 'Horizontal position', 'plugin-name' ),
						'yPercent'  => esc_html__( 'Vertical position', 'plugin-name' ),
						'scale'  => esc_html__( 'Scale', 'plugin-name' ),
						'clipPath'  => esc_html__( 'Mask', 'plugin-name' ),
						'polygon'  => esc_html__( 'Polygon mask', 'plugin-name' ),
						'transform'  => esc_html__( 'Transform', 'plugin-name' ),
						'sequence'  => esc_html__( 'Image sequence', 'plugin-name' ),
					],
					'condition' => [
						'animation' . $i . '_active' => 'yes'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_selector',
				[
					'label' => esc_html__( 'Selector (default: empty)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '', 'plugin-name' ),
					'placeholder' => esc_html__( 'Selector', 'plugin-name' ),
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property!' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_from',
				[
					'label' => esc_html__( 'From', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '0', 'plugin-name' ),
					'placeholder' => esc_html__( 'Property value at start', 'plugin-name' ),
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property!' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_to',
				[
					'label' => esc_html__( 'To', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( '1', 'plugin-name' ),
					'placeholder' => esc_html__( 'Property value at end', 'plugin-name' ),
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property!' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_startoffset',
				[
					'label' => esc_html__( 'Start offset % (default: 0)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 25,
					'default' => 0,
					'condition' => [
						'animation' . $i . '_active' => 'yes'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_endoffset',
				[
					'label' => esc_html__( 'End offset % (default: 0)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 25,
					'default' => 0,
					'condition' => [
						'animation' . $i . '_active' => 'yes'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_fromduration',
				[
					'label' => esc_html__( 'From duration (default: 1)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 1,
					'default' => 1,
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property!' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_toduration',
				[
					'label' => esc_html__( 'To duration (default: 0)', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 1,
					'default' => 0,
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property!' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_sequencebg',
				[
					'label' => esc_html__( 'Keep first frame as background?', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property' => 'sequence'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_offsetx',
				[
					'label' => esc_html__( 'Next frames offset X', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 1,
					'default' => 0,
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property' => 'sequence',
						'animation' . $i . '_sequencebg' => 'yes'
					]
				]
			);

			$this->add_control(
				'animation' . $i . '_offsety',
				[
					'label' => esc_html__( 'Next frames offset Y', 'plugin-name' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'step' => 1,
					'default' => 0,
					'condition' => [
						'animation' . $i . '_active' => 'yes',
						'animation' . $i . '_property' => 'sequence',
						'animation' . $i . '_sequencebg' => 'yes'
					]
				]
			);
		}
		
		$this->end_controls_section();
	}

	protected function render() {
		$id = "sg-scrolltrigger-" . uniqid();
		$settings = $this->get_settings_for_display();

		?>

		<div class="sg-scrolltrigger" id="<?php echo $id; ?>">
			<div class="image">
			<?php if (($settings['animation1_property'] == 'sequence' && $settings['animation1_active'] == 'yes') || ($settings['animation2_property'] == 'sequence' && $settings['animation2_active'] == 'yes') || ($settings['animation3_property'] == 'sequence' && $settings['animation3_active'] == 'yes')) { ?>
				<canvas></canvas>
			<?php } else { ?>
				<?php foreach ( $settings['images'] as $image ) { ?>
					<img src="<?php echo esc_attr( $image['url'] ); ?>" alt="<?php echo get_post_meta($image['id'], '_wp_attachment_image_alt', TRUE); ?>">
				<?php } ?>
			<?php } ?>
			</div>
		</div>
		
		<script>
			window.addEventListener("load", () => {
				let firstLoad = true;

				const el = document.getElementById("<?php echo $id; ?>");

				ScrollTrigger.saveStyles("#<?php echo $id; ?> .image, #<?php echo $id; ?> .image img");

				ScrollTrigger.matchMedia({
					"(min-width: 960px)": function() {
						if (firstLoad) {
							firstLoad = false;
						} else {
							gsap.set("#<?php echo $id; ?> .image, #<?php echo $id; ?> .image img", {clearProps: "all"});
						}

						<?php
							for ($i = 1; $i <= 3; $i++) {
								if ($settings['animation' . $i . '_active'] == 'yes') {
									if ($settings['animation' . $i . '_property'] == 'sequence') {
						?>

						const imagePaths = [
							<?php
								foreach ( $settings['images'] as $image ) {
									echo '"' . esc_attr( $image['url'] ) . '",';
								}
							?>
						];

						/**
						 * Canvas Configuration
						 */

						const canvas = el.querySelector("canvas");
						const context = canvas.getContext("2d");

						/** These constants work at a global scope because all of the sequence images are the same size */
						const CANVAS_WIDTH = <?php echo wp_get_attachment_metadata($settings['images'][0]['id'])['width']; ?>;
						const CANVAS_HEIGHT = <?php echo wp_get_attachment_metadata($settings['images'][0]['id'])['height']; ?>;
						const DESKTOP_BREAKPOINT = 960;

						canvas.width = CANVAS_WIDTH;
						canvas.height = CANVAS_HEIGHT;

						/**
						 * Image sequence configuration
						 */

						const frameCount = <?php echo count($settings['images']); ?>;
						const images = [];
						const sequence = { frame: 0 };
						let previousFrame = 0;

						/**
						 * Helper functions
						 */

						function isDesktop() {
							const isAnimated = window.innerWidth >= DESKTOP_BREAKPOINT;
							return isAnimated;
						}

						function loadImage(path) {
							return new Promise(resolve => {
								const img = new Image();
								const offscreenCanvas = document.createElement("canvas");
								const offscreenCanvasContext = offscreenCanvas.getContext("2d");
								
								// Create image and paint to offscreen canvas
								img.src = path;
								img.onload = () => {
									offscreenCanvas.width = img.width;
									offscreenCanvas.height = img.height;
									resolve(offscreenCanvasContext.drawImage(img, 0, 0));
								}
								
								// Push canvas to images array
								images.push(offscreenCanvas);
							});
						}

						function isSafari() {
							return window.safari !== undefined;
						}

						/**
						 * Draw first frame
						 */

						function drawFirstFrame() {
							const firstFrame = new Image();
							firstFrame.src = isDesktop() ? imagePaths[0] : imagePaths[imagePaths.length - 1];
							firstFrame.onload = () => {
								context.drawImage(firstFrame, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
								canvas.classList.add("first-frame-loaded");
								el.classList.add("loaded");
							};
						}

						/**
						 * Loading images and init sequence
						 */

						drawFirstFrame();

						if (isDesktop()) {
							const loadImages = paths => Promise.all(paths.map(loadImage));
							loadImages(imagePaths);
						} else {
							document.body.classList.add("loaded");
						}

						/**
						 * GSAP animation
						 */

						gsap.to(sequence, {
							frame: frameCount - 1,
							snap: "frame",
							ease: "none",
							scrollTrigger: {
								trigger: el.closest("section"),
								start: "top+=<?php echo $settings['animation' . $i . '_startoffset']; ?>% top",
								end: "bottom+=<?php echo $settings['animation' . $i . '_endoffset']; ?>% top",
								scrub: 0.5
							},
							onUpdate: () => {
								if (sequence.frame !== previousFrame) {
									previousFrame = sequence.frame;

									context.clearRect(0, 0, canvas.width, canvas.height);

									<?php if ($settings['animation' . $i . '_sequencebg'] == 'yes') { ?>

									context.drawImage(images[0], 0, 0);

									if (sequence.frame !== 0) {
										context.drawImage(images[sequence.frame], <?php echo $settings['animation' . $i . '_offsetx']; ?>, <?php echo $settings['animation' . $i . '_offsety']; ?>);
									}

									<?php } else { ?>

									context.drawImage(images[sequence.frame], 0, 0);
									
									<?php } ?>
								}
							}
						});
						<?php
									}
									else if ($settings['animation' . $i . '_property'] == 'polygon') {
						?>

						const points = [<?php echo $settings['animation' . $i . '_from']; ?>];

						gsap.timeline({
							scrollTrigger: {
								trigger: el.closest("section"),
								start: "top+=<?php echo $settings['animation' . $i . '_startoffset']; ?>% top",
								end: "bottom+=<?php echo $settings['animation' . $i . '_endoffset']; ?>% top",
								scrub: true,
								ease: "none",
								onUpdate: () => {
									let r = points.reduce((prev, current, i, arr) => {
										return prev + current + "%" + (i === arr.length - 1 ? ")" : (i % 2 === 0 ? " " : ", "));
									}, "polygon(");

									document.querySelector("#<?php echo $id; ?> .image <?php echo $settings['animation' . $i . '_selector']; ?>").style.clipPath = r;
								}
							}
						}).from(points, [<?php echo $settings['animation' . $i . '_from']; ?>])
							.to(points, [<?php echo $settings['animation' . $i . '_to']; ?>]);

						<?php
									}
									else {
						?>

						gsap.timeline({
							scrollTrigger: {
								trigger: el.closest("section"),
								start: "top+=<?php echo $settings['animation' . $i . '_startoffset']; ?>% top",
								end: "bottom+=<?php echo $settings['animation' . $i . '_endoffset']; ?>%",
								scrub: true
							}
						}).from("#<?php echo $id; ?> .image <?php echo $settings['animation' . $i . '_selector']; ?>", {"<?php echo $settings['animation' . $i . '_property']; ?>": "<?php echo $settings['animation' . $i . '_from']; ?>", duration:  <?php echo $settings['animation' . $i . '_fromduration']; ?>, stagger: 0.2})
							.to("#<?php echo $id; ?> .image <?php echo $settings['animation' . $i . '_selector']; ?>", {"<?php echo $settings['animation' . $i . '_property']; ?>": "<?php echo $settings['animation' . $i . '_to']; ?>", duration:  <?php echo $settings['animation' . $i . '_toduration']; ?>, stagger: 0.2});

						<?php
									}
								}
							}
						?>

					}
				});

				<?php if (!(($settings['animation1_property'] == 'sequence' && $settings['animation1_active'] == 'yes') || ($settings['animation2_property'] == 'sequence' && $settings['animation2_active'] == 'yes') || ($settings['animation3_property'] == 'sequence' && $settings['animation3_active'] == 'yes'))) { ?>

				el.classList.add("loaded");

			<?php } ?>});
		</script>

		<?php
	}

	protected function content_template() {
		?>

		<div class="sg-scrolltrigger">
			<img src="<?php echo esc_attr( $settings['images'][0]['url'] ); ?>">
		</div>

		<?php
	}
}
