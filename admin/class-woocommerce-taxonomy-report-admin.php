<?php

/**
 * WooCommerce Taxonomy Report
 *
 * @package   Woocommerce_Taxonomy_Report_Admin
 * @author    Codeat <support@codeat.co>
 * @license   GPL-2.0+
 * @link      http://codeat.it
 * @copyright 2016 GPL
 */

class Woocommerce_Taxonomy_Report_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {		
		add_filter( 'woocommerce_integrations', array( $this, 'add_integration' ), 9999 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register the settings
	 *
	 * @since    1.0.0
	 */
	public function add_integration( $integrations ) {
		global $woocommerce;
		if ( is_object( $woocommerce ) && version_compare( $woocommerce->version, '2.1', '>=' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . 'includes/WC_Integration_TReport.php' );
			$integrations[] = 'WC_Integration_TReport';
		}
		return $integrations;
	}

}
