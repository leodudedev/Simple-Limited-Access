<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/leodudedev/Simple-Limited-Access
 * @since      1.1.0
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.0
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/includes
 * @author     Leonardo Pinori <pinori@gmail.com>
 */
class Simple_Limited_Access_i18n
{


  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.1.0
   */
  public function load_plugin_textdomain()
  {

    load_plugin_textdomain(
      'simple-limited-access',
      false,
      dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
    );
  }
}
