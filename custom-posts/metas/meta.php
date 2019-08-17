<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

abstract class Meta {
  protected $hook = 'init';

  /**
   * Runs the register post type and register meta boxes function
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function run() {
    add_action( $this->hook, [ $this, 'meta' ] );
  }

  /**
   * Registers post meta
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  abstract public function meta();
}