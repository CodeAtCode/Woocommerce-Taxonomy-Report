<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

class WC_Integration_TReport extends WC_Integration {

	/**
	 * Init and hook in the integration.
	 */
	public function __construct() {
		$this->id = 'taxonomy-report';
		$this->method_title = __( 'Taxonomy Report', 'woo-taxonomy-report' );
		$this->method_description = __( 'Add reports based on taxonomies.', 'woo-taxonomy-report' );
		// Actions.
		add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );
		add_filter( 'woocommerce_admin_reports', array( $this, 'add_reports' ) );
		add_action( 'woocommerce_after_register_taxonomy', array( $this, 'load_taxonomies_by_wc' ) );
	}

	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {
		$taxonomies = get_object_taxonomies( 'product', 'objects' );
		unset( $taxonomies[ 'product_shipping_class' ] );
		unset( $taxonomies[ 'product_type' ] );
		unset( $taxonomies[ 'product_attributes' ] );
		unset( $taxonomies[ 'pa_color' ] );
		$product_tags = array();
		foreach ( $taxonomies as $taxonomy ) {
			$product_tags[ $taxonomy->query_var ] = $taxonomy->label;
		}
		$taxonomies = get_option( 'woocommerce_taxonomy-report_settings', null );
		if ( isset( $taxonomies [ 'chosen' ] ) && is_array( $taxonomies [ 'chosen' ] ) ) {
			$taxonomies = $taxonomies [ 'chosen' ];
			foreach ( $taxonomies as $taxonomy ) {
				$product_tags[ $taxonomy ] = ucfirst( $taxonomy );
			}
		}
		$this->form_fields = array(
			'selected' => array(
				'title' => __( 'Taxonomies', 'woo-taxonomy-report' ),
				'type' => 'multiselect',
				'description' => __( 'Pick multiple taxonomies with ctrl key', 'woo-taxonomy-report' ),
				'options' => $product_tags,
			),
			'chosen' => array(
				'title' => __( 'Create new Taxonomies for WooCommerce', 'woo-taxonomy-report' ),
				'type' => 'multiselect',
				'description' => __( 'Pick multiple taxonomies with ctrl key', 'woo-taxonomy-report' ),
				'options' => array(
					'brand' => __( 'Brands', 'woo-taxonomy-report' ), 'vendor' => __( 'Vendors', 'woo-taxonomy-report' ),
					'artist' => __( 'Artist', 'woo-taxonomy-report' ), 'author' => __( 'Author', 'woo-taxonomy-report' ),
					'state' => __( 'State', 'woo-taxonomy-report' ), 'city' => __( 'City', 'woo-taxonomy-report' )
				),
			),
		);
	}

	/**
	 * Wait the loading of initialization of wWooCommerce taxonomies
	 */
	public function load_taxonomies_by_wc() {
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();
	}

	/**
	 * Output the gateway settings screen.
	 */
	public function admin_options() {
		parent::admin_options();
	}

	/**
	 * Add Taxonomy reports to WC reports
	 * @param arr $reports Existing reports
	 * @return arr Modified reports
	 */
	public static function add_reports( $reports ) {
		if ( current_user_can( 'manage_options' ) ) {
			//get_option of WC_settings class not work with static method required for the reports part
			$taxonomies = get_option( 'woocommerce_taxonomy-report_settings', null );
			if ( isset( $taxonomies [ 'selected' ] ) ) {
				$taxonomies = $taxonomies [ 'selected' ];
				foreach ( $taxonomies as $key => $taxonomy ) {
					$name = get_taxonomy( $taxonomy );
					$name = $name->label;
					$reports[ $taxonomy ] = array(
						'title' => $name,
						'reports' => array(
							"sales_by_" . $taxonomy => array(
								'title' => __( $name, 'woo-taxonomy-report' ) . ' ' . __( 'Total', 'woo-taxonomy-report' ),
								'description' => '',
								'hide_title' => true,
								'callback' => array( __CLASS__, 'get_report' )
							),
							"sales_subtotal_by_" . $taxonomy => array(
								'title' => __( $name, 'woo-taxonomy-report' ) . ' ' . __( 'SubTotal', 'woo-taxonomy-report' ),
								'description' => '',
								'hide_title' => true,
								'callback' => array( __CLASS__, 'get_report_subtotal' )
							)
						)
					);
				}
			}
		}
		return $reports;
	}

	public static function get_report( $name ) {
		require_once( plugin_dir_path( __FILE__ ) . 'WC_Report_Sales_By_TReport.php' );
		$name = str_replace( 'sales_by_', '', $name );
		$report = new WC_Report_Sales_By_TReport( $name );
		$report->output_report();
	}

	public static function get_report_subtotal( $name ) {
		require_once( plugin_dir_path( __FILE__ ) . 'WC_Report_Sales_By_TReport.php' );
		$name = str_replace( 'sales_subtotal_by_', '', $name );
		$report = new WC_Report_Sales_By_TReport( $name, '_line_subtotal' );
		$report->output_report();
	}

}
