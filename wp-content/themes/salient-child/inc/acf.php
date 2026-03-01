<?php
/**
 * ACF Customizations
 *
 * @package      BEStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

namespace BEStarter\ACF;


use JsonException;

if ( ! is_admin() ) {
	return;
}


// Disable CPT and taxonomy functionality
add_filter( 'acf/settings/enable_post_types', '__return_false' );

// Don't output empty message on blocks
add_filter( 'acf/blocks/no_fields_assigned_message', '__return_empty_string' );


add_action( 'admin_menu', __NAMESPACE__ . '\\remove_acf_admin_menu' );
/**
 * Remove ACF admin menu
 */
function remove_acf_admin_menu() {

	if ( ! ( function_exists( 'wp_get_environment_type' ) && 'local' !== wp_get_environment_type() ) ) {
		return;
	}

	// Removes only Field Groups submenu item
//	$slug = 'edit.php?post_type=acf-field-group';
//	remove_submenu_page( $slug, $slug );
//	remove_submenu_page( $slug, 'post-new.php?post_type=acf-field-group' );

	// Removes the whole ACF menu
	remove_menu_page( 'edit.php?post_type=acf-field-group' );
}


add_action( 'init', __NAMESPACE__ . '\\register_options_page' );
/**
 * Register Options Page
 */
function register_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page(
			[
				'title'      => __( 'Site Options', 'bestarter_textdomain' ),
				'capability' => 'manage_options',
			]
		);
	}
}


add_filter( 'acf/get_taxonomies', __NAMESPACE__ . '\modify_acf_get_post_types', 10, 2 );
/**
 * Add Nav Menus to allowed post types in the Post Object field.
 *
 * @param $post_types
 * @param $args
 *
 * @return mixed
 */
function modify_acf_get_post_types( $post_types, $args ) {

	if ( ! in_array( 'nav_menu', $post_types ) ) {
		$post_types[] = 'nav_menu';
	}

	return $post_types;
}


add_action( 'acf/init', __NAMESPACE__ . '\include_acf_field_groups_php_json' );
/**
 * Set up ACF fields from local config files.
 * Used for ACF field groups (not part of ACF local json, but based on it).
 *
 * Usage:
 * Copy a field group json config file from acf-json/ to php-json-field-groups/, then trash the field group in ACF UI.
 * The field group will then be available to forms, blocks etc., but no longer visible in the UI, or available to sync in the UI.
 *
 * @return void
 */
function include_acf_field_groups_php_json() {

	$acf_field_group_files = get_acf_field_groups_php_json();

	foreach ( $acf_field_group_files as $json ) {
		acf_add_local_field_group( $json );
	}
}


/**
 * Get available field group config files.
 *
 * @return array Associative array of file paths and their decoded JSON.
 */
function get_acf_field_groups_php_json(): array {

	$php_json_path = get_stylesheet_directory() . '/acf-php-json';
	$files         = glob( trailingslashit( $php_json_path ) . '*.json' );
	$field_groups  = [];

	foreach ( $files as $file ) {

		try {
			$json = json_decode( file_get_contents( $file ), true, 512, JSON_THROW_ON_ERROR );

			if ( ! isset( $json['key'] ) ) {
				error_log( 'Missing key in file: ' . $file );
				continue;
			}

			$field_groups[ $file ] = $json;

		} catch ( JsonException $e ) {

			error_log( 'JSON error in file ' . $file . ': ' . $e->getMessage() );
		}
	}

	return $field_groups;
}
