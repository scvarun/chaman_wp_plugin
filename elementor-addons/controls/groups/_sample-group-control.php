<?php

namespace ChamanAddons\ElementorAddons\Controls\Groups;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Elementor\Controls_Manager;

class SampleGroup_Control extends \Elementor\Group_Control_Base {

  /**
   * Fields.
   *
   * Holds all the control fields.
   *
   * @since 1.0.0
   * @access protected
   * @static
   *
   * @var array control fields.
   */
  protected static $fields;

  /**
   * Return the type of control
   *
   * Returns the name by which it is identified in Elementor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public static function get_type() {
    return 'Chaman_sample_group';
  }

  /**
   * Content Template of control
   *
   * Outputs the fields of control
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_fields() {
    $fields = [];

    $fields['type'] = [
      'type' => Controls_Manager::TEXT,
      'label' => __('Text', 'chaman_addons')
    ];

    return $fields;
  }

  /**
   * Returns default options
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function get_default_options() {
    return [
      'popover' => false,
    ];
  }
}