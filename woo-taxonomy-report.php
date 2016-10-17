<?php

/**
 *
 * @package   Woocommerce_Taxonomy_Report
 * @author    WooThemes <support@codeat.co>
 * @license   GPL-2.0+
 * @link      http://codeat.it
 * @copyright 2016 GPL
 *
 * @wordpress-plugin
 * Plugin Name: Woo Taxonomy Report
 * Plugin URI: @TODO
 * Description: Add any custom taxonomy to your WooCommerce reports, fully compatible with brands and vendors.
 * Version: 1.0.0
 * Author: Codeat
 * Author URI: http://codeat.co/
 * Text Domain: woo-taxonomy-report
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 * WordPress-Plugin-Boilerplate-Powered: v1.1.7
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

/* Check if WooCommerce is active */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    /*
     * Load library for simple and fast creation of Taxonomy 
     */

    require_once( plugin_dir_path( __FILE__ ) . 'includes/Taxonomy_Core/Taxonomy_Core.php' );

    require_once( plugin_dir_path( __FILE__ ) . 'includes/Widgets-Helper/wph-widget-class.php' );
    require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/wc_tax.php' );

    require_once( plugin_dir_path( __FILE__ ) . 'public/class-woo-taxonomy-report.php' );
    /*
     * - 9999 is used for load the plugin as last for resolve some
     *   problems when the plugin use API of other plugins, remove
     *   if you don' want this
     */

    add_action( 'plugins_loaded', array( 'Woo_Taxonomy_Report', 'get_instance' ), 9999 );

    /*
     * -----------------------------------------------------------------------------
     * Dashboard and Administrative Functionality
     * -----------------------------------------------------------------------------
     */

    if ( is_admin() && (!defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
        require_once( plugin_dir_path( __FILE__ ) . 'admin/class-woo-taxonomy-report-admin.php' );
        add_action( 'plugins_loaded', array( 'Woo_Taxonomy_Report_Admin', 'get_instance' ) );
    }
}