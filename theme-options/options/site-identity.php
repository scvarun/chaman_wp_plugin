<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

class SiteIdentity extends Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'chaman_options__title_tagline';

  /**
   * Section Name null if new section is to be created otherwise section_name.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $section_name = 'title_tagline';

  /**
   * Return Fields
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function fields() {
    // Mobile Logo
    Kirki::add_field( 'chaman_options', [
      'type'        => 'image',
      'settings'    => static::$settings_name . '__mobile_logo',
      'label'       => esc_html__( 'Mobile Logo', 'chaman_addons' ),
      'description' => esc_html__( 'Logo for Mobile Header Skin', 'chaman_addons' ),
      'section'     => static::$section_name,
      'default'     => '',
      'choices'     => [
        'save_as' => 'id'
      ]
    ]);

    // Sticky Logo
    Kirki::add_field( 'chaman_options', [
      'type'        => 'image',
      'settings'    => static::$settings_name . '__sticky_logo',
      'label'       => esc_html__( 'Sticky Logo', 'chaman_addons' ),
      'description' => esc_html__( 'Logo for Sticky Header', 'chaman_addons' ),
      'section'     => static::$section_name,
      'default'     => '',
      'choices'     => [
        'save_as' => 'id'
      ]
    ]);
  }
}