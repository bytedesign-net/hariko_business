<?php

/**
 * Returns the main file for an installed WP Swiper plugin.
 *
 * @return string|false Plugin file relative to the plugins directory, or false.
 */
function hariko_business_get_wp_swiper_plugin_file() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	foreach ( $plugins as $plugin_file => $plugin_data ) {
		if ( 'wp-swiper' === dirname( $plugin_file ) || 'wp-swiper' === $plugin_data['TextDomain'] ) {
			return $plugin_file;
		}
	}

	return false;
}

/**
 * Displays the appropriate WP Swiper action for site administrators.
 */
function hariko_business_wp_swiper_admin_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$plugin_file = hariko_business_get_wp_swiper_plugin_file();
	$message     = __( 'Hariko Business requires the WP Swiper plugin for slider content.', 'hariko_business' );
	$action      = '';

	if ( ! $plugin_file ) {
		if ( current_user_can( 'install_plugins' ) ) {
			$install_url = wp_nonce_url(
				self_admin_url( 'update.php?action=install-plugin&plugin=wp-swiper' ),
				'install-plugin_wp-swiper'
			);
			$action      = sprintf(
				' <a class="button button-primary" href="%1$s">%2$s</a>',
				esc_url( $install_url ),
				esc_html__( 'Install WP Swiper', 'hariko_business' )
			);
		}
	} elseif ( ! is_plugin_active( $plugin_file ) ) {
		$activate_url = wp_nonce_url(
			self_admin_url( 'plugins.php?action=activate&plugin=' . rawurlencode( $plugin_file ) ),
			'activate-plugin_' . $plugin_file
		);
		$message      = __( 'Hariko Business requires WP Swiper to be active for slider content.', 'hariko_business' );
		$action       = sprintf(
			' <a class="button button-primary" href="%1$s">%2$s</a>',
			esc_url( $activate_url ),
			esc_html__( 'Activate WP Swiper', 'hariko_business' )
		);
	} else {
		$updates = get_site_transient( 'update_plugins' );

		if ( ! empty( $updates->response[ $plugin_file ] ) && current_user_can( 'update_plugins' ) ) {
			$update_url = wp_nonce_url(
				self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . rawurlencode( $plugin_file ) ),
				'upgrade-plugin_' . $plugin_file
			);
			$message    = __( 'An update is available for WP Swiper.', 'hariko_business' );
			$action     = sprintf(
				' <a class="button button-primary" href="%1$s">%2$s</a>',
				esc_url( $update_url ),
				esc_html__( 'Update WP Swiper', 'hariko_business' )
			);
		} else {
			return;
		}
	}

	printf(
		'<div class="notice notice-warning"><p>%1$s%2$s</p></div>',
		esc_html( $message ),
		wp_kses_post( $action )
	);
}
add_action( 'admin_notices', 'hariko_business_wp_swiper_admin_notice' );

add_action( 'wp_enqueue_scripts', 'hariko_business_enqueue_styles' );
function hariko_business_enqueue_styles() {
	wp_enqueue_style(
		'hariko-parent-style',
		get_parent_theme_file_uri( 'style.css' )
	);

	wp_enqueue_style(
		'hariko-parent-assets',
		get_parent_theme_file_uri( 'assets/css/style.css' ),
		array( 'hariko-parent-style' )
	);
	
	wp_enqueue_style(
		'hariko_business-style',
		get_stylesheet_directory_uri() . '/assets/css/style.css',
		array( 'hariko-parent-assets' )
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
add_action( 'after_setup_theme', 'hariko_business_support' );
function hariko_business_support() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
}
