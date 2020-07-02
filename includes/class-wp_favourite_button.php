<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/emilostervig/wp_favourite_button
 * @since      1.0.0
 *
 * @package    Wp_favourite_button
 * @subpackage Wp_favourite_button/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_favourite_button
 * @subpackage Wp_favourite_button/includes
 * @author     Emil Østervig <e>
 */
class Wp_favourite_button {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_FAVOURITE_BUTTON_VERSION' ) ) {
			$this->version = WP_FAVOURITE_BUTTON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp_favourite_button';

		$this->load_dependencies();
		$this->set_locale();
		$this->add_rest_routes();

		add_action('init', array($this, 'setup_global_data'), 10);


	}

	public function setup_global_data(){
		$userFavourites = array();
		global $userFavourites;
		$userFavourites = get_user_favourite_list(get_current_user_id());
	}
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_favourite_button_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_favourite_button_i18n. Defines internationalization functionality.
	 * - Wp_favourite_button_Admin. Defines all hooks for the admin area.
	 * - Wp_favourite_button_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The helper functions to interact with DB and stuff.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/helper-functions.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp_favourite_button-admin.php';
		new Wp_favourite_button_Admin($this->plugin_name, $this->version);
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp_favourite_button-public.php';
		new Wp_favourite_button_Public($this->plugin_name, $this->version);
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_favourite_button_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {



	}

	private function add_rest_routes(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rest_routes.php';

	}



	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
