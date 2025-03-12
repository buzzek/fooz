<?php



/**
 * Defines the 'VER' constant as the current WordPress theme version.
 *
 * The 'VER' constant is set to the current theme version if it is a string.
 * Otherwise, it is set to false.
 *
 */

define('VER', is_string(wp_get_theme()->get('Version')) ? wp_get_theme()->get('Version') : false);

/**
 * Adds the Composer autoloader.
 * This ensures that any dependencies installed via Composer are available.
 * If the autoload file does not exist, the script will exit early.
 */
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
	$loader = require_once 'vendor/autoload.php';
} else {
	return; // Exit the script if the autoload file is not found.
}

/**
 * Instantiate key configuration classes.
 * These classes handle various parts of the theme functionality.
 */
new \Fooz\Config\EnqueStylesScripts(); // Handles enqueuing styles and scripts.
new \Fooz\Config\Config(); // General configuration setup.
new \Fooz\Config\ShortCodes(); // Shortcodes setup.
new \Fooz\Config\CustomPostTypes(); // Custom post types setup.
