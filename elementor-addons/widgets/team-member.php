<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Team_Members_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_team_members_widget';
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
    return __('Team Members', 'chaman_addons');
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
      'name',
      [
        'label' => __('Name', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Name Surname',
      ]
    );

    $repeater->add_control(
      'title',
      [
        'label' => __('Title', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Principal',
      ]
    );

    $repeater->add_control(
      'description',
      [
        'label' => __('Description', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => 'Suspendisse potenti. Proin at lectus condimentum, aliquam justo ac, suscipit urna.',
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

    $id = $this->get_id();

    ?>
      <div id="team-members-<?php echo $id; ?>" class="team-members row">
        <?php foreach($settings['list'] as $member): ?>
        <div class="col-lg-4">
          <div class="team-member-single">
            <figure>
              <img src="<?php echo $member['image']['url']; ?>" />
            </figure>
            <div class="team-member-content">
              <h5 class="team-member-name"><?php echo $member['name']; ?></h5>
              <p class="team-member-title"><?php echo $member['title']; ?></p>
              <p><?php echo $member['description']; ?></p>
            </div><!-- /.team-member-content -->
          </div><!-- /.team-member-single -->
        </div><!-- /.col-lg-4 -->
        <?php endforeach; ?>
      </div><!-- /.team-members -->
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
