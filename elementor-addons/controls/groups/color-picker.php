<?php

namespace ChamanAddons\ElementorAddons\Controls\Groups;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Elementor\Controls_Manager;

/*
 * =================================================
 * =================================================
 *
 * Usage:

$this->add_group_control(
  Groups\ColorPicker_Control::get_type(),
  [
    'name' => 'color',
    'label' => __('Color', 'unifato_addons'),

    // Optional
    'type' => [
      'default' => 'theme'
    ],

    'custom_color_field' => [
      'disabled' => false,
      'default_selectors' => true,
      'selectors' => [
      ]
    ],

    'theme_color_field' => [
      'disabled' => false,
      'default_selectors' => true,
      'selectors' => [
      ]
    ],

    'optional' => false,
  ]
);

 *
 * =================================================
 * =================================================
 */
class ColorPicker_Control extends \Elementor\Group_Control_Base {

  /**
   * Fields.
   *
   * Holds all the color-picker control fields.
   *
   * @since 1.0.0
   * @access protected
   * @static
   *
   * @var array colorpicker control fields.
   */
  protected static $fields;

  /**
   * Color Types.
   *
   * Holds all available color types.
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var array
   */
  private static $color_types;

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
    return 'chaman_colorpicker';
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
      'type' => Controls_Manager::CHOOSE,
      'label_block' => false,
      'render_type' => 'ui',
      'toggle' => false
    ];

    $fields['custom_color'] = [
      'label' => __('Custom', 'unifato_addons'),
      'type' => \Elementor\Controls_Manager::COLOR,
      'condition' => [
        'type' => ['custom']
      ],
      'of_type' => 'custom',
      
    ];

    $fields['theme_color'] = [
      'label' => __('Theme', 'unifato_addons'),
      'type' => Controls_Manager::SELECT2,
      'default' => 'primary',
      'condition' => [
        'type' => ['theme']
      ],

      'dynamic' => [
        'active' => true,
      ],
      'prefix_class' => 'text-',

      'render_type' => 'ui',
      'of_type' => 'theme',
      'options' => [
        'default' => 'Default',

        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'tertiary' => 'Tertiary',

        'success' => 'Success',
        'info' => 'Info',
        'warning' => 'Warning',
        'danger' => 'Danger',

        'dark' => 'Dark',
        'light' => 'Light',
        'white' => 'White',
      ]
    ];

    return $fields;
  }

  /**
   * Return the types
   *
   * Returns the types to be used in control.
   *
   * @since 1.0.0
   *
   * @access public
   */
  private static function get_default_color_types() {
    return [
      'custom' => [
        'title' => __('Custom', 'unifato_addons'),
        'icon' => 'fa fa-eyedropper'
      ],
      'theme' => [
        'title' => __('Theme', 'unifato_addons'),
        'icon' => 'fa fa-superpowers'
      ]
    ];
  }

  /**
   * Get child default args
   *
   * Retrieve the default arguments for all the child controls for a specific
   * group control.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function get_child_default_args() {
    return [
      'types' => [ 'custom', 'theme' ],
      'label' =>  __('Color Type', 'unifato_addons'),

      'type' => [
        'default' => 'theme',
      ],

      'custom_color' => [
        'disabled' => false,
        'options' => [],
        'render_type' => 'ui',
        'default_selector' => true,
        'selectors' => [
          '{{SELECTOR}}' => 'color: {{VALUE}}',
        ],
      ],

      'theme_color' => [
        'disabled' => false,
        'default_selector' => false,
        'options' => [],
      ],

      'optional' => false
    ];
  }

  /**
   * Filter fields
   *
   * Filter which controls to display, using `include`, `exclude`, `condition`
   * and `of_type` arguments.
   *
   * @since 1.0.0
   *
   * @access protected
   *
   * @return array Control Fields
   */
  public static function get_color_types() {
    if( null === self::$color_types ) {
      self::$color_types = self::get_default_color_types();
    }
    return self::$color_types;
  }

  /**
   * Prepare fields.
   *
   * Process colorpicker control fields before adding them to `add_control()`.
   *
   * @since 1.0.0
   * @access protected
   *
   * @param array $fields Colorpicker control fields.
   *
   * @return array Processed fields.
   */
  protected function prepare_fields($fields) {
    $args = $this->get_args();

    if( isset($args['type_field']) ) {
      $args['type'] = array_merge($args['type'], $args['type_field']);
    }

    if( isset($args['custom_color_field']) ) {
      $args['custom_color'] = array_merge($args['custom_color'], $args['custom_color_field']);
    }

    if( isset($args['theme_color_field']) ) {
      $args['theme_color'] = array_merge($args['theme_color'], $args['theme_color_field']);
    }

    $color_types = self::get_color_types();

    $choose_types = [];

    foreach( $args['types'] as $type ) {
      if( isset( $color_types[$type] ) ) {
        $choose_types[$type] = $color_types[$type];
      }
    }

    $fields['type']['options'] = $choose_types;

    $fields['type']['label'] = $args['label'];

    $fields['custom_color'] = array_replace_recursive(
      $fields['custom_color'], 
      $args['custom_color']
    );

    $fields['theme_color'] = array_replace_recursive(
      $fields['theme_color'], 
      $args['theme_color']
    );

    $fields['type']['default'] = $args['type']['default'];

    if( $args['theme_color']['default_selector'] == false ) {
      unset($fields['theme_color']['render_type']);
      unset($fields['theme_color']['dynamic']);
      unset($fields['theme_color']['prefix_class']);
    }

    if( $args['custom_color']['default_selector'] == false ) {
      $fields['custom_color']['render_type'] = 'template';
      unset($fields['custom_color']['selectors']);
      if( isset($args['custom_color_field']['selectors']) ) {
        $fields['custom_color']['selectors'] = $args['custom_color_field']['selectors'];
      }
    }

    if( $args['custom_color']['disabled'] == true ) {
      $fields['type']['type'] = Controls_Manager::HIDDEN;
      $fields['type']['default'] = 'theme';
      unset($fields['custom_color']);
    }

    if( $args['theme_color']['disabled'] == true ) {
      $fields['type']['type'] = Controls_Manager::HIDDEN;
      $fields['type']['default'] = 'custom';
      unset($fields['theme_color']);
    }

    if( $args['optional'] == true ) {
      $fields['type']['toggle'] = true;
    }

    return parent::prepare_fields( $fields );
  }

  /**
   * Filter fields
   *
   * Filter which controls to display, using `include`, `exclude`, `condition`
   * and `of_type` arguments.
   *
   * @since 1.0.0
   *
   * @access protected
   *
   * @return array Control Fields
   */
  protected function filter_fields() {
    $fields = parent::filter_fields();

    $args = $this->get_args();

    foreach( $fields as $field ) {
      if( isset($field['of_type']) && 
        ! in_array($field['of_type'], $args['types'])) {
        unset($field);
      }
    }

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
