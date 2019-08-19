<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Progress_Bar_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_progress_bar_widget';
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
    return __('Progress Bar', 'chaman_addons');
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
      'title',
      [
        'label' => __('Title', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Title',
      ]
    );

    $this->add_control(
      'current_value',
      [
        'label' => __('Current Value', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 10
      ]
    );

    $this->add_control(
      'max_value',
      [
        'label' => __('Max Value', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 100
      ]
    );

    $this->add_control(
      'min_value',
      [
        'label' => __('Min Value', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => 0
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
  
      <div class="custom-progress-bar">
        <div class="progress">
          <div  class="progress-bar" 
                role="progressbar" 
                style="height: <?php echo $settings['current_value'] * 100 / ($settings['max_value'] - $settings['min_value']) ?>%" 
                aria-valuenow="<?php echo $settings['current_value']; ?>" 
                aria-valuemin="<?php echo $settings['min_value']; ?>" 
                aria-valuemax="<?php echo $settings['max_value']; ?>">
          </div>
        </div><!-- /.progress -->
        <div class="progress-content">
          <h2 class="progress-title"><?php echo $settings['current_value']; ?></h2>
          <h6 class="progress-subtitle"><?php echo $settings['title']; ?></h6>
        </div><!-- /.progress-content -->
      </div><!-- /.custom-progress-bar -->

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
