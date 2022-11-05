<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/leodudedev/Simple-Limited-Access
 * @since      1.0.1
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/includes
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
 * @since      1.0.1
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/includes
 * @author     Leonardo Pinori <pinori@gmail.com>
 */
class Simple_Limited_Access
{

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.1
   * @access   protected
   * @var      Simple_Limited_Access_Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.1
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.1
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
   * @since    1.0.1
   */
  public function __construct()
  {
    if (defined('SIMPLE_LIMITED_ACCESS_VERSION')) {
      $this->version = SIMPLE_LIMITED_ACCESS_VERSION;
    } else {
      $this->version = '1.0.1';
    }
    $this->plugin_name = 'simple-limited-access';

    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Simple_Limited_Access_Loader. Orchestrates the hooks of the plugin.
   * - Simple_Limited_Access_i18n. Defines internationalization functionality.
   * - Simple_Limited_Access_Admin. Defines all hooks for the admin area.
   * - Simple_Limited_Access_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.1
   * @access   private
   */
  private function load_dependencies()
  {

    /**
     * The class responsible for orchestrating the actions and filters of the
     * core plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-limited-access-loader.php';

    /**
     * The class responsible for defining internationalization functionality
     * of the plugin.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-limited-access-i18n.php';

    /**
     * The class responsible for defining all actions that occur in the admin area.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-simple-limited-access-admin.php';

    /**
     * The class responsible for defining all actions that occur in the public-facing
     * side of the site.
     */
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-simple-limited-access-public.php';

    $this->loader = new Simple_Limited_Access_Loader();
  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the Simple_Limited_Access_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.1
   * @access   private
   */
  private function set_locale()
  {

    $plugin_i18n = new Simple_Limited_Access_i18n();

    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.1
   * @access   private
   */
  private function define_admin_hooks()
  {

    $plugin_admin = new Simple_Limited_Access_Admin($this->get_plugin_name(), $this->get_version(), $this);

    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.1
   * @access   private
   */
  private function define_public_hooks()
  {

    $plugin_public = new Simple_Limited_Access_Public($this->get_plugin_name(), $this->get_version());

    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.1
   */
  public function run()
  {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @since     1.0.1
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name()
  {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.1
   * @return    Simple_Limited_Access_Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader()
  {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.1
   * @return    string    The version number of the plugin.
   */
  public function get_version()
  {
    return $this->version;
  }
}
