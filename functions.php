<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

/**
 * Enqueue child and parent theme styles.
 *
 * The parent theme (Hariko 1.0.13+) registers its stylesheet with the
 * handle "hariko-theme" pointing to assets/css/theme.css. The parent
 * stylesheet is loaded first and the child theme stylesheet depends on
 * it so that child styles always override the parent styles.
 */
add_action( 'wp_enqueue_scripts', 'hariko_business_enqueue_styles', 5 );
function hariko_business_enqueue_styles() {
	$parent_handle = 'hariko-theme';
	$parent_theme  = 'hariko';
	$parent_dir    = get_template_directory();

	// Enqueue the parent theme stylesheet first (handle: hariko-theme).
	if ( ! wp_style_is( $parent_handle, 'enqueued' ) ) {
		wp_register_style(
			$parent_handle,
			get_theme_file_uri( $parent_dir . '/assets/css/theme.css' ),
			array(),
			wp_get_theme( $parent_theme )->get( 'Version' )
		);
		wp_enqueue_style( $parent_handle );
	}

	// Child theme stylesheet.
	wp_enqueue_style(
		'hariko_business-style',
		get_stylesheet_directory_uri() . '/assets/css/style.css',
		array( $parent_handle ),
		wp_get_theme()->get( 'Version' )
	);

	// Block styles.
	$block_styles = array(
		'hariko_business-block-search'     => 'assets/blocks/core-search.css',
		'hariko_business-block-navigation' => 'assets/blocks/core-navigation.css',
		'hariko_business-block-details'    => 'assets/blocks/core-details.css',
		'hariko_business-block-table'      => 'assets/blocks/core-table.css',
		'hariko_business-block-heading'    => 'assets/blocks/core-heading.css',
	);

	foreach ( $block_styles as $handle => $src ) {
		wp_enqueue_style(
			$handle,
			get_stylesheet_directory_uri() . '/' . $src,
			array( $parent_handle ),
			wp_get_theme()->get( 'Version' )
		);
	}
}

// フロント側のスタイル
add_action( 'after_setup_theme', 'hariko_business_support' );
function hariko_business_support() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'editor-style.css' );
}
