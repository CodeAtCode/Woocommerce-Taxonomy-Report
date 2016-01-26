<?php

/**
 *
 * @package   Woocommerce_Taxonomy_Report
 * @author    WooThemes <lavoro@codeat.it>
 * @license   GPL-2.0+
 * @link      http://codeat.it
 * @copyright 2016 GPL
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Taxonomy Report
 * Plugin URI:        @TODO
 * Description:       Add a customizable taxonomy reports for WooCommerce
 * Version:           1.0.0
 * Author:            WooThemes
 * Author URI:        http://woothemes.com/
 * Developer: Codeat
 * Developer URI: http://codeat.it/
 * Text Domain:       woocommerce-taxonomy-report
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Copyright: © 2009-2016 WooThemes.
 * Domain Path:       /languages
 * WordPress-Plugin-Boilerplate-Powered: v1.1.7
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/* Check if WooCommerce is active */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/*
	 * ------------------------------------------------------------------------------
	 * Public-Facing Functionality
	 * ------------------------------------------------------------------------------
	 */
	require_once( plugin_dir_path( __FILE__ ) . 'includes/load_textdomain.php' );

	/*
	 * Load library for simple and fast creation of Taxonomy 
	 */

	require_once( plugin_dir_path( __FILE__ ) . 'includes/Taxonomy_Core/Taxonomy_Core.php' );

	require_once( plugin_dir_path( __FILE__ ) . 'public/class-woocommerce-taxonomy-report.php' );
	/*
	 * - 9999 is used for load the plugin as last for resolve some
	 *   problems when the plugin use API of other plugins, remove
	 *   if you don' want this
	 */

	add_action( 'plugins_loaded', array( 'Woocommerce_Taxonomy_Report', 'get_instance' ), 9999 );

	/*
	 * -----------------------------------------------------------------------------
	 * Dashboard and Administrative Functionality
	 * -----------------------------------------------------------------------------
	 */

	if ( is_admin() && (!defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
		require_once( plugin_dir_path( __FILE__ ) . 'admin/class-woocommerce-taxonomy-report-admin.php' );
		add_action( 'plugins_loaded', array( 'Woocommerce_Taxonomy_Report_Admin', 'get_instance' ) );
	}
}