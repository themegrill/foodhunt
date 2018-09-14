<?php
/**
 * Functions for configuring demo importer.
 *
 * @package Importer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup demo importer config.
 *
 * @deprecated 1.5.0
 *
 * @param  array $demo_config Demo config.
 * @return array
 */
function foodhunt_demo_importer_packages( $packages ) {
	$new_packages = array(
		'foodhunt-free' => array(
			'name'    => esc_html__( 'FoodHunt', 'foodhunt' ),
			'preview' => 'https://demo.themegrill.com/foodhunt/',
		),
		'foodhunt-pro'  => array(
			'name'     => esc_html__( 'FoodHunt Pro', 'foodhunt' ),
			'preview'  => 'https://demo.themegrill.com/foodhunt-pro/',
			'pro_link' => 'https://themegrill.com/themes/foodhunt/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'foodhunt_demo_importer_packages' );

/**
 * Update taxonomies ids for restaurantpress
 *
 * @param  string $demo_id
 * @param  array  $demo_data
 */
function foodhunt_restaurantpress_data_update( $demo_id, $demo_data ) {
	if ( ! empty( $demo_data['restaurantpress_data_update'] ) ) {
		foreach ( $demo_data['restaurantpress_data_update'] as $data_type => $data_value ) {
			$data = [];
			switch ( $data_type ) {
				case 'food_group':
					foreach ( $data_value as $group_name => $taxonomy_values ) {
						$group = get_page_by_title( $group_name, OBJECT, $data_type );
						foreach ( $taxonomy_values as $option_key => $taxonomy ) {
							$term = get_term_by( 'name', $taxonomy, 'food_menu_cat' );
							if ( is_object( $term ) && $term->term_id ) {
								$data[] = $term->term_id;
							}
						}
						update_post_meta( $group->ID, 'food_grouping', $data );
						unset( $data );
					}
					break;
			}
		}
	}
}

add_action( 'themegrill_ajax_demo_imported', 'foodhunt_restaurantpress_data_update', 10, 2 );
