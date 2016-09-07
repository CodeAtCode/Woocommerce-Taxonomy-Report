<?php

/**
 * WooCommerce Taxonomy Report
 *
 * @package   Woocommerce_Taxonomy_Report
 * @author    WooThemes <lavoro@codeat.it>
 * @license   GPL-2.0+
 * @link      http://codeat.it
 * @copyright 2016 GPL
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-woocommerce-taxonomy-report-admin.php`
 *
 * @package Woocommerce_Taxonomy_Report
 * @author  WooThemes <lavoro@codeat.it>
 */
class Woocommerce_Taxonomy_Report {

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected static $plugin_slug = 'woocommerce-taxonomy-report';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
		$taxonomies = get_option( 'woocommerce_taxonomy-report_settings', null );
		if ( isset( $taxonomies [ 'chosen' ] ) && is_array($taxonomies [ 'chosen' ]) ) {
			$taxonomies = $taxonomies [ 'chosen' ];
			foreach ( $taxonomies as $taxonomy ) {
				register_via_taxonomy_core(
					array( __( ucfirst( $taxonomy ), $this->get_plugin_slug() ), __( ucfirst( $taxonomy ), $this->get_plugin_slug() ), $taxonomy ), array(
				    'public' => true,
				    'capabilities' => array(
					'assign_terms' => 'edit_posts',
				    )
					), array( 'product' )
				);
			}
		}
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return self::$plugin_slug;
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

}
