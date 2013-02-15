<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'bg_viewport_meta_tag' );
function bg_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Filter open graph tags to use Genesis doctitle and meta description instead
add_filter( 'jetpack_open_graph_tags', 'bg_jetpack_open_graph_tags_filter' );
function bg_jetpack_open_graph_tags_filter( $tags ) {

	// Do nothing if not on an entry page
	if ( ! is_singular() )
		return $tags;

	// Pull from custom fields
	$title				= genesis_get_custom_field( '_genesis_title' );
	$description	= genesis_get_custom_field( '_genesis_description' );

	// Maybe set new values
	$tags['og:title']				= $title ? $title : $tags['og:title'];
	$tags['og:description']	= $description ? $description : $tags['og:description'];

	return $tags;

}

// Load Oswald Google font
add_action( 'wp_enqueue_scripts', 'bg_load_google_font' );
function bg_load_google_font() {
	wp_enqueue_style( 'google-font', 'http://fonts.googleapis.com/css?family=Oswald:400', array(), PARENT_THEME_VERSION );
}

// Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Add the topnav section
add_action( 'genesis_before', 'bg_topnav' );
function bg_topnav() {
	echo '<div id="topnav"><div class="wrap"><span class="left"><span class="from-the-blog">Like this theme?</span><a href="http://my.studiopress.com/themes/metro/">You can buy it on StudioPress.</a></span><span class="right"><a class="first" href="http://www.briangardner.com/about/">The 411 on Me</a><a href="http://www.briangardner.com/code/">Code Snippets</a><a href="http://www.briangardner.com/themes/">WordPress Themes</a></span></div></div>';
}

// Customize the post info function
add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {

	if ( is_singular( 'code' ) ) {
		$post_info = '';
	} 

	else {
		$post_info = 'Posted on [post_date] [post_edit] [post_comments]';
	}

	return $post_info;
}

// Modify the WordPress read more link
add_filter( 'the_content_more_link', 'custom_read_more_link' );
function custom_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}

// Remove the post meta function
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

// Add Jetpack share buttons above post
remove_filter( 'the_content', 'sharing_display', 19 );
remove_filter( 'the_excerpt', 'sharing_display', 19 );

add_filter( 'the_content', 'share_buttons_above_post', 19 );
add_filter( 'the_excerpt', 'share_buttons_above_post', 19 );

function share_buttons_above_post( $content = '' ) {
	if ( function_exists( 'sharing_display' ) ) {
		return sharing_display() . $content;
	}
	else {
		return $content;
	}
}

// Modify comments header text in comments
add_filter( 'genesis_title_comments', 'custom_genesis_title_comments' );
function custom_genesis_title_comments() {
	$title = '<h3><span class="comments-title">Comments</span></h3>';
	return $title;
}

// Modify the speak your mind text
add_filter( 'genesis_comment_form_args', 'custom_comment_form_args' );
function custom_comment_form_args($args) {
	$args['title_reply'] = '<span class="comments-title">Speak Your Mind</span>';
	return $args;
}

// Create a custom Gravatar
function add_custom_gravatar ($avatar) {
$custom_avatar = get_bloginfo( 'template_directory' ) . '/images/gravatar-bg.png';
$avatar[$custom_avatar] = "Custom Gravatar";
	return $avatar;
	}
add_filter( 'avatar_defaults', 'add_custom_gravatar' );

// Customize search form input box text
add_filter( 'genesis_search_text', 'custom_search_text' );
function custom_search_text($text) {
	return esc_attr( 'Search my website ...' );
}

// Create code custom post type
add_action( 'init', 'code_post_type' );
function code_post_type() {
	register_post_type( 'code',
		array(
			'labels' => array(
				'name' => __( 'Code' ),
				'singular_name' => __( 'Code Snippets' ),
			),
			'has_archive' => true,
			'hierarchical' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/icons/code.png',
			'public' => true,
			'rewrite' => array( 'slug' => 'code' ),
			'supports' => array( 'title', 'editor', 'custom-fields', 'genesis-seo', 'thumbnail' ),
		)
	);
}

// Add span class to widget headline
add_filter( 'widget_title', 'child_widget_title' );
function child_widget_title( $title ){
	if( $title )
		return sprintf('<span class="sidebar-title">%s</span>', $title );
}

// Customize the footer
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
add_action( 'genesis_after', 'bg_footer' );
	function bg_footer() { ?>
	<div id="footer"><div class="wrap">
		<p>&copy; Copyright 2013. Powered by <a href="http://www.starbucks.com">Starbucks lattes</a>, <a href="http://www.sarahmclachlan.com">really good music</a> and the <a href="http://www.studiopress.com/">Genesis Framework</a>. <a href="http://www.briangardner.com/contact/">Get in touch</a>.</p>
		<p class="social-links"><a class="social" href="http://www.facebook.com/bgardner">Facebook</a>/<a class="social" href="http://github.com/bgardner">Github</a>/<a class="social" href="https://plus.google.com/109450535379570250650?rel=author">Google +</a>/<a class="social" href="http://instagram.com/bgardner/">Instagram</a>/<a class="social" href="http://pinterest.com/bgdotcom/">Pinterest</a>/<a class="social" href="http://twitter.com/bgardner">Twitter</a></p>
	</div></div>
	<?php
}