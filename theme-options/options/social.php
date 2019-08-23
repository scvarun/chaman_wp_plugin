<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

class Social extends Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'chaman_options__social';

  /**
   * Title displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $title = 'Social Links';

  /**
   * Description displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $description = 'Links to social networking sites';

   /**
   * Return Fields
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function fields() {
    // Facebook URL
    Kirki::add_field( 'chaman_options', [
      'type'        => 'text',
      'settings'    => static::$settings_name . '__facebook_url',
      'label'       => esc_html__( 'Facebook Url', 'chaman_addons' ),
      'description' => esc_html__( 'Add url to the facebook profile here', 'chaman_addons' ),
      'section'     => static::$settings_name,
      'default'     => '',
    ]);

    // Instagram URL
    Kirki::add_field( 'chaman_options', [
      'type'        => 'text',
      'settings'    => static::$settings_name . '__instagram_url',
      'label'       => esc_html__( 'Instagram Url', 'chaman_addons' ),
      'description' => esc_html__( 'Add url to the instagram profile here', 'chaman_addons' ),
      'section'     => static::$settings_name,
      'default'     => '',
    ]);

    // LinkedIn URL
    Kirki::add_field( 'chaman_options', [
      'type'        => 'text',
      'settings'    => static::$settings_name . '__linkedin_url',
      'label'       => esc_html__( 'LinkedIn Url', 'chaman_addons' ),
      'description' => esc_html__( 'Add url to the LinkedIn profile here', 'chaman_addons' ),
      'section'     => static::$settings_name,
      'default'     => '',
    ]);
  }
}