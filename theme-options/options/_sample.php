<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

class Sample extends Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'chaman_options__sample';

  /**
   * Title displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $title = 'Sample';

  /**
   * Description displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $description = 'Sample description';

   /**
   * Return Fields
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function fields() {
  }
}