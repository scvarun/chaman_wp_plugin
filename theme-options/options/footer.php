<?php

namespace ChamanAddons\ThemeOptions\Options;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki;

class Footer extends Options {
  /**
   * Settings Name these options are identified by WP.
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $settings_name = 'chaman_options__footer';

  /**
   * Title displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $title = 'Footer';

  /**
   * Description displayed in Customizer
   *
   * @since 1.0.0 
   *
   * @access protected
   * @static
   */
  protected static $description = 'Global settings for footer';

   /**
   * Return Fields
   *
   * @since 1.0.0
   *
   * @access public
   * @static
   */
  public static function fields() {
    $footers = [];

    $args = [
      'post_type' => 'footer',
      'posts_per_page' => -1,
    ];

    $query = new \WP_Query($args);

    if($query->have_posts()) {
      while($query->have_posts()) {
        $query->the_post();
        $id = '_' . get_the_id();
        $footers[$id] = get_the_title();
      }
    }

    $footers = array_merge(['default' => 'Default'], $footers);

    // Default Footer
    Kirki::add_field( 'chaman_options', [
      'type'             => 'select',
      'settings'         => static::$settings_name . '__default_footer',
      'label'            => esc_html__( 'Default Footer', 'chaman_addons' ),
      'section'          => static::$settings_name,
      'description'      => esc_html__( 'Set default footer to view sitewide', 'chaman_addons' ),
      'default'          => 'default',
      'choices'          => $footers,
      'priority'         => 10,
    ] );
  }
}