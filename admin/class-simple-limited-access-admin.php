<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/leodudedev/Simple-Limited-Access
 * @since      1.1.0
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/admin
 * @author     Leonardo Pinori <pinori@gmail.com>
 */
class Simple_Limited_Access_Admin
{

  /**
   * The ID of this plugin.
   *
   * @since    1.1.0
   * @access   private
   * @var      string $plugin_name The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.1.0
   * @access   private
   * @var      string $version The current version of this plugin.
   */
  private $version;

  /**
   * @since    1.1.0
   * @access   protected
   * @var      Simple_Limited_Access_utils $utils
   */
  protected $utils;

  /**
   * Initialize the class and set its properties.
   *
   * @param string $plugin_name The name of this plugin.
   * @param string $version The version of this plugin.
   * @since    1.1.0
   */
  public function __construct($plugin_name, $version, $instance)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;

    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-limited-access-utils.php';
    $this->utils = new Simple_Limited_Access_utils();
    $this->hook_admin_menu();
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.1.0
   */
  public function enqueue_styles()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Simple_Limited_Access_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Simple_Limited_Access_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */
  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.1.0
   */
  public function enqueue_scripts()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Simple_Limited_Access_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Simple_Limited_Access_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    if (!empty(get_current_screen()->base)) {
      if (get_current_screen()->base == 'toplevel_page_simple-limited-access') {
        wp_register_style('select2css', plugin_dir_url(__FILE__) . 'css/select2.min.css', false, '4.0.13', 'all');
        wp_register_script('select2', plugin_dir_url(__FILE__) . 'js/select2.min.js', array('jquery'), '4.0.13', true);
        wp_enqueue_style('select2css');
        wp_enqueue_script('select2');

        wp_enqueue_editor();
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/simple-limited-access-admin.js', array('jquery', 'wp-tinymce-root', 'wp-tinymce'), $this->version);
      }
    }
  }

  private function hook_admin_menu()
  {
    add_action('admin_menu', function () {
      add_menu_page(
        'Simple Limited Access',
        'Simple Limited Access',
        'manage_options',
        'simple-limited-access',
        function () {
?>
        <div style="padding: 20px;">
          <h1><?php echo __('Simple Limited Access settings', 'simple-limited-access'); ?></h1>
          <?php
          require(WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/partials/config-basic.php');
          ?>
        </div>
<?php
        },
        'data:image/svg+xml;base64,' . base64_encode('<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50px" height="50px"><path d="M 25 3 C 18.364481 3 13 8.3644809 13 15 L 13 20 L 9 20 C 7.3545455 20 6 21.354545 6 23 L 6 47 C 6 48.645455 7.3545455 50 9 50 L 41 50 C 42.645455 50 44 48.645455 44 47 L 44 23 C 44 21.354545 42.645455 20 41 20 L 37 20 L 37 15 C 37 8.3644809 31.635519 3 25 3 z M 25 5 C 30.564481 5 35 9.4355191 35 15 L 35 20 L 15 20 L 15 15 C 15 9.4355191 19.435519 5 25 5 z M 9 22 L 13.832031 22 A 1.0001 1.0001 0 0 0 14.158203 22 L 35.832031 22 A 1.0001 1.0001 0 0 0 36.158203 22 L 41 22 C 41.554545 22 42 22.445455 42 23 L 42 47 C 42 47.554545 41.554545 48 41 48 L 9 48 C 8.4454545 48 8 47.554545 8 47 L 8 23 C 8 22.445455 8.4454545 22 9 22 z M 25 30 C 23.3 30 22 31.3 22 33 C 22 33.9 22.4 34.699219 23 35.199219 L 23 38 C 23 39.1 23.9 40 25 40 C 26.1 40 27 39.1 27 38 L 27 35.199219 C 27.6 34.699219 28 33.9 28 33 C 28 31.3 26.7 30 25 30 z"/></svg>')
      );
    });
  }
}
