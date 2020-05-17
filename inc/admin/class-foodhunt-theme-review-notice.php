<?php

/**
 * FoodHunt Theme Review Notice Class.
 *
 * @author  ThemeGrill
 * @package FoodHunt
 * @since   1.3.0
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Class to display the theme review notice for this theme after certain period.
 *
 * Class FoodHunt_Theme_Review_Notice
 */
class FoodHunt_Theme_Review_Notice {

    /**
     * Constructor function to include the required functionality for the class.
     *
     * FoodHunt_Theme_Review_Notice constructor.
     */
    public function __construct() {

        add_action('after_setup_theme', array($this, 'foodhunt_theme_rating_notice'));
        add_action('switch_theme', array($this, 'foodhunt_theme_rating_notice_data_remove'));
        add_action('admin_enqueue_scripts', array($this, 'foodhunt_theme_review_notice_enqueue'));
    }

    /**
     * Set the required option value as needed for theme review notice.
     */
    public function foodhunt_theme_rating_notice() {

        // Set the installed time in `foodhunt_theme_installed_time` option table.
        $option = get_option('foodhunt_theme_installed_time');

        if (!$option) {
            update_option('foodhunt_theme_installed_time', time());
        }

        add_action('admin_notices', array($this, 'foodhunt_theme_review_notice'), 0);
        add_action('admin_init', array($this, 'foodhunt_ignore_theme_review_notice'), 0);
        add_action('admin_init', array($this, 'foodhunt_ignore_theme_review_notice_partially'), 0);
    }

    /**
     * Display the theme review notice.
     */
    public function foodhunt_theme_review_notice() {

        $user_id                  = get_current_user_id();
        $current_user             = wp_get_current_user();
        $ignored_notice           = get_user_meta($user_id, 'foodhunt_ignore_theme_review_notice', true);
        $ignored_notice_partially = get_user_meta($user_id, 'nag_foodhunt_ignore_theme_review_notice_partially', true);

        /**
         * Return from notice display if:
         *
         * 1. The theme installed is less than 15 days ago.
         * 2. If the user has ignored the message partially for 15 days.
         * 3. Dismiss always if clicked on 'I Already Did' button.
         */
        if ((get_option('foodhunt_theme_installed_time') > strtotime('-15 day')) || ($ignored_notice_partially > strtotime('-15 day')) || ($ignored_notice)) {
            return;
        }
?>

        <div class="notice updated theme-review-notice" style="position:relative;">
            <p>
                <?php
                printf(
                    /* Translators: %1$s current user display name. */
                    esc_html__(
                        'Howdy, %1$s! It seems that you have been using this theme for more than 15 days. We hope you are happy with everything that the theme has to offer. If you can spare a minute, please help us by leaving a 5-star review on WordPress.org.  By spreading the love, we can continue to develop new amazing features in the future, for free!',
                        'foodhunt'
                    ),
                    '<strong>' . esc_html($current_user->display_name) . '</strong>'
                );
                ?>
            </p>

            <div class="links">
                <a href="https://wordpress.org/support/theme/foodhunt/reviews/?filter=5#new-post" class="btn button-primary" target="_blank">
                    <span class="dashicons dashicons-thumbs-up"></span>
                    <span><?php esc_html_e('Sure', 'foodhunt'); ?></span>
                </a>

                <a href="?nag_foodhunt_ignore_theme_review_notice_partially=0" class="btn button-secondary">
                    <span class="dashicons dashicons-calendar"></span>
                    <span><?php esc_html_e('Maybe later', 'foodhunt'); ?></span>
                </a>

                <a href="?nag_foodhunt_ignore_theme_review_notice=0" class="btn button-secondary">
                    <span class="dashicons dashicons-smiley"></span>
                    <span><?php esc_html_e('I already did', 'foodhunt'); ?></span>
                </a>

                <a href="<?php echo esc_url('https://wordpress.org/support/theme/foodhunt/'); ?>" class="btn
				button-secondary" target="_blank">
                    <span class="dashicons dashicons-edit"></span>
                    <span><?php esc_html_e('Got theme support question?', 'foodhunt'); ?></span>
                </a>
            </div>

            <a class="notice-dismiss" style="text-decoration:none;" href="?nag_foodhunt_ignore_theme_review_notice=0"></a>
        </div>

<?php
    }

    /**
     * Function to remove the theme review notice permanently as requested by the user.
     */
    public function foodhunt_ignore_theme_review_notice() {

        $user_id = get_current_user_id();

        /* If user clicks to ignore the notice, add that to their user meta */
        if (isset($_GET['nag_foodhunt_ignore_theme_review_notice']) && '0' === $_GET['nag_foodhunt_ignore_theme_review_notice']) {
            add_user_meta($user_id, 'foodhunt_ignore_theme_review_notice', 'true', true);
        }
    }

    /**
     * Function to remove the theme review notice partially as requested by the user.
     */
    public function foodhunt_ignore_theme_review_notice_partially() {

        $user_id = get_current_user_id();

        /* If user clicks to ignore the notice, add that to their user meta */
        if (isset($_GET['nag_foodhunt_ignore_theme_review_notice_partially']) && '0' === $_GET['nag_foodhunt_ignore_theme_review_notice_partially']) {
            update_user_meta($user_id, 'nag_foodhunt_ignore_theme_review_notice_partially', time());
        }
    }

    /**
     * Remove the data set after the theme has been switched to other theme.
     */
    public function foodhunt_theme_rating_notice_data_remove() {

        $get_all_users        = get_users();
        $theme_installed_time = get_option('foodhunt_theme_installed_time');

        // Delete options data.
        if ($theme_installed_time) {
            delete_option('foodhunt_theme_installed_time');
        }

        // Delete user meta data for theme review notice.
        foreach ($get_all_users as $user) {
            $ignored_notice           = get_user_meta($user->ID, 'foodhunt_ignore_theme_review_notice', true);
            $ignored_notice_partially = get_user_meta($user->ID, 'nag_foodhunt_ignore_theme_review_notice_partially', true);

            // Delete permanent notice remove data.
            if ($ignored_notice) {
                delete_user_meta($user->ID, 'foodhunt_ignore_theme_review_notice');
            }

            // Delete partial notice remove data.
            if ($ignored_notice_partially) {
                delete_user_meta($user->ID, 'nag_foodhunt_ignore_theme_review_notice_partially');
            }
        }
    }

    /**
     * Enqueue the required CSS file for theme review notice on admin page.
     */
    public function foodhunt_theme_review_notice_enqueue() {

        wp_enqueue_style('foodhunt-theme-review-notice', get_template_directory_uri() . '/inc/admin/css/theme-review-notice.css');
    }
}

new FoodHunt_Theme_Review_Notice();
