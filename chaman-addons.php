<?php
/*
 Plugin Name: Chaman Addons
 Plugin URI: http://chaman.com
 description: Chaman addons
 Version: 1.0.0
 Author: Chaman
 Author URI: http://chaman.com
 Text Domain: chaman_addons
 License: GPL2
 */

namespace ChamanAddons;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

define('CHAMAN_ADDONS_ROOT', WP_PLUGIN_DIR . '/chaman_wp_plugin');
define('CHAMAN_ADDONS_ROOT_URI', rtrim(plugin_dir_url( __FILE__ ), '/'));

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

use ChamanAddons\ElementorAddons\Controls;
use ChamanAddons\ElementorAddons\Widgets;

/**
 * Addons for Chaman Themes
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Chaman_Addons {

  /**
   * Plugin Version
   *
   * @since 1.0.0
   *
   * @var string The plugin version.
   */
  const VERSION = '1.0.0';

  /**
   * Minimum Elementor Version
   *
   * @since 1.0.0
   *
   * @var string The minimum Elementor version required the theme.
   */
  const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

  /**
   * Minimum PHP Version
   *
   * @since 1.0.0
   *
   * @var string The minimum PHP version required the theme.
   */
  const MINIMUM_PHP_VERSION = '7.0';

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
   * Instance Singleton
   *
   * @since 1.0.0
   *
   * @access private
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
    add_action( 'init', [ $this, 'i18n' ] );
    add_action( 'plugins_loaded', [ $this, 'init' ] );
  }

  /**
   * Load Text Domain
   *
   * Load Localization file
   *
   * Fired by 'init' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function i18n() {
    load_plugin_textdomain( 'chaman_addons' );
  }

  /**
   * Initialize the Addons
   *
   * Load the plugin only after the Elementor (and other plugins) are loaded.
   * Checks for basic plugin requirements, if one check fail don't continue,
   * if all check have passed load the files required to load the plugin.
   *
   * Fired by 'plugins_loaded' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init() {
    if( $this->check_php_version() === 0 ) return;
    $this->init_elementor();
    $this->init_shortcodes();
    $this->init_widgets();
  }

  /**
   * Initialize the Elementor Plugin
   *
   * Load the plugin only after the Elementor (and other plugins) are loaded.
   * Checks for basic plugin requirements, if one check fail don't continue,
   * if all check have passed load the files required to load the plugin.
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_elementor() {
    if( $this->check_elementor_installation() === 0 ) return;
    if( $this->check_elementor_version() === 0 ) return;

    // Register Categories
    add_action(
      'elementor/elements/categories_registered',
      [ $this, 'register_elementor_categories']
    );

    // Register Widgets
    add_action(
      'elementor/widgets/widgets_registered',
      [ $this, 'register_elementor_widgets']
    );

    // Register Controls
    add_action(
      'elementor/controls/controls_registered',
      [ $this, 'register_elementor_controls']
    );

    // Enqueue Widget Styles
    add_action(
      'elementor/frontend/after_enqueue_styles',
      [ $this, 'widget_styles' ] 
    );

    // Enqueue Widget Scripts
    add_action(
      'elementor/frontend/after_register_scripts',
      [ $this, 'widget_scripts' ] 
    );

    // Enqueue Editor Scripts
    add_action(
      'elementor/editor/before_enqueue_scripts',
      [ $this, 'editor_scripts' ] 
    );
  }

  /**
   * Check Elementor Installation
   *
   * Checks if Elementor Plugin is installed.
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function check_elementor_installation() {
    if( !did_action('elementor/loaded') ) {
      add_action(
        'admin_notices',
        [ $this, 'admin_notice_missing_elementor_plugin' ]
      );
      return 0;
    }
    return 1;
  }

  /**
   * Issue missing Elementor Plugin message to Admin
   *
   * Displays message into the WP Admin about the missing Elementor Plugin,
   *
   * Fired by 'admin_notices' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function admin_notice_missing_elementor_plugin() {
    if( isset($_GET['activate']) ) unset( $_GET['activate'] );
    $message = sprintf(
      esc_html__(
        '"%1$s" requires "%2$s" to be installed and activated.',
        'chaman_addons'
      ),
      '<strong>' . esc_html__( 'Chaman Addons', 'chaman_addons' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'chaman_addons' ) . '</strong>'
    );
    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
  }

  /**
   * Check Elementor Version
   *
   * Compares Elementor version with MINIMUM_ELEMENTOR_VERSION
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function check_elementor_version() {
    if(
      ! version_compare(
        ELEMENTOR_VERSION,
        self::MINIMUM_ELEMENTOR_VERSION,
        '>='
      )
    ) {
      add_action(
        'admin_notices',
        [ $this, 'admin_notice_minimum_elementor_version' ]
      );

      return 0;
    }
    return 1;
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
  public function admin_notice_minimum_elementor_version() {
    if( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    $message = sprintf(
      esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.'),
      '<strong>' . esc_html__( 'Chaman Addons', 'chaman_addons' ) . '</strong>',
      '<strong>' . esc_html__( 'Elementor', 'chaman_addons' ) . '</strong>',
      self::MINIMUM_ELEMENTOR_VERSION
    );

    printf(
      '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
      $message
    );
  }

  /**
   * Check PHP Version
   *
   * Compares PHP version with MINIMUM_PHP_VERSION.
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function check_php_version() {
    if( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
      add_action(
        'admin_notices',
        [ $this, 'admin_notice_minimum_php_version' ]
      );

      return 0;
    }
    return 1;
  }

  /**
   * Issue PHP compatibility message to WP Admin
   *
   * Displays message into WP Admin that PHP version is not compatible
   * with this addons.
   *
   * Fired by 'admin_notices' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function admin_notice_minimum_php_version() {
    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

    $message = sprintf(
      esc_html__(
        '"%1$s" requires "%2$s" version %3$s or greater.',
        'chaman_addons'
      ),
      '<strong>' . esc_html__( 'Chaman Addons', 'chaman_addons' ) . '</strong>',
      '<strong>' . esc_html__( 'PHP', 'chaman_addons' ) . '</strong>',
       self::MINIMUM_PHP_VERSION
    );

    printf(
      '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
      $message
    );
  }

  /**
   * Register Elementor Categories
   *
   * Add Widget Categories to Elementor Editor
   *
   * Fired by 'elementor/elements/categories_registered' action hook
   *
   * @since 1.0.0
   *
   * @access public
   *
   * @param Elements_Manager
   */
  public function register_elementor_categories($elements_manager) {
    $elements_manager->add_category(
      'chaman-addons',
      [
        'title' => 'Chaman Addons',
        'icon' => 'fa fa-plug'
      ]
    );
  }

  /**
   * Register Elementor Widgets
   *
   * Include Elementor widget files and register them
   *
   * Fired by 'elementor/widgets/widgets_registered' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function register_elementor_widgets() {
    $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

    // Register Widget
    // $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Sample_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Button_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Latest_Post_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Testimonial_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Team_Members_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Facilitator_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Progress_Bar_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Partners_Widget() );
    $widgets_manager->register_widget_type( new Widgets\Chaman_Elementor_Job_Listing_Widget() );
  }

  /**
   * Register Elementor Controls
   *
   * Include Elementor control files and register them
   *
   * Fired by 'elementor/controls/controls_registered' action hook
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function register_elementor_controls() {

    $controls_manager = \Elementor\Plugin::instance()->controls_manager;

    // Register Controls
    // $controls_manager->register_control('chaman_sample', new Sample_Control());
    // $controls_manager->add_group_control('chaman_sample_group', new Controls\Groups\SampleGroup_Control());

    $controls_manager->add_group_control(
      Controls\Groups\ColorPicker_Control::get_type(),
      new Controls\Groups\ColorPicker_Control()
    );

    $controls_manager->add_group_control(
      Controls\Groups\CustomQuery_Control::get_type(),
      new Controls\Groups\CustomQuery_Control()
    );
  }

  /**
   * Initialize Custom Shortcodes
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function init_shortcodes() {
    require_once(CHAMAN_ADDONS_ROOT . '/shortcodes/shortcodes.php');
  }

  /**
   * Initialize Custom Widgets
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function init_widgets() {
    require_once(CHAMAN_ADDONS_ROOT . '/widgets/widgets.php');
  }

  /**
   * Widget Styles to enqueued
   *
   * Fired by 'elementor/frontend/after_enqueue_styles' action hook
   *
   * @since 1.0.0
   *
   * @access protected
   */
  public function widget_styles() {
    // wp_register_style( '', CHAMAN_ADDONS_ROOT . '/assets/css/widgets/sample-widget.css' );
  }

  /**
   * Widget Scripts to enqueued
   *
   * Fired by 'elementor/frontend/after_register_scripts' action hook
   *
   * @since 1.0.0
   *
   * @access protected
   */
  public function widget_scripts() {
    // wp_register_script( '', CHAMAN_ADDONS_ROOT . '/assets/css/widgets/sample-widget.css' );
  }

  /**
   * Editor Scripts to enqueued
   *
   * Fired by 'elementor/editor/after_enqueue_scripts' action hook
   *
   * @since 1.0.0
   *
   * @access protected
   */
  public function editor_scripts() {
    // wp_register_script( '', CHAMAN_ADDONS_ROOT . '/assets/css/widgets/sample-widget.css' );
  }
}

CustomPosts\CustomPosts::instance();
ThemeOptions\ThemeOptions::instance();
Chaman_Addons::instance();

?>
