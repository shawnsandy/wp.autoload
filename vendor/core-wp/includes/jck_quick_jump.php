<?php

/**
* @package JCK_Quick_Jump Modified
* @version 1.3
*/

/*

Plugin Name: Admin Quick Jump Modified

Plugin URI: http://wordpress.org/extend/plugins/admin-quick-jump/

Description: Admin Quick Jump is a very simple plugin that adds a dropdown list to the admin edit-post area. The list contains posts of the same post_type as the one you are currently editing, and allows you to quickly jump between other draft and published posts. This is much less time-consuming than navigating back to the posts list and choosing the post you need.

Author: James Kemp // modified shansandy

Version: 1.3

Author URI: http://www.jckemp.com/

*/

class jck_aqj
{
  function metaboxes()
  {
    $post_types = get_post_types(array(
      "public" => true
    ));

    foreach ($post_types as $post_type) {
      add_meta_box('jump_to', 'Jump to:', array(
        &$this,
        'jump_to'
      ), $post_type, 'side', 'high');

    } //$post_types as $post_type



    add_meta_box('jump_to', 'Jump to:', array(
      &$this,
      'jump_to'
    ), 'post', 'side', 'high');

  }



  function list_posts()
  {
    global $wpdb;
    global $post;

		$content = '';
    $posttype = $post->post_type;

        $jck_posts_recent = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = 0  AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY ID DESC LIMIT 10");



    if ($jck_posts_recent) {
      $content .= "<optgroup label='Recently'  style='color: #ccc; padding: 5px;'>";

      foreach ($jck_posts_recent as $jck_post) {
        $selected = ($jck_post->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

        $content .= "<option value='" . get_edit_post_link($jck_post->ID) . "'" . $selected . ">" . $jck_post->post_title . " (" . $jck_post->ID . ")" . "</option>";

        $jck_posts_sub = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = '$jck_post->ID' AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY post_title ASC");

        foreach ($jck_posts_sub as $jck_post_sub) {
          $selected = ($jck_post_sub->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

          $content .= "<option value='" . get_edit_post_link($jck_post_sub->ID) . "'" . $selected . ">&#8212; " . $jck_post_sub->post_title . " (" . $jck_post_sub->ID . ")" . "</option>";

          $jck_posts_sub_sub = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = '$jck_post_sub->ID' AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY post_title ASC");

          foreach ($jck_posts_sub_sub as $jck_post_sub_sub) {
            $selected = ($jck_post_sub_sub->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

            $content .= "<option value='" . get_edit_post_link($jck_post_sub_sub->ID) . "'" . $selected . ">&emsp;&#8212; " . $jck_post_sub_sub->post_title . " (" . $jck_post_sub_sub->ID . ")" . "</option>";

          } //$jck_posts_sub_sub as $jck_post_sub_sub

        } //$jck_posts_sub as $jck_post_sub


      } //$jck_posts as $jck_post

      $content .= "</optgroup>";

    } //$jck_posts

    $jck_posts = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = 0  AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY post_title ASC LIMIT 10 ");



    if ($jck_posts) {
      $content .= "<optgroup label='Published'  style='color: #ccc; padding: 5px;'>";

      foreach ($jck_posts as $jck_post) {
        $selected = ($jck_post->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

        $content .= "<option value='" . get_edit_post_link($jck_post->ID) . "'" . $selected . ">" . $jck_post->post_title . " (" . $jck_post->ID . ")" . "</option>";

        $jck_posts_sub = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = '$jck_post->ID' AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY post_title ASC");

        foreach ($jck_posts_sub as $jck_post_sub) {
          $selected = ($jck_post_sub->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

          $content .= "<option value='" . get_edit_post_link($jck_post_sub->ID) . "'" . $selected . ">&#8212; " . $jck_post_sub->post_title . " (" . $jck_post_sub->ID . ")" . "</option>";

          $jck_posts_sub_sub = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE $wpdb->posts.post_parent = '$jck_post_sub->ID' AND $wpdb->posts.post_type = '$posttype' AND $wpdb->posts.post_status = 'publish' ORDER BY post_title ASC");

          foreach ($jck_posts_sub_sub as $jck_post_sub_sub) {
            $selected = ($jck_post_sub_sub->ID == $post->ID) ? "style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #eee;font-weight:bold;' disabled='disabled' selected='selected'" : '';

            $content .= "<option value='" . get_edit_post_link($jck_post_sub_sub->ID) . "'" . $selected . ">&emsp;&#8212; " . $jck_post_sub_sub->post_title . " (" . $jck_post_sub_sub->ID . ")" . "</option>";

          } //$jck_posts_sub_sub as $jck_post_sub_sub

        } //$jck_posts_sub as $jck_post_sub


      } //$jck_posts as $jck_post

      $content .= "</optgroup>";

    } //$jck_posts

    $jck_posts = $wpdb->get_results("

		SELECT ID, post_title

		FROM $wpdb->posts

		WHERE $wpdb->posts.post_type = '$posttype'

		AND $wpdb->posts.post_status = 'draft'

		ORDER BY post_title ASC

		");

    if ($jck_posts) {
      $content .= "<optgroup label='Drafts'  style='color: #ccc; padding: 5px;'>";


      foreach ($jck_posts as $jck_post) {
        if ($jck_post->ID == $post->ID) {
          $content .= "<option value='" . get_edit_post_link($jck_post->ID) . "' style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #ccc;font-weight:bold;' disabled='disabled' selected='selected'>Current: " . $jck_post->post_title . " (" . $jck_post->ID . ")</option>";

        } //$jck_post->ID == $post->ID
        else {
          $content .= "<option value='" . get_edit_post_link($jck_post->ID) . "' style='color: #333;padding:3px 0 3px 6px;border-bottom:1px solid #ccc;'>" . $jck_post->post_title . " (" . $jck_post->ID . ")</option>";

        }

      } //$jck_posts as $jck_post

      $content .= "</optgroup>";

    } //$jck_posts

    return $content;

  }



  function jump_to()
  {
    $content = "<select style='display:none'>";
    $content .= $this->list_posts();
    $content .= "</select>";

    echo $content;
  }



  function js()
  {
    wp_enqueue_script('jquery-selectbox', plugins_url('admin-quick-jump/js/jquery.selectbox-0.1.3.min.js'), array(
      'jquery'
    ));
    wp_enqueue_script('jquery-functions', plugins_url('admin-quick-jump/js/quickjump.js'), array(
      'jquery-selectbox'
    ));
  }

  function styles()
  {
    $myStyleUrl  = plugins_url('css/style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
    $myStyleFile = WP_PLUGIN_DIR . '/admin-quick-jump/css/style.css';
    if (file_exists($myStyleFile)) {
      wp_register_style('myStyleSheets', $myStyleUrl);
      wp_enqueue_style('myStyleSheets');
    } //file_exists($myStyleFile)
  }




  /** =======================================
   * PHP 4 Compatible Constructor
   */
  function jck_aqj()
  {
    $this->__construct();
  }
  /**
   * PHP 5 Constructor
   */
  function __construct()
  {
    add_action('admin_print_styles', array(
      &$this,
      'styles'
    ));
    add_action('admin_print_scripts', array(
      &$this,
      'js'
    ));
    add_action('add_meta_boxes', array(
      &$this,
      'metaboxes'
    ));
  }




} // End jck_aqj Class

$jck_aqj = new jck_aqj; // Start an instance of the plugin class