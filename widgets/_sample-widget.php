<?php

class Chaman_Sample_Widget extends WP_Widget {
  /**
   * Constructor
   * 
   * @since 1.0.0
   * 
   * @access public
   */
  public function __construct() {
    $widget_ops = array(
      'description' => esc_html__('Sample Widget', 'chaman_addons')
    );
    parent::__construct(
      'Chaman_sample_widget',
      esc_html__('Sample Widget', 'chaman_addons'), 
      $widget_ops
    );
  }

  /**
   * Outputs the content of the widget
   * 
   * @since 1.0.0
   * 
   * @access public
   *
   * @param array $args Widget arguments
   * @param array $instance Saved values from database
   */
  public function widget($args, $instance) {

  }

  /**
   * Outputs the options form on admin
   * 
   * @since 1.0.0
   * 
   * @access public
   *
   * @param array $instance The widget options
   */
  public function form($instance) {

  }

  /**
   * Processing widget options on save
   * 
   * @since 1.0.0
   * 
   * @access public
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   * 
   * @return array
   */
  public function update($new_instance, $old_instance) {

  }
}

add_action( 'widgets_init', function() {
  register_widget('Chaman_Sample_Widget');
});
