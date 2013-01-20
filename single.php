<?php

// Load Google style sheet to header
add_action( 'wp_enqueue_scripts', 'bg_google_style_sheet' );
function bg_google_style_sheet() {
	if ( is_single( '2942' ) ) {
		wp_enqueue_style( 'google-stylesheet', CHILD_URL . '/css/google.css', array(), PARENT_THEME_VERSION );
	}
}

// Load Color Buttons style sheet to header
add_action( 'wp_enqueue_scripts', 'bg_color_buttons_style_sheet' );
function bg_color_buttons_style_sheet() {
	if ( is_single( '4720' ) ) {
		wp_enqueue_style( 'color-buttons', CHILD_URL . '/css/color-buttons.css', array(), PARENT_THEME_VERSION );
	}
}

// Load Content Boxes style sheet to header
add_action( 'wp_enqueue_scripts', 'bg_content_boxes_style_sheet' );
function bg_content_boxes_style_sheet() {
	if ( is_single( '4700' ) ) {
		wp_enqueue_style( 'content-boxes', CHILD_URL . '/css/content-boxes.css', array(), PARENT_THEME_VERSION );
	}
}

// Load Gradient Buttons style sheet to header
add_action( 'wp_enqueue_scripts', 'bg_gradient_buttons_style_sheet' );
function bg_gradient_buttons_style_sheet() {
	if ( is_single( '5619' ) ) {
		wp_enqueue_style( 'color-buttons', CHILD_URL . '/css/gradient-buttons.css', array(), PARENT_THEME_VERSION );
	}
}

// Add newsletter section on single posts
add_action( 'genesis_after_post_content', 'bg_include_newsletter' );
function bg_include_newsletter() {
	if ( is_singular( 'post' ) )
	require( CHILD_DIR.'/newsletter.php' );
}

// Add the edit link to bottom of post
add_action( 'genesis_after_post', 'bg_edit_link' );
	function bg_edit_link() { ?>
	<?php edit_post_link('(Edit)', '<p>', '</p>'); ?>
	<?php
}

genesis();