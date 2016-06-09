<?php
/**
 * Foodhunt Admin Class.
 *
 * @author  ThemeGrill
 * @package foodhunt
 * @since   1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FoodHunt_Admin' ) ) :

/**
 * FoodHunt_Admin Class.
 */
class FoodHunt_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'foodhunt' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'foodhunt' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'foodhunt-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		global $foodhunt_version;

		wp_enqueue_style( 'foodhunt-welcome', get_template_directory_uri() . '/css/admin/welcome.css', array(), $foodhunt_version );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $foodhunt_version, $pagenow;

		wp_enqueue_style( 'foodhunt-message', get_template_directory_uri() . '/css/admin/message.css', array(), $foodhunt_version );

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'foodhunt_admin_notice_welcome', 1 );

		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'foodhunt_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['foodhunt-hide-notice'] ) && isset( $_GET['_foodhunt_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_foodhunt_notice_nonce'], 'foodhunt_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'foodhunt' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'foodhunt' ) );
			}

			$hide_notice = sanitize_text_field( $_GET['foodhunt-hide-notice'] );
			update_option( 'foodhunt_admin_notice_' . $hide_notice, 1 );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated foodhunt-message">
			<a class="foodhunt-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'foodhunt-hide-notice', 'welcome' ) ), 'foodhunt_hide_notices_nonce', '_foodhunt_notice_nonce' ) ); ?>"><?php _e( 'Dismiss', 'foodhunt' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing FoodHunt! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'foodhunt' ), '<a href="' . esc_url( admin_url( 'themes.php?page=foodhunt-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=foodhunt-welcome' ) ); ?>"><?php esc_html_e( 'Get started with FoodHunt', 'foodhunt' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $foodhunt_version;

		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $foodhunt_version, 0, 3 );
		?>
		<div class="foodhunt-theme-info">
			<h1>
				<?php esc_html_e('About', 'foodhunt'); ?>
				<?php echo $theme->display( 'Name' ); ?>
				<?php printf( '%s', $major_version ); ?>
			</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="foodhunt-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.jpg'; ?>" />
				</div>
			</div>
		</div>

		<p class="foodhunt-actions">
			<a href="<?php echo esc_url( 'http://themegrill.com/themes/foodhunt/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'foodhunt' ); ?></a>

			<a href="<?php echo esc_url( 'http://demo.themegrill.com/foodhunt/' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'foodhunt' ); ?></a>

			<a href="<?php echo esc_url( 'http://themegrill.com/themes/foodhunt/' ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'foodhunt' ); ?></a>

			<a href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/foodhunt?filter=5#postform' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'foodhunt' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'foodhunt-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'foodhunt-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'foodhunt-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'foodhunt' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'foodhunt-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs Pro', 'foodhunt' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'foodhunt-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'foodhunt' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://docs.themegrill.com/foodhunt/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/themes/foodhunt/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View PRO version', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3>
							<?php
							echo esc_html_e( 'Translate', 'foodhunt' );
							echo ' ' . $theme->display( 'Name' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'foodhunt' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/foodhunt' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'foodhunt' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard foodhunt">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'foodhunt' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'foodhunt' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'foodhunt' ) : esc_html_e( 'Go to Dashboard', 'foodhunt' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'foodhunt' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'foodhunt_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}

	/**
	* Parse changelog from readme file.
	* @param  string $content
	* @return string
	*/
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}

	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'foodhunt' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'foodhunt' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'foodhunt'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'foodhunt' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'foodhunt'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/restaurantpress/' ); ?>" target="_blank"><?php esc_html_e( 'RestaurantPress', 'foodhunt' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'foodhunt' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>" target="_blank"><?php esc_html_e( 'WP-PageNavi', 'foodhunt' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'foodhunt' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'foodhunt'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/the-events-calendar/' ); ?>" target="_blank"><?php esc_html_e( 'The Events Calendar', 'foodhunt' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'foodhunt'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>" target="_blank"><?php esc_html_e( 'Polylang', 'foodhunt' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'foodhunt'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wpml.org/' ); ?>" target="_blank"><?php esc_html_e( 'WPML', 'foodhunt' ); ?></a>
					<?php esc_html_e('Fully Compatible in Pro Version', 'foodhunt'); ?>
				</li>
			</ol>

		</div>
		<?php
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'foodhunt' ); ?></p>

			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'foodhunt'); ?></h3></th>
						<th><h3><?php esc_html_e('FoodHunt', 'foodhunt'); ?></h3></th>
						<th><h3><?php esc_html_e('FoodHunt Pro', 'foodhunt'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Price', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('Free', 'foodhunt'); ?></td>
						<td><?php esc_html_e('$69', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Slider', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('4 Slides', 'foodhunt'); ?></td>
						<td><?php esc_html_e('Unlimited Slides', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Google Fonts', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><?php esc_html_e('600+', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Color Options', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('Primary Color', 'foodhunt'); ?></td>
						<td><?php esc_html_e('Primary Color option and more', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Font Size options', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('The Events Calendar Compatible', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Translation Ready', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Woocommerce Compatible', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Woocommerce Page Sidebar', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML Compatible', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Polylang Compatible', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Widgets', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('7', 'foodhunt'); ?></td>
						<td><?php esc_html_e('12', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Call to Action Video Widget', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Fun Facts', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Our Clients', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Special Recipes', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Testimonial Widget', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('TG: Special Products', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Editor', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Footer Sidebar', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('4 columns', 'foodhunt'); ?></td>
						<td><?php esc_html_e('1,2,3,4 columns', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Copyright Alignment', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Demo Content', 'foodhunt'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Support', 'foodhunt'); ?></h3></td>
						<td><?php esc_html_e('Forum', 'foodhunt'); ?></td>
						<td><?php esc_html_e('Emails/Priority Support Ticket', 'foodhunt'); ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="btn-wrapper">
							<a href="<?php echo esc_url( apply_filters( 'foodhunt_pro_theme_url', 'http://themegrill.com/themes/foodhunt-pro/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Pro', 'foodhunt' ); ?></a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<?php
	}
}

endif;

return new FoodHunt_Admin();
