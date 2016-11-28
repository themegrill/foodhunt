<?php
/**
 * FoodHunt Theme Customize Controls.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.5
 */

// Radio Image controls
class FOODHUNT_Image_Radio_Control extends WP_Customize_Control {

	public function render_content() {

		if ( empty( $this->choices ) )
			return;

		$name = '_customize-radio-' . $this->id;

		?>
		<style>
			#foodhunt-img-container .foodhunt-radio-img-img {
				border: 3px solid #DEDEDE;
				margin: 0 5px 5px 0;
				cursor: pointer;
				border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
			}
			#foodhunt-img-container .foodhunt-radio-img-selected {
				border: 3px solid #AAA;
				border-radius: 3px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px;
			}
			input[type=checkbox]:before {
				content: '';
				margin: -3px 0 0 -4px;
			}
		</style>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<ul class="controls" id = 'foodhunt-img-container'>
		<?php
			foreach ( $this->choices as $value => $label ) :
				$class = ($this->value() == $value)?'foodhunt-radio-img-selected foodhunt-radio-img-img':'foodhunt-radio-img-img';
				?>
				<li style="display: inline;">
				<label>
					<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
				</label>
				</li>
				<?php
			endforeach;
		?>
		</ul>
		<script type="text/javascript">

			jQuery(document).ready(function($) {
				$('.controls#foodhunt-img-container li img').click(function(){
					$('.controls#foodhunt-img-container li').each(function(){
						$(this).find('img').removeClass ('foodhunt-radio-img-selected') ;
					});
					$(this).addClass ('foodhunt-radio-img-selected') ;
				});
			});

		</script>
		<?php
	}
}

if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
	// Custom CSS setting
	class FOODHUNT_Custom_CSS_Control extends WP_Customize_Control {

		public $type = 'custom_css';

		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}
}

// Theme important links
class FOODHUNT_Important_Links extends WP_Customize_Control {

	public $type = "foodhunt-important-links";

	public function render_content() {
		//Add Theme instruction, Support Forum, Demo Link
		$important_links = array(
			'theme-info' => array(
				'link' => esc_url('http://themegrill.com/themes/foodhunt/'),
				'text' => __('Theme Info', 'foodhunt'),
			),
			'documentation' => array(
				'link' => esc_url( 'http://docs.themegrill.com/foodhunt/' ),
				'text' => esc_html__( 'Documentation', 'foodhunt' ),
			),
			'support' => array(
				'link' => esc_url( 'http://themegrill.com/support-forum/' ),
				'text' => esc_html__( 'Support', 'foodhunt' ),
			),
			'demo' => array(
				'link' => esc_url( 'http://demo.themegrill.com/foodhunt/' ),
				'text' => esc_html__( 'View Demo', 'foodhunt' ),
			),
			'rating' => array(
				'link' => esc_url('http://wordpress.org/support/view/theme-reviews/foodhunt?filter=5'),
				'text' => __( 'Rate this theme', 'foodhunt' ),
			)
		);

		foreach ( $important_links as $important_link ) {
			echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
		}
	}
}
