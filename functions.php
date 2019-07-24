<?php
add_action( 'wp_enqueue_scripts', 'jarvis_enqueue' );

add_action( 'after_setup_theme', 'jarvis_beaver_header_footer_support' );
function jarvis_beaver_header_footer_support() {
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );
}
// Allow Beaver Builder to take over the header/footer
add_action( 'wp', 'jarvis_beaver_header_footer_render' );
function jarvis_beaver_header_footer_render() {
	if ( class_exists( 'FLThemeBuilderLayoutData' ) ) {
		// Get the header ID.
		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		// If we have a header, remove the theme header and hook in Theme Builder's.
		if ( ! empty( $header_ids ) ) {
			remove_action( 'jarvis_header', 'jarvis_include_header' );
			add_action( 'jarvis_header', 'FLThemeBuilderLayoutRenderer::render_header' );
		}
		// Get the footer ID.
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();
		// If we have a footer, remove the theme footer and hook in Theme Builder's.
		if ( ! empty( $footer_ids ) ) {
			remove_action( 'jarvis_footer', 'jarvis_include_footer' );
			add_action( 'jarvis_footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
		}
	}
}
// Allow Beaver Builder Template Part support
add_filter( 'fl_theme_builder_part_hooks', 'jarvis_beaver_register_parts' );
function jarvis_beaver_register_parts() {
	return array(
		array(
			'label' => 'Header',
			'hooks' => array(
				'jarvis_before_header' => 'Before Header',
				'jarvis_after_header'  => 'After Header',
			),
		),
		array(
			'label' => 'Content',
			'hooks' => array(
				'jarvis_before_content' => 'Before Content',
				'jarvis_after_content'  => 'After Content',
			),
		),
		array(
			'label' => 'Footer',
			'hooks' => array(
				'jarvis_before_footer' => 'Before Footer',
				'jarvis_after_footer'  => 'After Footer',
			),
		),
	);
}