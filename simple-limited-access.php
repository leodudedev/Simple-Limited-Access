<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/leodudedev/Simple-Limited-Access
 * @since             1.1.0
 * @package           Simple_Limited_Access
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Limited Access
 * Plugin URI:        https://github.com/leodudedev/Simple-Limited-Access
 * Description:       With "Simple Limited Access" you can limit access to specific pages or post_type by forcing the user to enter a username and password that you can define in the configuration screen.
 * Version:           1.1.0
 * Author:            Leonardo Pinori
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-limited-access
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Currently plugin version.
 * Start at version 1.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('SIMPLE_LIMITED_ACCESS_VERSION', '1.1.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-limited-access-activator.php
 */
function activate_simple_limited_access()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-simple-limited-access-activator.php';
  Simple_Limited_Access_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-limited-access-deactivator.php
 */
function deactivate_simple_limited_access()
{
  require_once plugin_dir_path(__FILE__) . 'includes/class-simple-limited-access-deactivator.php';
  Simple_Limited_Access_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_simple_limited_access');
register_deactivation_hook(__FILE__, 'deactivate_simple_limited_access');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-simple-limited-access.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.0
 */
function run_simple_limited_access()
{

  $plugin = new Simple_Limited_Access();
  $plugin->run();
}

run_simple_limited_access();
