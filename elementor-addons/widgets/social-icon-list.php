<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Social_Icon_List_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_social_icon_list_widget';
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
    return __('Social Icon List', 'chaman_addons');
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

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'social_site',
      [
        'label' => __('Social Site', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'facebook-f',
        'options' => [
          'facebook-f' => 'Facebook',
          'twitter' => 'Twitter',
          'instagram' => 'instagram',
          'linkedin' => 'LinkedIn'
        ],
      ]
    );

    $repeater->add_control(
      'link',
      [
        'label' => __('Link', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => __( 'https://your-link.com', 'plugin-domain' ),
        'show_external' => true,
        'default' => [
          'url' => '',
          'is_external' => true,
          'nofollow' => true,
        ],
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => __( 'List', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{{ social_site }}}',
      ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
      'style_section',
      [
        'label' => __('Style', 'chaman_addons'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'typography',
        'label' => __( 'Typography', 'chaman_addons' ),
        'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .social-list',
      ]
    );

    $this->add_control(
      'color',
      [
        'label' => __( 'Link Color', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::COLOR,
        'scheme' => [
          'type' => \Elementor\Scheme_Color::get_type(),
          'value' => \Elementor\Scheme_Color::COLOR_1,
        ],
        'selectors' => [
          '{{WRAPPER}} .social-list a' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'icon_padding',
      [
        'label' => __( 'Button Padding', 'unifato_addons' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', '%', 'em' ],
        'selectors' => [
          '{{WRAPPER}} a' => 'padding-top: {{TOP}}{{UNIT}};',
          '{{WRAPPER}} a' => 'padding-bottom: {{BOTTOM}}{{UNIT}}',
          '{{WRAPPER}} li:not(:last-child) a' => 'padding-right: {{RIGHT}}{{UNIT}}',
          '{{WRAPPER}} li:not(:first-child) a' => 'padding-left: {{LEFT}}{{UNIT}};'
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

    $target = $settings['website_link']['is_external'] ? ' target="_blank"' : '';
    $nofollow = $settings['website_link']['nofollow'] ? ' rel="nofollow"' : '';

    ?>
      <ul class="social-list list-unstyled list-inline">
        <?php foreach($settings['list'] as $item): ?>
          <li class="list-inline-item">
            <a href="<?php echo $item['link']['url']; ?>" <?php echo $target . $nofollow; ?>>
              <i class="fa fa-<?php echo $item['social_site']; ?>"></i>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
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
