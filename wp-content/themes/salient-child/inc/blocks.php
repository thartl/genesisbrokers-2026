<?php
/**
 * Blocks
 *
 * @package      BEStarter
 * @author       Bill Erickson
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

namespace BEStarter\Blocks;


add_action( 'after_setup_theme', function () {
	add_filter( 'block_categories_all', __NAMESPACE__ . '\blocks_add_custom_block_category', PHP_INT_MAX );
}, - 20 );
/**
 * Adds the Parkdale Wire Blocks category, if it was not already added by core functionality plugin.
 *
 * @param array $categories Array of categories for block types.
 *
 * @return array Updated block categories.
 */
function blocks_add_custom_block_category( $categories ) {

	if ( in_array( 'parkdale-wire-blocks', array_column( $categories, 'slug' ) ) ) {
		return $categories;
	}

	return array_merge(
		array(
			array(
				'slug'  => 'parkdale-wire-blocks',
				'title' => 'Parkdale Wire Blocks',
			),
		),
		array_filter(
			$categories,
			function ( $category ) {
				return 'parkdale-wire-blocks' !== $category['slug'];
			}
		)
	);
}


add_action( 'init', __NAMESPACE__ . '\\load_blocks', 5 );
/**
 * Load ACF Blocks
 */
function load_blocks() {
	$blocks = get_blocks();
	foreach( $blocks as $block ) {
		if ( file_exists( get_stylesheet_directory() . '/blocks/' . $block . '/block.json' ) ) {

			register_block_type( get_stylesheet_directory() . '/blocks/' . $block . '/block.json' );

			// Loads styles that are used even when block is not used on page - using block logic directly
			// To load block stylesheet conditionally name it e.g. style.css and set up in block.json
			if ( file_exists( get_stylesheet_directory() . '/blocks/' . $block . '/static-style.css' ) ) {
				wp_enqueue_style( 'block-' . $block, get_stylesheet_directory_uri() . '/blocks/' . $block . '/static-style.css', array(), filemtime( get_stylesheet_directory() . '/blocks/' . $block . '/static-style.css' ) );
			}

			if ( file_exists( get_stylesheet_directory() . '/blocks/' . $block . '/init.php' ) ) {
				include_once get_stylesheet_directory() . '/blocks/' . $block . '/init.php';
			}
		}
	}
}


add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\\load_acf_field_group' );
/**
 * Load ACF field groups for blocks
 */
function load_acf_field_group( $paths ) {
	$blocks = get_blocks();
	foreach( $blocks as $block ) {
		$paths[] = get_stylesheet_directory() . '/blocks/' . $block;
	}
	return $paths;
}


/**
 * Get Blocks
 */
function get_blocks() {
	$blocks = scandir( get_stylesheet_directory() . '/blocks/' );
	$blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store', '_base-block' ) ) );
	return $blocks;
}
