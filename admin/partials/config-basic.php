<?php
if ($_POST) {
  if (isset($_POST['sla_bg'])) {
    update_option('simple_limited_access_bg', sanitize_hex_color($_POST['sla_bg']));
  }

  if (isset($_POST['sla_text'])) {
    $s =  wp_kses_post($_POST['sla_text']);
    update_option('simple_limited_access_text', $s);
  }

  if (is_array($_POST['sla_pages'])) {
    $vec_page = [];
    foreach ($_POST['sla_pages'] as $key => $id) {
      // Sanitizing page ID as INTVAL
      $vec_page[] = intval($id);
    }
    update_option('simple_limited_access_pages', $vec_page);
  } else {
    update_option('simple_limited_access_pages', null);
  }

  if (isset($_POST['sla_post_type'])) {
    $vec_type = [];
    foreach ($_POST['sla_post_type'] as $key => $type) {
      // Sanitizing post_type as TEXT
      $vec_type[] = sanitize_text_field($type);
    }
    update_option('simple_limited_access_post_type', $vec_type);
  } else {
    update_option('simple_limited_access_post_type', null);
  }

  if (isset($_POST['sla_usrlist'])) {
    update_option('simple_limited_access_list', sanitize_textarea_field($_POST['sla_usrlist']));
  }

  if (isset($_POST['sla_cookie_timeout'])) {
    // Sanitizing cookie timeout as INTVAL
    update_option('simple_limited_access_cookie', intval($_POST['sla_cookie_timeout']));
  }
}

/**
 * ***************************************************************************************************************************************************
 * INIT VALUE
 */

$bg = 'darkseagreen';
if (get_option('simple_limited_access_bg')) {
  $bg = get_option('simple_limited_access_bg');
}


$text = '';
if (get_option('simple_limited_access_text')) {
  $text = esc_html(get_option('simple_limited_access_text'));
}

$pages = '';
if (get_option('simple_limited_access_pages')) {
  $pages = get_option('simple_limited_access_pages');
}

$post_type = '';
if (get_option('simple_limited_access_post_type')) {
  $post_type = get_option('simple_limited_access_post_type');
}

$userlist = '';
if (get_option('simple_limited_access_list')) {
  $userlist = esc_html(get_option('simple_limited_access_list'));
}

$time = '';
if (get_option('simple_limited_access_cookie')) {
  $time = get_option('simple_limited_access_cookie');
}
/**
 * ***************************************************************************************************************************************************
 */

?>
<form action="" method="post">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Login page background', 'simple-limited-access'); ?><br>
      es. <strong>#ff00ff</strong>
    </p>
    <div style="display: flex">
      <input type="text" name="sla_bg" value="<?php echo esc_html($bg); ?>" id="sla_bg">
      <span style="width: 27px; height: 27px; display: inline-block; margin-left: 10px; border-radius: 4px; background-color: <?php echo esc_html($bg); ?>; border: 2px solid black;"></span>
    </div>
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Info text on the login page', 'simple-limited-access'); ?>
    </p>
    <textarea rows="3" class="large-text code" name="sla_text" id="sla_text"><?php echo esc_html($text); ?></textarea>
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Restricts access to a specific page or pages', 'simple-limited-access'); ?>
    </p>
    <?php
    $page_val = '';
    if ($pages) {
      if (is_array($pages)) {
        $page_val = implode(',', $pages);
      }
    }
    ?>
    <select class="sla-select2" name="sla_pages[]" multiple="multiple" style="width: 100%" data-initval="<?php echo esc_html($page_val); ?>">
      <?php
      $pages_query = new WP_Query(array(
        'post_type' => array('page'),
        'posts_per_page' => '-1'
      ));
      foreach ($pages_query->posts as $p) {
        echo '<option value="' . $p->ID . '">' . get_the_title($p->ID) . '</option>';
      }
      ?>
    </select>
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Limit access to one or more types of posts', 'simple-limited-access'); ?>
    </p>
    <?php
    $post_type_val = '';
    if ($post_type) {
      if (is_array($post_type)) {
        $post_type_val = implode(',', $post_type);
      }
    }
    ?>
    <select class="sla-select2" name="sla_post_type[]" multiple="multiple" style="width: 100%" data-initval="<?php echo esc_html($post_type_val); ?>">
      <?php
      foreach (get_post_types(array('public' => true)) as $key => $value) {
        if ($key !== 'attachment') {
          echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
        }
      }
      ?>
    </select>
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Insert new line in the textarea to add a user', 'simple-limited-access'); ?>.<br>
      <?php echo __('Username and password must be separated by colons', 'simple-limited-access'); ?><br>es. <strong>username:123456</strong>
    </p>
    <textarea rows="10" class="large-text code" name="sla_usrlist"><?php echo esc_html($userlist); ?></textarea>
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <p style="margin: 0 0 5px 0">
      <?php echo __('Cookie timeout in hours', 'simple-limited-access'); ?><br>
      <?php echo __('Default value 2 hours', 'simple-limited-access'); ?>
    </p>
    <input type="number" name="sla_cookie_timeout" value="<?php echo esc_html($time); ?>">
  </div>
  <hr style="margin: 20px 0;">
  <div>
    <input type="submit" class="button button-primary" value="<?php echo __('Save settings', 'simple-limited-access'); ?>">
  </div>
</form>
<?php
$log_file = $this->utils->getCurrentLogFile();
if (file_exists($log_file)) {
  $log = file_get_contents($log_file);
?>
  <hr style="margin: 50px 0 20px 0;">
  <div>
    <h2 style="margin: 0 0 5px 0"><?php echo __('Log accesses', 'simple-limited-access'); ?></h2>
    <textarea rows="10" class="large-text code" name="sla_log" style="font-size: 12px"><?php echo esc_html($log); ?></textarea>
  </div>
<?php
}
?>