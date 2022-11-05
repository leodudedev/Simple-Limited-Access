<!doctype html>
<html lang="en-IT">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo esc_html(get_bloginfo()); ?></title>
  <meta name='robots' content='noindex, nofollow' />
  <?php
  wp_head();

  $bg_login = 'darkseagreen';
  if (get_option('simple_limited_access_bg')) {
    $bg_login = get_option('simple_limited_access_bg');
  }
  ?>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 16px;
      color: white;
      background-color: <?php echo esc_html($bg_login); ?>;
      padding: 0;
      margin: 0;
    }

    .sla-tgt {
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
    }

    .sla-tgt>div {
      width: 100%;
      max-width: 300px;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    .sla-tgt-form {
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.2);
    }

    .sla-tgt-form input,
    .sla-tgt-form label>span,
    .sla-tgt-form label {
      display: inline-block;
      width: 100%;
    }

    .sla-tgt-form label>span {
      margin-bottom: 5px;
    }

    .sla-tgt-form label {
      margin-bottom: 20px;
    }

    .sla-tgt-form input {
      display: block;
      border: none;
      padding: 10px;
      font-size: 20px;
      outline: none;
      width: calc(100% - 20px);
      color: black;
      background-color: white;
    }

    .sla-tgt-form input[type="submit"] {
      width: 100%;
      background-color: black;
      color: white;
      border: solid 2px black;
      text-align: center;
      cursor: pointer;
    }

    .sla-tgt-form input[type="submit"]:hover {
      background-color: white;
      color: black;
    }

    .sla-tgt-form input[type="submit"]:disabled {
      background-color: black !important;
      color: white !important;
      opacity: 0.5 !important;
    }

    .sla-tgt-form p {
      text-align: center;
      margin: 0;
    }

    .sla-tgt .sla-infotext {
      text-align: center;
      margin-bottom: 10px;
      font-size: 18px;
    }

    .sla-tgt-form .sla-tgt-form-error {
      margin: 20px 0 10px;
      color: tomato;
      text-shadow: 0px 0px 5px rgb(255 255 255 / 60%);
    }
  </style>
</head>

<body>
  <div class="sla-tgt">
    <div>
      <?php
      if (get_option('simple_limited_access_text')) {
        echo '<div class="sla-infotext">' . wp_kses_post(get_option('simple_limited_access_text')) . '</div>';
      }
      ?>
      <div class="sla-tgt-form">
        <form action="<?php get_permalink(); ?>" method="post">
          <input type="hidden" name="sla_token" id="sla_token">
          <label for="sla_usr">
            <span><?php echo __('Username', 'simple-limited-access'); ?></span>
            <input type="text" name="sla_user" id="sla_user">
          </label>
          <label for="sla_pwd">
            <span><?php echo __('Password', 'simple-limited-access'); ?></span>
            <input type="password" name="sla_pwd" id="sla_pwd">
          </label>
          <input type="submit" id="sla_submit" value="<?php echo __('Send', 'simple-limited-access'); ?>">
          <?php
          if (isset($renderFormError)) {
            if ($renderFormError) {
          ?>
              <p class="sla-tgt-form-error"><?php echo __('Wrong username or password', 'simple-limited-access'); ?></p>
          <?php
            }
          }
          ?>
        </form>
      </div>
    </div>
  </div>
</body>

</html>