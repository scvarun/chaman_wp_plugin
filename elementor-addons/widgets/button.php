<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;

class Chaman_Elementor_Button_Widget extends ChamanBaseWidget {
  
  /**
   * Get Widget name.
   * 
   * Name by which this widget is identified.
   *
   * @since 1.0.0
   *
   * @access public
   *
   * @return string Widget name.
   */
  public function get_name() {
    return 'chaman_button';
  }

  /**
   * Get Widget title.
   * 
   * Title of widget shown in Elementor Editor.
   *
   * @since 1.0.0
   *
   * @access public
   *
   * @return string Widget title.
   */
  public function get_title() {
    return __('Button', 'chaman_addons');
  }

  /**
   * Get Widget Icon.
   * 
   * Return the icon of widget shown in Elementor Editor.
   *
   * @since 1.0.0
   *
   * @access public
   *
   * @return string Widget icon.
   */
  public function get_icon() {
    return 'fa fa-code';
  }

  /**
   * Get Widget categories.
   * 
   * Return the list of categories widget belongs to.
   *
   * @since 1.0.0
   *
   * @access public
   *
   * @return array Widget categories.
   */
  public function get_categories() {
    return ['chaman-addons'];
  }

  /**
   * Register fields/controls of widget.
   * 
   * Adds section, tabs and controls/fields and customize widget settings.
   *
   * @since 1.0.0
   *
   * @access protected
   *
   * @return array Widget categories.
   */
  protected function _register_controls() {
    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Content', 'chaman_addons'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->start_controls_section(
      'content_section',
      [
        'label' => __('Content', 'chaman_addons'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'tag',
      [
        'label' => __('Type', 'chaman_addons'),
        'type' => Controls_Manager::SELECT2,
        'options' => [
          'link' => 'Link',
          'button' => 'Button',
          'submit' => 'Submit',
          'reset' => 'Reset'
        ],
        'default' => 'button'
      ]
    );

    $this->add_control(
      'btn_style',
      [
        'label' => __('Style', 'chaman_addons'),
        'type' => Controls_Manager::SELECT2,
        'options' => [
          'default' => 'Default',
          'rounded' => 'Rounded',
          'circle' => 'Circle',
        ],
        'default' => 'default'
      ]
    );

    $this->add_group_control(
      Groups\ColorPicker_Control::get_type(),
      [
        'name' => 'color',
        'label' => __('Color', 'chaman_addons'),
        'custom_color_field' => [
          'disabled' => true,
        ],
        'theme_color_field' => [
          'default_selector' => false,
        ],
      ]
    );

    $this->add_control(
      'outline',
      [
        'label' => __('Outline Style', 'chaman_addons'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'chaman_addons' ),
        'label_off' => __( 'No', 'chaman_addons' ),
        'return_value' => 'yes',
        'default' => 'no'
      ]
    );

    $this->add_control(
      'block',
      [
        'label' => __('Block Style', 'chaman_addons'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'chaman_addons' ),
        'label_off' => __( 'No', 'chaman_addons' ),
        'return_value' => 'yes',
        'default' => 'no'
      ]
    );

    $this->add_control(
      'url',
      [
        'label' => __('Link', 'chaman_addons'),
        'type' => Controls_Manager::URL,
        'placeholder' => __('https://your-link.com', 'chaman_addons'),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => true,
          'nofollow' => true
        ]
      ]
    );

    $this->add_control(
      'text',
      [
        'label' => __('Text', 'chaman_addons'),
        'type' => Controls_Manager::TEXT,
        'default' => 'Button'
      ]
    );

    $this->add_control(
      'size',
      [
        'label' => __('Sizes', 'chaman_addons'),
        'type' => Controls_Manager::SELECT2,
        'options' => [
          'default' => 'Default',
          'lg' => 'Large',
          'sm' => 'Small'
        ],
        'default' => 'default'
      ]
    );

    $this->end_controls_section();

    $this->_register_controls_parent();
  }

  /**
   * Prints output to frontend
   * 
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function render() {
    $this->_render_parent();
    
    $settings = $this->get_settings_for_display();
    ?>
    <?php
  }

  /**
   * Prints output to Elementor Editor
   * 
   * Written in HTML and Backbone.js MarionetteJS Template Engine.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function _content_template() {
  }
}
