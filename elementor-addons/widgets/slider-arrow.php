<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Slider_Arrow_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_slider_arrow_widget';
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
    return __('Slider Arrow', 'chaman_addons');
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

    $this->add_control(
      'target_id',
      [
        'label' => __('Target Id', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
      ]
    );

    $this->add_control(
      'style',
      [
        'label' => __('Style', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'default' => 'dark',
        'options' => [
          'dark' => __('Dark', 'chaman_addons'),
          'light' => __('Light', 'chaman_addons'),
        ]
      ]
    );

    $this->add_control(
      'direction',
      [
        'label' => __('Direction', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'default' => 'next',
        'options' => [
          'next' => __('Next', 'chaman_addons'),
          'prev' => __('Previous', 'chaman_addons'),
        ]
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

    $classes = 'slider-arrow';
    $classes .= ' slider-arrow-' . $settings['direction'];
    $classes .= ' slider-arrow-' . $settings['style']
    ?>

    <a href="<?php echo $settings['target_id']; ?>" class="<?php echo $classes; ?>">
      Next
    </a>

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
