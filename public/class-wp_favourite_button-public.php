<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/emilostervig/wp_favourite_button
 * @since      1.0.0
 *
 * @package    Wp_favourite_button
 * @subpackage Wp_favourite_button/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_favourite_button
 * @subpackage Wp_favourite_button/public
 * @author     Emil Østervig <e>
 */
class Wp_favourite_button_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->enqueue_styles();
		$this->enqueue_scripts();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_favourite_button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_favourite_button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_favourite_button-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_favourite_button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_favourite_button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_favourite_button-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name, 'ajax_data', array(
   			'ajaxurl' => admin_url('admin-ajax.php')
		));
		wp_enqueue_script( $this->plugin_name);
	}

}