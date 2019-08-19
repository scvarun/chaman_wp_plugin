<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Facilitator_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_facilitator_widget';
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
    return __('Facilitator', 'chaman_addons');
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
      'name',
      [
        'label' => __('Name', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Name Surname',
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
      'image',
      [
        'label' => __( 'Choose Image', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );

    $this->add_control(
      'enable_link',
      [
        'label' => __('Enable Link', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __('Yes', 'chaman_addons'),
        'label_off' => __('No', 'chaman_addons'),
        'return_value' => 'yes',
        'default' => 'yes',
      ]
    );

    $this->add_control(
      'link_text',
      [
        'label' => __('Link Text', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Email link',
        'condition' => [
          'enable_link' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'link',
      [
        'label' => __( 'Link', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'chaman_addons' ),
        'show_external' => true,
        'default' => [
          'url' => 'mailto://a@b.com',
          'is_external' => true,
          'nofollow' => true,
        ],
        'condition' => [
          'enable_link' => 'yes',
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
    ?>
      <div class="facilitator">
        <figure>
          <img src="<?php echo $settings['image']['url']; ?>" alt="<?php echo $settings['name']; ?>" />
        </figure>
        <span><?php echo $settings['name']; ?></span>
        <span><?php echo $settings['title']; ?></span>
        <?php if( $settings['enable_link'] == 'yes' ): ?>
          <?php   $target = $settings['link']['is_external'] ? ' target="_blank"' : '';
                  $nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
          <p><a href="<?php echo $settings['link']['url']; ?>"<?php echo $target . $nofollow; ?>><?php echo $settings['link_text']; ?></a></p>
        <?php endif; ?>
      </div><!-- /.facilitators -->
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
