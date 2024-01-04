<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * SG Hero Animation Widget.
 *
 * SG Hero Animation
 *
 * @since 1.0.0
 */
class SG_Hero_Animation_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'sg_hero_animation_widget';
	}

	public function get_title() {
		return esc_html__( 'SG Hero Animation Widget', 'plugin-name' );
	}

	public function get_icon() {
		return 'eicon-animation';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_keywords() {
		return [ 'hero', 'animation', 'sequence' ];
	}

	public function get_script_depends() {}

	public function get_style_depends() {}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'intro',
			[
				'label' => esc_html__( 'Intro images', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop images', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'fps',
			[
				'label' => esc_html__( 'FPS', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 60,
				'step' => 1,
				'default' => 30,
			]
		);

		$this->add_control(
			'loopduration',
			[
				'label' => esc_html__( 'Loop duration (s)', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0.25,
				'max' => 10,
				'step' => 0.25,
				'default' => 2,
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		
		<canvas id="sg-hero-animation-element"></canvas>
		<script>
			const intro = [
				<?php
				foreach ( $settings['intro'] as $image ) {
					echo '"' . esc_attr( $image['url'] ) . '",';
				}
				?>
			
			];

			const loop = [
				<?php
				foreach ( $settings['loop'] as $image ) {
					echo '"' . esc_attr( $image['url'] ) . '",';
				}
				?>
			
			];

			/**
			 * Canvas configuration
			 */

			const canvas = document.getElementById("sg-hero-animation-element");
			const context = canvas.getContext("2d");
			
			/** These constants work at a global scope because all of the sequence images are the same size */
			const CANVAS_WIDTH = <?php echo wp_get_attachment_metadata($settings['intro'][count($settings['intro'])-1]['id'])['width']; ?>;
			const CANVAS_HEIGHT = <?php echo wp_get_attachment_metadata($settings['intro'][count($settings['intro'])-1]['id'])['height']; ?>;
			const DESKTOP_BREAKPOINT = 960;

			canvas.width = CANVAS_WIDTH;
			canvas.height = CANVAS_HEIGHT;

			/**
			 * Image sequence configuration
			 */

			const images = [];
			const fps = <?php echo $settings['fps']; ?>;
			const loopDuration = <?php echo $settings['loopduration']; ?>;
			let frame = 0;
			let fpsInterval;
			let startTime;
			let now;
			let then;
			let elapsed;

			function startAnimating() {
				fpsInterval = 1000 / fps;
				then = Date.now();
				startTime = then;

				document.body.classList.add("sg-hero-animation-started");

				requestAnimationFrame(animate);
			}

			/**
			 * Helper functions
			 */
			function smoothstep(edge0, edge1, x) {
				x = Math.min(Math.max((x - edge0) / (edge1 - edge0), 0), 1); 
				return x * x * (3 - 2 * x);
			}

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

			function releaseCanvas(canvas) {
				// This seems to be the only way for Safari to reduce memory usage (to 128 bytes)
				canvas.width = 1;
				canvas.height = 1;
				const context = canvas.getContext("2d");
				context && context.clearRect(0, 0, 1, 1);
			}

			/**
			 * Draw first frame
			 */

			function drawFirstFrame() {
				const firstFrame = new Image();
				firstFrame.src = isDesktop() ? intro[0] : intro[intro.length - 1];
				firstFrame.onload = () => {
					context.drawImage(firstFrame, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					canvas.classList.add("first-frame-loaded");
				};
			}

			/**
			 * Animate image sequence
			 */

			function animate() {
				now = Date.now();
				elapsed = now - then;
				
				if (elapsed > fpsInterval) {
					then = now - (elapsed % fpsInterval);
					frame += 1;

					context.clearRect(0, 0, canvas.width, canvas.height);

					if (frame < intro.length) {
						context.drawImage(images[frame], 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);

						// 'release' previous frame after we're doing using it
						releaseCanvas(images[frame - 1]);
					} else {
						context.globalAlpha = 1;
						context.drawImage(images[intro.length - 1], 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
						
						const loopFrame = (frame - intro.length) % (loopDuration * fps);
						const alpha = smoothstep(0, 0.5 * loopDuration * fps, loopFrame) * smoothstep(loopDuration * fps, 0.5 * loopDuration * fps, loopFrame);
						
						context.globalAlpha = alpha;
						context.drawImage(images[intro.length], 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					}
				}

				requestAnimationFrame(animate);
			}

			/**
			 * Loading images and init sequence
			 */
			drawFirstFrame();

			if (isDesktop()) {
				const loadImages = paths => Promise.all(paths.map(loadImage));
				loadImages(intro)
					.then(startAnimating)
					.catch((error) => {
						console.error('Load Images Error: ', error);
						document.body.classList.add("sg-hero-animation-started");
					});
				loadImages(loop);
			} else {
			 	document.body.classList.add("sg-hero-animation-started");
			}
			
			/**
			 * Window event Listeners
			 */
			window.addEventListener("scroll", () => {
				if (window.scrollY / window.innerHeight > 0.5) document.body.classList.add("sg-hero-animation-stop");
			}, {once: true});
		</script>
		<div class="sg-hero-animation-background"></div>

		<?php
	}

	protected function content_template() {
		?>

		<img id="sg-hero-animation-element" src="<?php echo esc_attr( $settings['intro'][0]['url'] ); ?>">

		<?php
	}
}
