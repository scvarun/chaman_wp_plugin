<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Testimonial_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_testimonial_widget';
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
    return __('Testimonial', 'chaman_addons');
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
        'default' => '"Lorem ipsum dolor set amet"',
      ]
    );

    $this->add_control(
      'name',
      [
        'label' => __('Name', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'John Doe'
      ]
    );

    $this->add_control(
      'user_title',
      [
        'label' => __('User title', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Lorem Ipsum',
      ]
    );

    $this->add_control(
      'text',
      [
        'label' => __('Text', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::WYSIWYG,
        'default' => 'Suspendisse potenti. Proin at lectus condimentum, aliquam justo ac, suscipit urna. Proin at ligula porta lacus tempus ullamcorper. Nunc lacus neque, tempor vitae risus eget, porta frigilla nibh.',
      ]
    );

    $this->add_control(
      'alignment',
      [
        'label' => __( 'Alignment', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => __( 'Left', 'chaman_addons' ),
            'icon' => 'fa fa-align-left',
          ],
          'right' => [
            'title' => __( 'Right', 'chaman_addons' ),
            'icon' => 'fa fa-align-right',
          ],
        ],
        'default' => 'left',
        'toggle' => false,
      ]
    );

    $this->add_control(
      'image',
      [
        'label' => __( 'Choose Image', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
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

    $classes = "row testimonial testimonial-" . $settings['alignment'];

    ?>
    
      <blockquote class="<?php echo $classes; ?>">
        <div class="col-sm-7">
          <h3 class="testimonial-title"><?php echo $settings['title']; ?></h3>
          <h6 class="testimonial-user-info">
            <span class="testimonial-user-name"><?php echo $settings['name']; ?></span> --
            <span class="testimonial-user-title"><?php echo $settings['user_title']; ?></span>
          </h6>
          <?php echo $settings['text']; ?>
        </div><!-- /.col-sm-7 -->

        <div class="col-sm-5">
          <figure>
            <img src="<?php echo $settings['image']['url']; ?>" alt="<?php echo $settings['name'] . ' - ' . $settings['user_title']; ?>">
          </figure>
        </div><!-- /.col-sm-5 -->
      </blockquote>
      
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
