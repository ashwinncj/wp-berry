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

require_once plugin_dir_path( __FILE__ ) . 'inc/settings.php';

register_activation_hook( __FILE__, array( new Settings(), 'register_role' ) );
