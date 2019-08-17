<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

abstract class Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'adsfas';

  /**
   * Section Name null if new section is to be created otherwise section_name.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $section_name = null;

  /**
   * Title displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $title = '';

  /**
   * Description displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $description = '';

  /**
   * Section defined for Customizer
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function section($panel = null) {
    if( static::$section_name == null ) {
      Kirki::add_section( static::$settings_name, array(
        'title'          => esc_html__(static::$title, 'chaman_addons'),
        'description'    => esc_html__(static::$description, 'chaman_addons'),
        'panel'          => $panel,
        'priority'       => 160,
      ) );
    }
  }

  /**
   * Get Value
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function set_default($settings, $value) {
    if(empty(get_theme_mod($settings_name))) {
      set_theme_mod($settings_name, $value);
    }
    return $value;
  }
}