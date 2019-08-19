<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Partners_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_partners_widget';
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
    return __('Partners', 'chaman_addons');
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
      'title',
      [
        'label' => __('Title', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Title',
      ]
    );

    $repeater->add_control(
      'subtitle', 
      [
        'label' => __('Subtitle', 'chaman_addons'),
        'type'  => \Elementor\Controls_Manager::TEXT,
        'default' => 'Subtitle',
      ]
    );

    $repeater->add_control(
      'description', 
      [
        'label' => __('Description', 'chaman_addons'),
        'type'  => \Elementor\Controls_Manager::TEXT,
        'default' => 'Proin at lectus condimentum, aliquam justo ac, suscipit urna. Proin at ligula porta lacus tempus ullamcorper. Nunc lacus neque, tempor vitae risus eget, porta fringilla',
      ]
    );

    $repeater->add_control(
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
      'list',
      [
        'label' => __( 'List', 'chaman_addons' ),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{{ name }}} - {{{ title }}}',
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

      <div class="partners row">
        <?php foreach($settings['list'] as $partner): ?>
        <div class="col-lg-6">
          <div class="partners-single">
            <figure>
              <img src="<?php echo $partner['image']['url']; ?>" alt="<?php echo $partner['title']; ?>" />
            </figure>
            <div class="partners-single-content">
              <h5 class="partners-single-title"><?php echo $partner['title']; ?></h5>
              <p class="partners-single-subtitle"><?php echo $partner['subtitle']; ?></p>
              <p><?php echo $partner['description']; ?></p>
            </div><!-- /.partners-single-content -->
          </div><!-- /.partners-single -->
        </div><!-- /.col-lg-6 -->
        <?php endforeach; ?>  
      </div><!-- /.partners -->
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
