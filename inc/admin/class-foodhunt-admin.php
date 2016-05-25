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
		global $pagenow;

		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div class="updated notice is-dismissible">
			<p><?php echo sprintf( esc_html__( 'Welcome! Thank you for choosing FoodHunt! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'foodhunt' ), '<a href="' . esc_url( admin_url( 'themes.php?page=foodhunt-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=foodhunt-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php esc_html_e( 'Get started with FoodHunt', 'foodhunt' ); ?></a></p>
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
					<?php printf( esc_html__( '%s', 'foodhunt' ), $major_version ); ?>
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

			<a href="<?php echo esc_url( apply_filters( 'foodhunt_pro_theme_url', 'http://demo.themegrill.com/foodhunt/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'foodhunt' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'foodhunt_pro_theme_url', 'http://themegrill.com/themes/foodhunt/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'foodhunt' ); ?></a>

			<a href="<?php echo esc_url( apply_filters( 'foodhunt_pro_theme_url', 'http://wordpress.org/support/view/theme-reviews/foodhunt?filter=5' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'foodhunt' ); ?></a>
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
						<h3><?php echo esc_html_e( 'Theme Customizer', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_e( 'Documentation', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/theme-instruction/foodhunt/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_e( 'Got theme support question?', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support Forum', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_e( 'Need more features?', 'foodhunt' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'foodhunt' ) ?></p>
						<p><a href="<?php echo esc_url( 'http://themegrill.com/themes/foodhunt/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View Pro', 'foodhunt' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php echo esc_html_e( 'Got sales related question?', 'foodhunt' ); ?></h3>
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
						<?php is_multisite() ? esc_html_e( 'Return to Updates' ) : esc_html_e( 'Return to Dashboard &rarr; Updates' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home' ) : esc_html_e( 'Go to Dashboard' ); ?></a>
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

			<p class="about-description"><?php esc_html_e( 'View changelog below.', 'foodhunt' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'foodhunt_changelog_file', get_template_directory() . '/changelog.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_lines = explode( PHP_EOL, $changelog );

					echo '<pre class="changelog">';

					foreach( $changelog_lines as $changelog_line ) {
						echo esc_html( $changelog_line );
					}

					echo '</pre>';
				}
			?>

		</div>
		<?php
	}

	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins.', 'foodhunt' ); ?></p>
			<ol>
				<li><?php printf(__('<a href="%s" target="_blank">Contact Form 7</a>', 'foodhunt'), esc_url('https://wordpress.org/plugins/contact-form-7/')); ?></li>
				<li><?php printf(__('<a href="%s" target="_blank">WP-PageNavi</a>', 'foodhunt'), esc_url('https://wordpress.org/plugins/wp-pagenavi/')); ?></li>
				<li><?php printf(__('<a href="%s" target="_blank">WooCommerce</a>', 'foodhunt'), esc_url('https://wordpress.org/plugins/woocommerce/')); ?></li>
				<li>
					<?php printf(__('<a href="%s" target="_blank">Polylang</a>', 'foodhunt'), esc_url('https://wordpress.org/plugins/polylang/')); ?>
					<?php esc_html_e('Fully Compatible in Pro Version', 'foodhunt'); ?>
				</li>
				<li>
					<?php printf(__('<a href="%s" target="_blank">WMPL</a>', 'foodhunt'), esc_url('https://wpml.org/')); ?>
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

				</tbody>
			</table>

		</div>
		<?php
	}
}

endif;

return new FoodHunt_Admin();
