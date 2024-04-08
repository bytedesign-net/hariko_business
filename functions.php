<?php
add_action('after_setup_theme', 'hariko_business_setup');
function hariko_business_setup(){
	// TGM translation
	load_theme_textdomain( 'tgmpa', get_template_directory() . '/vendor/tgmpa/languages');

	require_once get_stylesheet_directory() . '/vendor/tgmpa/tgmpa-configuration.php';
}

add_action( 'wp_enqueue_scripts', 'hariko_business_enqueue_styles' );
function hariko_business_enqueue_styles() {
	wp_enqueue_style(
		'hariko-parent-style',
		get_parent_theme_file_uri( 'style.css' )
	);

	wp_enqueue_style(
		'hariko-parent-style',
		get_parent_theme_file_uri( 'assets/css/style.css' )
	);
	
	wp_enqueue_style(
		'hariko_business-style',
		get_theme_file_uri( 'assets/css/style.css' )
	);

	wp_enqueue_block_style( 'core/search', 'hariko_business-block-search' );
	wp_enqueue_style( 
		'hariko_business-block-search', 
		get_theme_file_uri( "assets/blocks/core-search.css" )
	);

	wp_enqueue_block_style( 'core/navigation', 'hariko_business-block-navigation' );
	wp_enqueue_style( 
		'hariko_business-block-navigation', 
		get_theme_file_uri( "assets/blocks/core-navigation.css" )
	);

	wp_enqueue_block_style( 'core/details', 'hariko_business-block-details' );
	wp_enqueue_style( 
		'hariko_business-block-details', 
		get_theme_file_uri( "assets/blocks/core-details.css" )
	);

	wp_enqueue_block_style( 'core/table', 'hariko_business-block-table' );
	wp_enqueue_style( 
		'hariko_business-block-table', 
		get_theme_file_uri( "assets/blocks/core-table.css" )
	);

	wp_enqueue_block_style( 'core/heading', 'hariko_business-block-heading' );
	wp_enqueue_style( 
		'hariko_business-block-heading', 
		get_theme_file_uri( "assets/blocks/core-heading.css" )
	);
}

// フロント側のスタイル
add_action( 'after_setup_theme', 'hariko_custom_support' );
function hariko_custom_support() {
	add_theme_support( 'wp-block-styles' );
	add_editor_style('style.css');
	$fonts = array(
		'font-1' => get_template_directory_uri() . '/assets/fonts/NotoSansJP-Regular.ttf',
		'font-2' => get_template_directory_uri() . '/assets/fonts/NotoSansJP-Bold.ttf',
		'font-3' => get_template_directory_uri() . '/assets/fonts/NotoSansJP-Thin.ttf',
		'font-4' => get_template_directory_uri() . '/assets/fonts/NotoSansJP-Black.ttf',
		'font-5' => get_template_directory_uri() . '/assets/fonts/NotoSerifJP-Regular.otf',
		'font-6' => get_template_directory_uri() . '/assets/fonts/NotoSerifJP-Bold.otf',
		'font-7' => get_template_directory_uri() . '/assets/fonts/NotoSerifJP-Light.otf',
		'font-8' => get_template_directory_uri() . '/assets/fonts/NotoSerifJP-Black.otf',
		'font-9' => get_template_directory_uri() . '/assets/fonts/MaterialSymbolsOutlined[FILL,GRAD,opsz,wght].woff2',
	);
    array_walk($fonts, 'wp_enqueue_style');
}