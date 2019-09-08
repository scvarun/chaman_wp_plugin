<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Countdown_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_countdown_widget';
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
    return __('Countdown', 'chaman_addons');
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
      'date',
      [
        'label' => __('Date', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::DATE_TIME,
        'picker_options' => [
          'minDate' => 'today'
        ]
      ]
    );

    $this->add_control(
      'show_days',
      [
        'label' => __('Show Days', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'unifato_addons'),
        'label_off' => __('No', 'unifato_addons'),
        'return_value' => 'yes',
        'default' => 'yes'
      ]
    );

    $this->add_control(
      'show_hours',
      [
        'label' => __('Show Hours', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'unifato_addons'),
        'label_off' => __('No', 'unifato_addons'),
        'return_value' => 'yes',
        'default' => 'yes'
      ]
    );

    $this->add_control(
      'show_minutes',
      [
        'label' => __('Show Minutes', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'unifato_addons'),
        'label_off' => __('No', 'unifato_addons'),
        'return_value' => 'yes',
        'default' => 'yes'
      ]
    );

    $this->add_control(
      'show_seconds',
      [
        'label' => __('Show Seconds', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'unifato_addons'),
        'label_off' => __('No', 'unifato_addons'),
        'return_value' => 'yes',
        'default' => 'yes'
      ]
    );

    $this->add_control(
      'finished_message',
      [
        'label' => __('Finished Message', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => 'Welcome to the Future'
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

    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>


      <div  class="countdown countdown-minimal"  data-status="active"
            data-plugin-options='{"finalDate": "<?php echo date_format(date_create($settings['date']), 'm/d/Y H:i:s'); ?>"}'>
        <span class="countdown-content">
          <?php if($settings['show_days'] == 'yes'): ?>
            <span><strong class="h3">24</strong> days</span>
          <?php endif; ?>

          <?php if($settings['show_hours'] == 'yes'): ?>
            <span><strong class="h3">18</strong> hours</span>
          <?php endif; ?>

          <?php if($settings['show_minutes'] == 'yes'): ?>
            <span><strong class="h3">36</strong> minutes</span>
          <?php endif; ?>

          <?php if($settings['show_seconds'] == 'yes'): ?>
            <span><strong class="h3">1</strong> seconds</span>
          <?php endif; ?>
        </span>
        <span class="countdown-completed-content">
          <?php echo $settings['finished_message']; ?>
        </span>
      </div><!-- /.countdown -->


    <?php } else  { ?>


      <div  class="countdown countdown-minimal" 
            data-plugin-options='{"finalDate": "<?php echo date_format(date_create($settings['date']), 'm/d/Y H:i:s'); ?>"}'>
        <span class="countdown-content">
          <?php if($settings['show_days'] == 'yes'): ?>
            <span><strong class="h3">%D</strong> day%!D</span>
          <?php endif; ?>

          <?php if($settings['show_hours'] == 'yes'): ?>
            <span><strong class="h3">%H</strong> hour%!H</span>
          <?php endif; ?>

          <?php if($settings['show_minutes'] == 'yes'): ?>
            <span><strong class="h3">%M</strong> minute%!M</span>
          <?php endif; ?>

          <?php if($settings['show_seconds'] == 'yes'): ?>
            <span><strong class="h3">%S</strong> second%!S</span>
          <?php endif; ?>
        </span>
        <span class="countdown-completed-content">
          <?php echo $settings['finished_message']; ?>
        </span>
      </div><!-- /.countdown -->
    <?php }
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
    ?>
      <div  class="countdown countdown-minimal" 
            data-plugin-options='{"finalDate": "<?php echo date_format(date_create($settings['date']), 'm/d/Y H:i:s'); ?>"}' data-status="active">
        <span class="countdown-content">
          <# if(settings['show_days'] === 'yes') { #>
            <span><strong class="h3">24</strong> days</span>
          <# } #>

          <# if(settings['show_hours'] === 'yes') { #>
            <span><strong class="h3">18</strong> hours</span>
          <# } #>

          <# if(settings['show_minutes'] === 'yes') { #>
            <span><strong class="h3">36</strong> minutes</span>
          <# } #>

          <# if(settings['show_seconds'] === 'yes') { #>
            <span><strong class="h3">1</strong> seconds</span>
          <# } #>
        </span>
        <span class="countdown-completed-content">
          {{{settings.finished_message}}}
        </span>
      </div><!-- /.countdown -->
    <?php
  }

  /**
   * Scripts to enqueue registered in UnifatoAddons->widget_scripts()
   *
   * @since 1.0.0
   *
   * @access protected
   */
  public function get_script_depends() {
    return [ 'jquery.countdown' ];
  }
}
