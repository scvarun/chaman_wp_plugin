<?php

namespace ChamanAddons\CustomPosts\Types;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

abstract class Type {
  protected $register_hook = 'init';
  protected $meta_hook = 'init';

  /**
   * Runs the register post type and register meta boxes function
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function run() {
    add_action( $this->register_hook, [ $this, 'register' ] );
    add_action( $this->meta_hook, [ $this, 'meta' ] );
  }

  /**
   * Registers post type
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  abstract public function register();

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