<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage FoodHunt
 * @since 0.1
 */


// Function to register the widget areas(sidebar) and widgets.
function foodhunt_widgets_init() {

	// Registering main right sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Right Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_right_sidebar',
		'description'     => esc_html__( 'Shows widgets at Right side.', 'foodhunt' ),
		'before_widget'   => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</aside>',
		'before_title'    => '<h4 class="widget-title"><span>',
		'after_title'     => '</span></h4>'
		) );
	// Registering main left sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Left Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_left_sidebar',
		'description'     => esc_html__( 'Shows widgets at Left side.', 'foodhunt' ),
		'before_widget'   => '<aside id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</aside>',
		'before_title'    => '<h4 class="widget-title"><span>',
		'after_title'     => '</span></h4>'
		) );
	// Registering Restaurant Template sidebar
	register_sidebar( array(
		'name'            => esc_html__( 'Restaurant Template Sidebar', 'foodhunt' ),
		'id'              => 'foodhunt_business_sidebar',
		'description'     => esc_html__( 'Shows widgets On the Restaurant Template.', 'foodhunt' ),
		'before_widget'   => '<section id="%1$s" class="widget %2$s clearfix">',
		'after_widget'    => '</section>',
		'before_title'    => '<h3 class="section-title">',
		'after_title'     => '</h3>'
		) );
	// Registering Footer sidebar
	for( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array(
			'name'            => esc_html__( 'Footer Sidebar ', 'foodhunt' ) . $i,
			'id'              => 'foodhunt_footer_sidebar'.$i,
			'description'     => esc_html__( 'Show widgets at Footer section.', 'foodhunt' ),
			'before_widget'   => '<aside id="%1$s" class="widget footer-block %2$s clearfix">',
			'after_widget'    => '</aside>',
			'before_title'    => '<h4 class="widget-title"><span>',
			'after_title'     => '</span></h4>'
			) );
	}
	register_widget( "foodhunt_about_us_widget" );
	register_widget( "foodhunt_service_widget" );
	register_widget( "foodhunt_call_to_action_widget" );
	register_widget( "foodhunt_our_team_widget" );
	register_widget( "foodhunt_featured_posts_widget" );
	register_widget( "foodhunt_portfolio_widget" );
	register_widget( "foodhunt_contact_widget" );
}
add_action( 'widgets_init', 'foodhunt_widgets_init');

/**************************************************************************************/

/**
 * About us section.
 */
class foodhunt_about_us_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'about-section', 'description' => esc_html__( 'Suitable for About Us page.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Featured Single Page', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults['title'] = '';
		$defaults['text'] = '';
		$defaults['page_id'] = '';
		$defaults['button_text'] = '';
		$defaults['button_url'] = '';
		$defaults['button_icon'] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$page_id = absint( $instance['page_id'] );
		$button_text = esc_attr( $instance['button_text'] );
		$button_url = esc_url( $instance['button_url'] );
		$button_icon = esc_attr( $instance['button_icon'] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p><?php esc_html_e( 'Select a page to display Title, Excerpt and Featured image.' , 'foodhunt' ) ?></p>
		<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Page', 'foodhunt' ); ?>:</label>
		<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'page_id' ), 'selected' => $page_id ) ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php esc_html_e( 'Button Redirect Link:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_icon' ); ?>"><?php esc_html_e( 'Button Icon Class:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_icon' ); ?>" name="<?php echo $this->get_field_name( 'button_icon' ); ?>" placeholder="fa-cutlery" type="text" value="<?php echo $button_icon; ?>" />
		</p>

		<p>
			<?php
			$url = 'http://fontawesome.io/icons/';
			$link = sprintf( wp_kses( __( 'For Icon Class <a href="%s" target="_blank">Refer here</a>', 'foodhunt' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
			echo $link;
			?>
		</p>
		<p><?php esc_html_e( 'Info: The Recommended size for featured image is 530px by 440px.', 'foodhunt' ); ?></p>
		<p><?php esc_html_e( 'Note: Leave Button Redirect Link empty to redirect it to the respective page.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') ) {
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		}
		else {
		$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed
		}

		$instance[ 'page_id' ] = absint( $new_instance[ 'page_id' ] );
		$instance[ 'button_text' ] = sanitize_text_field( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );
		$instance[ 'button_icon' ] = sanitize_text_field( $new_instance[ 'button_icon' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance['text'], $instance );
		$page_id = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = empty( $instance[ 'button_url' ] ) ? '' : $instance[ 'button_url' ];
		$button_icon = isset( $instance[ 'button_icon' ] ) ? $instance[ 'button_icon' ] : '';

		echo $before_widget; ?>

		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
					<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<?php if( $page_id ) : ?>
					<div class="about-wrapper clearfix">
						<?php
						$the_query = new WP_Query( 'page_id='.$page_id );
						while( $the_query->have_posts() ):$the_query->the_post();

							if( has_post_thumbnail() ) { ?>
							<figure class="about-img">
								<?php the_post_thumbnail( 'full' ); ?>
							</figure>
							<?php } ?>

							<div class="about-content-wrapper">
								<?php
								$output = '<h3 class="about-title">' . esc_html( get_the_title() ) . '</h3>';

								$output .= '<div class="about-desc">' . '<p>' . esc_html( get_the_excerpt() ) . '</p></div>';

								if( $button_url == '' ) {
									$button_url = get_permalink();
								}

								if( !empty( $button_text ) ) {
									$output .= '<a class="about-btn" href="'. esc_url( $button_url ) . '">' . esc_html( $button_text ) . ' <i class="fa ' . esc_attr( $button_icon ) . '"></i></a>';
								}

								echo $output;
								?>
							</div>
						<?php endwhile;

						// Reset Post Data
						wp_reset_postdata(); ?>
					</div><!-- .about-wrapper -->
				<?php endif; ?>
			</div><!-- .tg-container -->
		</div>

		<?php echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Service Widget section.
 */
class foodhunt_service_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'service-section', 'description' => esc_html__( 'Display some pages as services.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Service', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults['title'] = '';
		$defaults['text'] = '';
		$defaults['number'] = '3';
		$defaults[ 'background_image' ] = '';
		$defaults[ 'background_color' ] = '#4a4a4a';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$text = esc_textarea( $instance['text'] );
		$number = absint( $instance[ 'number' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] ); ?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of pages to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p><?php esc_html_e( 'Note: Create the pages and select Services Template to display Services pages. The Recommended size for featured image is 290px by 290px.', 'foodhunt' ); ?></p>

		<p>
			<strong><?php esc_html_e( 'DESIGN SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'foodhunt' ); ?> </label> <br />
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $background_image != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'foodhunt' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'foodhunt' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'foodhunt' ); ?></button>
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'foodhunt' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#4a4a4a" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo  $background_color; ?>" />
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['background_color'] =  esc_attr( $new_instance['background_color'] );
		$instance['background_image'] =  esc_url_raw( $new_instance['background_image'] );
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
		$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); //   wp_filter_post_kses() expects slashed

		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];

		$page_array = array();
		$pages = get_pages();
		// get the pages associated with Services Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-services.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
			) );

		echo $before_widget;
		$bg_image_class = 'no-bg-image';
		$bg_image_style = '';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}elseif ( $background_color != '#4a4a4a' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}?>
		<div class="section-wrapper clearfix <?php echo esc_attr( $bg_image_class ) ?>" <?php echo $bg_image_style; ?>>
			<?php if ( !empty( $background_image ) ) { echo '<div class="section-overlay"> </div>'; } ?>

			<div class="tg-container">
				<?php if( !empty( $title ) || !empty( $text ) ) { ?>
					<div class="section-title-wrapper">

						<?php if( !empty( $title ) )  {
							echo $before_title . esc_html( $title ) . $after_title;
						}

						if( !empty( $text ) ) {
							echo '<h4 class="sub-title">' . esc_textarea( $text ) . '</h4>';
						} ?>
					</div>
				<?php }

				if( !empty( $page_array ) ) {
					$count = 0; ?>
					<div class="service-wrapper clearfix">
						<div class="tg-column-wrapper clearfix">

							<?php while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
							$foodhunt_duplicate_posts[] = $post->ID;

							if ( $count % 3 == 0 && $count > 1 ) { echo '<div class="clearfix"></div>'; } ?>

							<div class="tg-column-3 service-block">
								<h3 class="service-title">
									<a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>"> <?php echo esc_html( get_the_title() ); ?></a>
								</h3>

								<?php if( has_post_thumbnail() ) { ?>
								<figure class="service-img">
									<?php the_post_thumbnail( 'foodhunt-featured-image' ); ?>
								</figure>
								<?php } ?>

								<div class="service-desc">
									<?php the_excerpt(); ?>
								</div>

								<a class="service-btn" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php  esc_html_e( 'Read More', 'foodhunt' ) ?></a>
							</div>
							<?php $count++;
							endwhile;

							// Reset Post Data
							wp_reset_postdata(); ?>
						</div><!-- .tg-column-wrapper -->
					</div>
				<?php } ?>
			</div>
		</div>
		<?php echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Call to action widget.
 */
class foodhunt_call_to_action_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'cta-section', 'description' => esc_html__( 'Use this widget to show the call to action section.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Call To Action', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'text_main' ] = '';
		$defaults[ 'button_text' ] = '';
		$defaults[ 'button_url' ] = '';
		$defaults[ 'background_image' ] = '';
		$defaults[ 'background_color' ] = '#d40305';
		$defaults[ 'button_icon' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$text_main = esc_textarea( $instance[ 'text_main' ] );
		$button_text = esc_attr( $instance[ 'button_text' ] );
		$button_url = esc_url( $instance[ 'button_url' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] );
		$button_icon = esc_attr( $instance['button_icon'] );
		?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<?php esc_html_e( 'Call to Action Main Text:', 'foodhunt' ); ?>
		<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id( 'text_main' ); ?>" name="<?php echo $this->get_field_name( 'text_main' ); ?>"><?php echo $text_main; ?></textarea>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php esc_html_e( 'Button Text:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php esc_html_e( 'Button Redirect Link:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>

		<p>
			<strong><?php esc_html_e( 'DESIGN SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'foodhunt' ); ?> </label> <br />
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $background_image != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'foodhunt' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'foodhunt' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'foodhunt' ); ?></button>
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'foodhunt' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#d40305" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo  $background_color; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_icon' ); ?>"><?php esc_html_e( 'Button Icon Class:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_icon' ); ?>" name="<?php echo $this->get_field_name( 'button_icon' ); ?>" placeholder="fa-cutlery" type="text" value="<?php echo $button_icon; ?>" />
		</p>

		<p>
			<?php
			$url = 'http://fontawesome.io/icons/';
			$link = sprintf( wp_kses( __( 'For Icon Class <a href="%s" target="_blank">Refer here</a>', 'foodhunt' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
			echo $link;
			?>
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( current_user_can( 'unfiltered_html' ) )
			$instance['text_main'] =  $new_instance['text_main'];
		else
			$instance['text_main'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text_main']) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'button_text' ] = sanitize_text_field( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );
		$instance[ 'background_image' ] =  esc_url_raw( $new_instance[ 'background_image' ] );
		$instance[ 'background_color' ] =  esc_attr( $new_instance[ 'background_color' ] );
		$instance[ 'button_icon' ] = sanitize_text_field( $new_instance[ 'button_icon' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$text_main = empty( $instance[ 'text_main' ] ) ? '' : $instance[ 'text_main' ];
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = empty( $instance[ 'button_url' ] ) ? '#' : $instance[ 'button_url' ];
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';
		$button_icon = isset( $instance[ 'button_icon' ] ) ? $instance[ 'button_icon' ] : '';

		echo $before_widget;
		$bg_image_style = '';
		$bg_image_class = 'no-bg-image';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}elseif ( $background_color != '#d40305' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}?>
		<div class="section-wrapper <?php echo esc_attr( $bg_image_class ); ?> clearfix" <?php echo $bg_image_style; ?>>
			<div class="section-overlay"> </div>
			<div class="tg-container">

				<div class="cta-wrapper">
					<?php if( !empty( $text_main ) ) { ?>
					<div class="cta-desc">
						<?php echo esc_html( $text_main ); ?>
					</div>
					<?php if( !empty( $button_text ) ) { ?>
					<a class="cta-btn" href="<?php echo esc_url( $button_url ); ?>" title="<?php echo esc_attr( $button_text ); ?>"><?php echo esc_html( $button_text ) . '<i class="fa ' . esc_attr( $button_icon ) . '"> </i>' ?> </a>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Our Team section.
 */
class foodhunt_our_team_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'chef-section', 'description' => esc_html__( 'Show your Team Members.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Our Team', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {

		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = '3';
		$defaults[  'background_image' ] = '';
		$defaults[  'background_color' ] = '#5c5c5c';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$background_color = esc_attr( $instance[ 'background_color' ] );
		?>

		<p>
			<strong><?php esc_html_e( 'Widget SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of pages to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p><?php esc_html_e( 'Note: Create the pages and select Our Team Template to display Our Team pages. The Recommended size for featured image is 380px by 380px.', 'foodhunt' ); ?></p>

		<p>
			<strong><?php esc_html_e( 'DESIGN SETTINGS :', 'foodhunt' ); ?></strong><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'foodhunt' ); ?> </label> <br />
			<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
				<div class="custom_media_preview">
					<?php if ( $background_image != '' ) : ?>
						<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="max-width:100%;" />
					<?php endif; ?>
				</div>
				<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="margin-top:5px;" />
				<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'foodhunt' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'foodhunt' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'foodhunt' ); ?></button>
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php esc_html_e( 'Background Color:', 'foodhunt' ); ?></label><br />
			<input class="my-color-picker" type="text" data-default-color="#5c5c5c" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo $background_color; ?>" />
		</p>

		<p><?php esc_html_e( 'Note: Background image (if used) will override the background color.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
		$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance['background_image'] =  esc_url_raw( $new_instance['background_image'] );
		$instance['background_color'] =  esc_attr( $new_instance['background_color'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance[ 'text' ], $instance );
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';

		$page_array = array();
		$pages = get_pages();
		// get the pages associated with Our Team Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-team.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
			) );

		$bg_image_class = 'no-bg-image';
		$bg_image_style = '';
		if ( !empty( $background_image ) ) {
			$bg_image_style = 'style=background-image:url(' . esc_url( $background_image ) . ');background-repeat:no-repeat;background-size:cover;background-attachment:fixed;';
			$bg_image_class = 'section-wrapper-with-bg-image';
		}
		elseif ( $background_color != '#5c5c5c' ) {
			$bg_image_style = 'style=background-color:' . esc_attr( $background_color ) . ';';
		}

		echo $before_widget; ?>
		<div class="section-wrapper <?php echo esc_attr( $bg_image_class ) ?> clearfix" <?php echo $bg_image_style; ?>>

			<div class="tg-container">
				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
						<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<?php if( !empty ( $page_array ) ) :
				$count = 0; ?>
				<div class="chef-wrapper clearfix">
					<div class="tg-column-wrapper clearfix">
						<?php while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();
							$foodhunt_duplicate_posts[] = $post->ID;

							if ( $count % 3 == 0 && $count > 1 ) { ?> <div class="clearfix"></div> <?php }
								$title_attribute = the_title_attribute( 'echo=0' ); ?>

							<div class="tg-column-3 chef-block">

								<?php if( has_post_thumbnail() ) { ?>
								<figure class="chef-img">
									<?php the_post_thumbnail( 'full' ); ?>
								</figure>
								<?php } ?>

								<div class="chef-content-wrapper">
									<?php
									$output = '';
									$output .= '<h3 class="chef-title"> <a href="' . esc_url( get_permalink() ) . '" alt ="' . $title_attribute . '">' . esc_html( get_the_title() ) . '</a></h3>';
									$foodhunt_designation = get_post_meta( $post->ID, 'foodhunt_designation', true );
									if( !empty( $foodhunt_designation ) ) {
										$output .= '<div class="chef-designation">' . esc_html( $foodhunt_designation ) . '</div>';
									}

									$output .= '<div class="chef-desc">' . '<p>' . esc_html( get_the_excerpt() ) . '</p></div>';

									$output .= '<a class="chef-btn" href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '" alt ="' . $title_attribute . '">' . esc_html__( 'Read More' , 'foodhunt' ) . '</a>';

									echo $output; ?>
								</div>
							</div>
							<?php $count++;
						endwhile;

						// Reset Post Data
						wp_reset_postdata(); ?>
					</div><!-- .team-content-wrapper -->
				</div><!-- .chef-wrapper -->

				<?php endif; ?>
			</div><!-- .tg-container -->
		</div>

		<?php echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Featured Posts widget
 */
class foodhunt_featured_posts_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'blog-section', 'description' => esc_html__( 'Display latest posts or posts of specific category.', 'foodhunt') );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false,$name= esc_html__( 'TG: Featured Posts', 'foodhunt' ),$widget_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = 3;
		$defaults[ 'type' ] = 'latest';
		$defaults[ 'category' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] );
		$type = esc_attr( $instance[ 'type' ] );
		$category = absint( $instance[ 'category' ] ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php esc_html_e( 'Description','foodhunt' ); ?>
		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php esc_html_e( 'Show latest Posts', 'foodhunt' );?><br />
			<input type="radio" <?php checked( $type,'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php esc_html_e( 'Show posts from a category', 'foodhunt' );?><br />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Select category', 'foodhunt' ); ?>:</label>
			<?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
		</p>

		<p><?php esc_html_e( 'Info: To display posts from specific category, select the Category in above radio option than select the category from the drop-down list.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can( 'unfiltered_html' ) )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes($new_instance[ 'text' ]) ) ); // wp_filter_post_kses() expects slashed
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );
		$instance[ 'type' ] = esc_attr( $new_instance[ 'type' ] );
		$instance[ 'category' ] = absint( $new_instance[ 'category' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 3 : $instance[ 'number' ];
		$type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
		$category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

		if( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'ignore_sticky_posts'   => true
				) );
		}
		else {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'        => $number,
				'post_type'             => 'post',
				'category__in'          => $category
				) );
		}

		echo $before_widget; ?>

		<div class= "section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php if ( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; } ?>
					<?php if ( !empty( $text ) ) { ?>
					<h4 class="sub-title">
						<?php echo esc_textarea( $text ); ?>
					</h4>
					<?php } ?>
				</div>

				<div class="blog-wrapper clearfix">
					<?php $count = 1;
					while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
						$foodhunt_blog_class = 'blog-block';
						if ( $count % 2 == 0 ) {
							$foodhunt_blog_class .= ' blog-rtl';
						}

						if( has_post_thumbnail() ) { ?>

						<div class="<?php echo esc_attr( $foodhunt_blog_class ); ?> clearfix">

							<div class="blog-img">
								<?php the_post_thumbnail('foodhunt-featured-image'); ?>
							</div>
						<?php }
						else {
						$foodhunt_blog_class .= ' no-featured-image'; ?>

						<div class="<?php echo esc_attr( $foodhunt_blog_class ); ?> clearfix"> <?php } ?>

							<div class="blog-content-wrapper">

								<div class="blog-title-btn-wrap clearfix">
									<h3 class="entry-title blog-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<a href="<?php the_permalink(); ?>" class="blog-btn" title="<?php the_title_attribute();?>"> <i class="fa fa-angle-right"> </i></a>
								</div>

								<div class="entry-meta">
									<span class="byline author">
										<i class="fa fa-user"> </i>
										<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_html( get_the_author() ); ?>"><?php echo esc_html( get_the_author() ); ?></a>
									</span>

									<span class="posted-on">
										<?php
										$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

										$time_string = sprintf( $time_string,
											esc_attr( get_the_date( 'c' ) ),
											esc_html( get_the_date() )
											);
										printf( '<i class="fa fa-calendar"> </i><a href="%1$s" title="%2$s" rel="bookmark"> %3$s</a>',
											esc_url( get_permalink() ),
											esc_attr( get_the_time() ),
											$time_string
											); ?>
									</span>

									<?php if ( comments_open() ) { ?>
										<span class="comment">
											<i class="fa fa-comment"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'foodhunt' ), esc_html__( 'Comment (1)', 'foodhunt' ), esc_html__( 'Comments (%)', 'foodhunt' ) );?>
										</span>
									<?php } ?>
								</div>

								<div class="entry-content blog-desc">
									<?php the_excerpt(); ?>
								</div>
							</div><!-- blog content wrapper -->
						</div><!-- .blog-block -->

						<?php $count++;
					endwhile; ?>
				</div><!-- .blog-wrapper -->
			</div><!-- .tg-container -->
		</div>

		<?php
		// Reset Post Data
		wp_reset_postdata();
		echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Gallery widget section
 */
class foodhunt_portfolio_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'gallery-section', 'description' => esc_html__( 'Display some pages as Portfolio or Gallery.', 'foodhunt') );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false,$name= esc_html__( 'TG: Portfolio', 'foodhunt' ), $widget_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'number' ] = 8;

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance[ 'text' ] );
		$number = absint( $instance[ 'number' ] ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of pages to display:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p><?php esc_html_e( 'Note: Create the pages and select Gallery Template to display Gallery pages. The Recommended size for featured image is 340px by 340px.', 'foodhunt' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
		if ( current_user_can('unfiltered_html') )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
			$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes($new_instance[ 'text' ]) ) ); // wp_filter_post_kses() expects slashed
		$instance[ 'number' ] = absint( $new_instance[ 'number' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post, $foodhunt_duplicate_posts;

		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
		$number = empty( $instance[ 'number' ] ) ? 8 : $instance[ 'number' ];

		$page_array = array();
		$pages = get_pages();

		// get the pages associated with Gallery Template.
		foreach ( $pages as $page ) {
			$page_id = $page->ID;
			$template_name = get_post_meta( $page_id, '_wp_page_template', true );
			if( $template_name == 'page-templates/template-portfolio.php' && !in_array( $page_id , $foodhunt_duplicate_posts ) ) {
				array_push( $page_array, $page_id );
			}
		}

		$get_featured_posts = new WP_Query( array(
			'posts_per_page'        => $number,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => array( 'menu_order' => 'ASC', 'date' => 'DESC' )
		) );

		echo $before_widget; ?>

		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php
					if( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; }
					if( !empty( $text ) ) { ?> <h4 class="sub-title"> <?php echo esc_textarea( $text ); ?> </h4> <?php } ?>
				</div>

				<?php if( !empty( $page_array ) ) : ?>

					<ul class="gallery-wrapper">
						<?php while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
							$foodhunt_duplicate_posts[] = $post->ID; ?>

							<li class="gallery-list">

								<?php if( has_post_thumbnail() ) {
									the_post_thumbnail('foodhunt-featured-image');

								}
								else {
									$image_popup_url = esc_url( get_template_directory_uri() ) . '/images/portfolio-placehoder.jpg';
									echo '<img src="' . esc_url( $image_popup_url ) . '">';
								} ?>

								<a href="<?php the_permalink(); ?>" class="gallery-zoom"> <span> <?php echo '<i class="fa fa-link"> </i>'; ?> </span> </a>
							</li>
						<?php endwhile; ?>
					</ul>

					<?php
					// Reset Post Data
					wp_reset_postdata();
				endif; ?>
			</div>
		</div><!-- .section-wrapper -->

		<?php echo $after_widget;
	}
}

/**************************************************************************************/

/**
 * Contact us section.
 */
class foodhunt_contact_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'contact-section', 'description' => esc_html__( 'Show your Contact page.', 'foodhunt' ) );
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = esc_html__( 'TG: Contact Us', 'foodhunt' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$defaults[ 'title' ] = '';
		$defaults[ 'text' ] = '';
		$defaults[ 'page_id' ] = '';
		$defaults[ 'shortcode' ] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance['text'] );
		$page_id = absint( $instance[ 'page_id' ] );
		$shortcode = esc_attr( $instance[ 'shortcode' ] );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php esc_html_e( 'Description:','foodhunt' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>


		<p><?php esc_html_e( 'Install the Contact Form 7 Plugin and paste the shortcode here:', 'foodhunt' ) ?></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'shortcode' ); ?>"><?php esc_html_e( 'Shortcode:', 'foodhunt' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo $shortcode; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Select a Contact page:', 'foodhunt' ); ?>:</label>
			<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'page_id' ), 'selected' => $instance[ 'page_id' ] ) ); ?>
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );

		if ( current_user_can('unfiltered_html') )
			$instance[ 'text' ] =  $new_instance[ 'text' ];
		else
		$instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'page_id' ] = absint( $new_instance[ 'page_id' ] );
		$instance[ 'shortcode' ] = sanitize_text_field( $new_instance[ 'shortcode' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance[ 'text' ] ) ? '' : $instance['text'], $instance );
		$page_id = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';
		$shortcode = isset( $instance[ 'shortcode' ] ) ? $instance[ 'shortcode' ] : '';

		echo $before_widget; ?>
		<div class="section-wrapper clearfix">
			<div class="tg-container">

				<div class="section-title-wrapper">
					<?php if( !empty( $title ) ) echo $before_title . esc_html( $title ) . $after_title;

					if( !empty( $text ) ) { ?>
					<h4 class="sub-title"><?php echo esc_textarea( $text ); ?></h4>
					<?php } ?>
				</div>

				<div class="contact-wrapper">
					<div class="tg-column-wrapper clearfix">
						<?php if ( !empty ( $shortcode ) ) { ?>
							<div class="tg-column-2 contact-form">

								<?php echo do_shortcode( $shortcode ); ?>
							</div>
						<?php } ?>

						<?php if( $page_id ) : ?>
							<div class="tg-column-2 contact-details-wrapper">

								<?php $the_query = new WP_Query( 'page_id='.$page_id );
								while( $the_query->have_posts() ):$the_query->the_post(); ?>
									<h3 class="contact-title"> <?php the_title(); ?> </h3>

									<div class="contact-content-wrapper"> <?php the_content(); ?> </div>
								<?php endwhile; ?>
							</div>
						<?php endif;
						// Reset Post Data
						wp_reset_postdata(); ?>
					</div>
				</div><!-- .contact-wrapper -->
			</div><!-- .tg-container -->
		</div>
		<?php echo $after_widget;
	}
}
