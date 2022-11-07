<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/leodudedev/Simple-Limited-Access
 * @since      1.1.0
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Limited_Access
 * @subpackage Simple_Limited_Access/public
 * @author     Leonardo Pinori <pinori@gmail.com>
 */
class Simple_Limited_Access_Public
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
   * @param string $plugin_name The name of the plugin.
   * @param string $version The version of this plugin.
   * @since    1.1.0
   */
  public function __construct($plugin_name, $version)
  {
    $this->plugin_name = $plugin_name;
    $this->version = $version;

    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-simple-limited-access-utils.php';
    $this->utils = new Simple_Limited_Access_utils();

    $this->hook_template_redirect();
  }


  /**
   * Register the stylesheets for the public-facing side of the site.
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

    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/simple-limited-access-public.css', array(), $this->version, 'all');
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
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


    // wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/simple-limited-access-public.js', array('jquery'), $this->version, false);
  }

  private function addQueryParam($url, $value)
  {
    $query = parse_url($url, PHP_URL_QUERY);
    if (str_contains($query, $value) === false) {
      if ($query) {
        $url .= '&' . $value;
      } else {
        $url .= '?' . $value;
      }
    }
    return $url;
  }

  private function encrypt_decrypt($action, $string)
  {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'slakey_9dS$';
    $secret_iv = '113598896445667';
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes 
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
    } else if ($action == 'decrypt') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
  }

  private function hook_template_redirect()
  {


    add_action('template_include', function ($template) {
      if (!is_user_logged_in()) {

        $pages = get_option('simple_limited_access_pages') ? get_option('simple_limited_access_pages') : [];
        $post_type = get_option('simple_limited_access_post_type') ? get_option('simple_limited_access_post_type') : [];

        $force = false;
        if (!$pages and !$post_type) {
          // forzo tutto
          // $force = true;
        } else {
          if ($pages) {
            if (in_array(get_the_ID(), $pages)) {
              $force = true;
            }
          }
          if ($post_type) {
            if (in_array(get_post_type(), $post_type)) {
              $force = true;
            }
          }
        }

        if ($force) {

          $cookie_name = "simple_limited_access";
          $renderForm = true;
          $renderFormError = false;
          if (isset($_POST['sla_token']) and isset($_POST['sla_user']) and isset($_POST['sla_pwd'])) {
            $renderFormError = true;
            if ($this->utils->checkUsrPwd($_POST['sla_user'], $_POST['sla_pwd'])) {
              $cookietimeout = 2;
              if (intval(get_option('simple_limited_access_cookie')) > 0) {
                $cookietimeout = intval(get_option('simple_limited_access_cookie'));
              }


              $timeout = time() + ((60 * 60) * $cookietimeout);
              $cookie_val_encrypt = $this->encrypt_decrypt('encrypt', $timeout . '[#sla#]' . $_POST['sla_user'] . '[#sla#]' . $_POST['sla_pwd']);

              setcookie($cookie_name, $cookie_val_encrypt, $timeout, "/");

              $log_file = $this->utils->getCurrentLogFile();
              if ($log_file) {
                $date_utc = new \DateTime("now", new \DateTimeZone("Europe/Rome"));
                $logText = sanitize_text_field('user: ' . $_POST['sla_user'] . ' - ip: ' . $_SERVER['REMOTE_ADDR'] . ' - date: ' . $date_utc->format('Y-m-d H:i:s'));
                file_put_contents($log_file, "\r\n" . $logText, FILE_APPEND);
              }

              $renderFormError = false;
              $renderForm = false;
            }
          } else {
            if (!isset($_COOKIE[$cookie_name])) {
              $renderForm = true;
            } else {
              $strvalue = $this->encrypt_decrypt('decrypt', $_COOKIE[$cookie_name]);
              $vec_value = explode('[#sla#]', $strvalue);
              if (count($vec_value) === 3) {
                if (time() < $vec_value[0] and $this->utils->checkUsrPwd($vec_value[1], $vec_value[2])) {
                  $renderForm = false;
                }
              }
            }
          }
          if ($renderForm) {
            require(WP_PLUGIN_DIR . '/' . dirname(plugin_basename(__FILE__)) . '/partials/form.php');
            die();
          }
        }
      }
      return $template;
    });
  }
}
