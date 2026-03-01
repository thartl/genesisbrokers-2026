<?php

// Functionality.
require_once get_stylesheet_directory() . '/inc/blocks.php';

// Plugin Support.
require_once get_stylesheet_directory() . '/inc/acf.php';


add_action( 'wp_enqueue_scripts', 'salient_child_enqueue_styles', 100 );
/**
 * Dequeue child style enqueued by parent, then enqueue again with better cache-busting
 *
 * @return void
 */
function salient_child_enqueue_styles() {

	wp_dequeue_style( 'salient-child-style' );

	// Use both "nectar" version and last modified timestamp for cache busting
	$nectar_theme_version = nectar_get_theme_version();
	$last_modified        = filemtime( get_stylesheet_directory() . '/style.css' );
	$version              = $nectar_theme_version . '.' . $last_modified;

	wp_enqueue_style(
		'salient-child-style-cache-busted',
		get_stylesheet_directory_uri() . '/style.css',
		'',
		$version
	);
}


add_action( 'wp_enqueue_scripts', 'enqueue_pw_scripts' );
function enqueue_pw_scripts() {

	$script_uri      = get_stylesheet_directory_uri() . '/assets/js/pw-jump.js';
	$script_location = get_stylesheet_directory() . '/assets/js/pw-jump.js';
	$last_modified   = date( "Y-m-d_h.i.s", filemtime( $script_location ) );
	wp_enqueue_script( 'pw-jump', $script_uri, array( 'jquery' ), $last_modified, true );

	$script_uri      = get_stylesheet_directory_uri() . '/assets/js/scroll-to-anchor.js';
	$script_location = get_stylesheet_directory() . '/assets/js/scroll-to-anchor.js';
	$last_modified   = date( "Y-m-d_h.i.s", filemtime( $script_location ) );
	wp_enqueue_script( 'scroll-to-anchor', $script_uri, array( 'jquery', 'pw-jump' ), $last_modified, true );
}


add_action( 'enqueue_block_editor_assets', 'pw_editor_layout_style' );
/**
 * Gutenberg layout style
 */
function pw_editor_layout_style() {

	wp_enqueue_style(
		'pw-editor-layout',
		get_theme_file_uri( '/assets/css/editor-layout.css' ),
		[],
		filemtime( get_theme_file_path( '/assets/css/editor-layout.css' ) )
	);
}

add_action( 'enqueue_block_editor_assets', 'pw_gutenberg_scripts' );
/**
 * Manage Gutenberg blocks and block styles styles
 */
function pw_gutenberg_scripts() {

	wp_enqueue_script( 'theme-editor', get_theme_file_uri( '/assets/js/editor.js' ), array( 'wp-blocks', 'wp-hooks', 'wp-dom' ), filemtime( get_theme_file_path( '/assets/js/editor.js' ) ), true );
}


add_action( 'after_setup_theme', 'osimpw_add_image_sizes' );
/**
 * Add image sizes.
 *
 * @return void
 */
function osimpw_add_image_sizes() {

	add_image_size( 'osimpw-phone-small', 402, 402, false );
	add_image_size( 'osimpw-phone-medium', 440, 440, false );
	add_image_size( 'osimpw-phone-large', 520, 520, false );
	add_image_size( 'osimpw-medium-plus', 600, 600, false );
	add_image_size( 'osimpw-medium-larger', 840, 840, false );
	add_image_size( 'osimpw-larger', 1152, 1152, false );
	add_image_size( 'osimpw-superlarge', 1366, 1366, false );
	add_image_size( 'osimpw-hd', 1920, 1920, false );
	add_image_size( 'osimpw-qhd', 2560, 2560, false );
	add_image_size( 'osimpw-quhd', 3200, 3200, false );
	add_image_size( 'osimpw-wquhd', 3840, 3840, false );
	add_image_size( 'osimpw-4k', 4096, 4096, false );
}

