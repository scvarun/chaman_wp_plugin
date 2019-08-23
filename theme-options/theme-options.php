<?php

namespace ChamanAddons\ThemeOptions;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Kirki as Kirki;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class ThemeOptions {
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
    add_action('plugins_loaded', [ $this, 'add_kirki' ]);
  }

  /**
   * Check if Kirki is installed
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function add_kirki() {
    require CHAMAN_ADDONS_ROOT . '/theme-options/kirki-installation.php';

    if( !class_exists('Kirki') ) {
      add_action(
        'admin_notices',
        [ $this, 'admin_notice_kirki_unavailable' ]
      );
    }

    add_action( 'customize_register', [ $this, 'add_theme_options' ] );
    add_action( 'init', [ $this, 'init_controls' ] );
  }

  /**
   * Issue Elementor compatibility message to WP Admin
   *
   * Displays message into WP Admin that Elementor version is not compatible
   * with this addons.
   *
   * Fired by 'admin_notices' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function admin_notice_kirki_unavailable() {
    if( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    $message = sprintf(
      esc_html__( '"%1$s" requires "%2$s" to be installed.'),
      '<strong>' . esc_html__( 'Chaman Addons', 'chaman_addons' ) . '</strong>',
      '<strong>' . esc_html__( 'Kirki', 'chaman_addons' ) . '</strong>'
    );

    printf(
      '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
      $message
    );
  }

  /**
   * Add theme options panels and sections when the hook is called
   *
   * Fired by 'customize_register' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function add_theme_options($wp_customize) {
    \Kirki::add_config( 'chaman_options', array(
      'capability'    => 'edit_theme_options',
      'option_type'   => 'theme_mod',
    ) );

    $this->init_panels();
    $this->init_sections();
  }

  /**
   * Init panels in options
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_panels() {
    \Kirki::add_panel( 'chaman_options', array(
      'priority'    => 10,
      'title'       => esc_html__( 'Theme Options', 'chaman_addons' ),
      'description' => esc_html__( 'Chaman Theme Options', 'chaman_addons' ),
    ) );
  }

  /**
   * Init Sections in options
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_sections() {
    Options\Header::section('chaman_options');
    Options\Footer::section('chaman_options');
    Options\Social::section('chaman_options');
    Options\SiteIdentity::section('chaman_options');
  }

  /**
   * Add theme options controls when the hook is called
   *
   * Fired by 'init' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_controls() {
    Options\Header::fields();
    Options\Footer::fields();
    Options\Social::fields();
    Options\SiteIdentity::fields();
  }
}