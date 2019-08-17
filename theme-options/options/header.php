<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

class Header extends Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'chaman_options__header';

  /**
   * Title displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $title = 'Header';

  /**
   * Description displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $description = 'Global settings for header';

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