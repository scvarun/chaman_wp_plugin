<?php

namespace ChamanAddons\CustomPosts;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';
require_once CHAMAN_ADDONS_ROOT . '/vendor/cmb2/cmb2/init.php';

use Gizburdt\Cuztom\Cuztom;

/**
 * Custom Posts for Chaman Theme
 *
 * The class that initiates and runs custom post types.
 *
 * @since 1.0.0
 */
class CustomPosts {
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
   * Initialize Custom Post Types
   *
   * Load all the custom post types required by the theme like events, gallery
   * and others.
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
    Cuztom::run();
    $this->fields();
    $this->content_types();
  }

  public function fields() {
    $this->register_field(new Fields\SelectPost());
  }

  /**
   * Register content types
   *
   * Registers all content types required by the theme
   *
   * Fired by 'init' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function content_types() {
    $this->register_post_type(new Types\Footer());

    $this->register_meta(new Metas\HeaderOnPages());
    $this->register_meta(new Metas\FooterOnPages());
  }

  public function register_field($instance) {
    $instance->run();
  }

  public function register_post_type(Types\Type $instance) {
    $instance->run();
  }

  public function register_meta(Metas\Meta $instance) {
    $instance->run();
  }
}