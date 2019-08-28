<?php

namespace ChamanAddons\CF7_Addons;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

/**
 * Custom Posts for Chaman Theme
 *
 * The class that initiates and runs custom post types.
 *
 * @since 1.0.0
 */
class CF7_Addons {
  /**
   * Instance
   *
   * @since 1.0.0
   *
   * @access private
   * @static
   *
   * @var Chaman_Addons The single instance of the class.
   */
  private static $_instance = null;

  /**
   * Initialize CF7 Addons
   *
   * @since 1.0.0
   *
   * @access public
   */
  public static function instance() {
    if( is_null(self::$_instance) ) {
      self::$_instance = new self();
      return self::$_instance;
    }
  }

  /**
   * Constructor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function __construct() {
  }
}