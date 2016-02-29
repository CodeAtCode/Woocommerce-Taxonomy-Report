<?php

class TReport_Cloud_Widget extends WPH_Widget {

    function __construct() {

        $plugin = Woocommerce_Taxonomy_Report::get_instance();
        $this->plugin_slug = $plugin->get_plugin_slug();

        // Configure widget array
        $args = array(
            'label' => __( 'WooCommerce Cloud Taxonomy Widget', $this->plugin_slug ),
            'description' => __( 'Show your custom taxonomy as a widget', $this->plugin_slug ),
        );

        $args[ 'fields' ] = array(
            array(
                'name' => __( 'Title', $this->plugin_slug ),
                'desc' => __( 'Enter the widget title.', $this->plugin_slug ),
                'id' => 'title',
                'type' => 'text',
                'class' => 'widefat',
                'validate' => 'alpha_dash',
                'filter' => 'strip_tags|esc_attr'
            ),
            array(
                'name' => __( 'Taxonomy', $this->plugin_slug ),
                'desc' => __( 'Set the taxonomy.', $this->plugin_slug ),
                'id' => 'taxonomy',
                'type' => 'taxonomy',
                'class' => 'widefat',
            ),
            array(
                'name' => __( 'Amount', $this->plugin_slug ),
                'id' => 'number',
                'type' => 'number',
                'std'=> 10,
                'class' => 'widefat',
            )
        );
        $this->create_widget( $args );
    }

    /**
     * Output function
     * 
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        $out = $args[ 'before_widget' ];
        $out .= $args[ 'before_title' ];
        $out .= $instance[ 'title' ];
        $out .= $args[ 'after_title' ];
        echo $out;

        wp_tag_cloud( array( 'taxonomy' => $instance[ 'taxonomy' ], 'number' => $instance[ 'amount' ] ) );

        $out = $args[ 'after_widget' ];
        echo $out;
    }

}

// Register widget
if ( !function_exists( 'treport_cloud_widget' ) ) {

    function treport_cloud_widget() {
        register_widget( 'TReport_Cloud_Widget' );
    }

    add_action( 'widgets_init', 'treport_cloud_widget', 1 );
}
