<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/emilostervig/wp_favourite_button
 * @since             1.0.0
 * @package           Wp_favourite_button
 *
 * @wordpress-plugin
 * Plugin Name:       WP Favourite button
 * Plugin URI:        https://github.com/emilostervig/wp_favourite_button
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Emil Østervig
 * Author URI:        https://github.com/emilostervig/wp_favourite_button
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_favourite_button
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_FAVOURITE_BUTTON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_wp_favourite_button() {

	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'favourite_list';
	$user_table = $wpdb->prefix . 'users';
	$post_table = $wpdb->prefix . 'posts';
	$sql = "CREATE TABLE $table_name (
	  	fav_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id bigint(20) UNSIGNED NOT NULL,
		post_id bigint(20) UNSIGNED NOT NULL,
	  	time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  	PRIMARY KEY (fav_id),
		UNIQUE KEY comp_key (user_id, post_id),
		FOREIGN KEY (user_id) REFERENCES $user_table(ID),
		FOREIGN KEY (post_id) REFERENCES $post_table(ID)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp_favourite_button-deactivator.php
 */
function deactivate_wp_favourite_button() {

}

register_activation_hook( __FILE__, 'activate_wp_favourite_button' );
register_deactivation_hook( __FILE__, 'deactivate_wp_favourite_button' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp_favourite_button.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_favourite_button() {

	$plugin = new Wp_favourite_button();
	//$plugin->run();

}
run_wp_favourite_button();
