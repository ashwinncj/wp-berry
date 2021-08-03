<?php
/**
 * Plugin Name:       WP Berry
 * Plugin URI:        https://github.com/ashwinncj/wp-berry
 * Description:       Scrum management WP plugin.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ashwin Kumar C
 * Author URI:        https://github.com/ashwinncj/
 * License:           MIT
 * Text Domain:       wpberry
 */

use WPBerry\Settings;
define( 'BERRY_PROJECT_TAXONOMY', 'berry_project' );
define( 'BERRY_CPT', 'berry' );

require_once plugin_dir_path( __FILE__ ) . 'inc/settings.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/tickets.php';

/**
 * plugin activation actions that has to be executed only once during the activation.
 *
 * @return void
 */
function berry_activation() {
	$settings = new Settings();
	$settings->register_role();
	$settings->add_capabilities_to_existing();
}
register_activation_hook( __FILE__, 'berry_activation' );
