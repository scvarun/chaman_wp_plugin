<?php

namespace ChamanAddons\CustomPosts\Types;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class Footer extends Type {

  /**
   * Register Post Type
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function register() {
    $footer = register_cuztom_post_type(
      'Footer',
      [
        'menu_icon' => 'dashicons-archive',
        'has_archive' => false,
        'publicly_queryable' => true,
        'public' => true,
        'show_in_rest' => false,
        'show_in_admin_bar' => false,
        'exclude_from_search' => true,
        'supports' => ['title', 'editor', 'elementor'],
      ]
    );
  }


  /**
   * Register Post Meta
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function meta() {
  }
}