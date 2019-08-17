<?php

namespace ChamanAddons\CustomPosts\Types;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class Sample extends Type {

  /**
   * Register Post Type
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function register() {
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