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
    return 'chaman_team_members_new_widget';
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

    $this->add_group_control(
      Groups\CustomQuery_Control::get_type(),
      [
        'name' => 'custom_query',
        'label' => __('Custom Query', 'unifato_addons'),
        'posts_per_page_field' => [
          'default' => 5,
        ],
        'post_type_field' => [
          'default' => 'staff',
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

    $args = Groups\CustomQuery_Control::get_query('custom_query', $settings);

    $query = new \WP_Query($args);

    $id = $this->get_id();

    ?>
      <?php if( $query->have_posts() ): ?>
        <div id="team-members-<?php echo $id; ?>" class="team-members">
        <?php while( $query->have_posts() ): $query->the_post(); ?>
          <div class="team-member-single">
            <?php if( has_post_thumbnail() ): ?>
              <figure>
                <a class="pos-0 text-indent-full" href="<?php echo get_post_meta( get_the_ID(), '__staff__link', true ); ?>">
                  <?php echo get_the_title(); ?>   
                </a>
                <?php the_post_thumbnail(); ?>
              </figure>
            <?php endif; ?>
            <div class="team-member-content">
              <h5 class="team-member-name">
                <a href="<?php echo get_post_meta( get_the_ID(), '__staff__link', true ); ?>">
                  <?php echo get_the_title(); ?>
                </a>
              </h5>
              <?php the_content(); ?>
            </div><!-- /.team-member-content -->
          </div><!-- /.team-member-single -->
        <?php endwhile; ?>
        </div><!-- /.team-members -->
      <?php endif; ?>     
    <?php
    wp_reset_postdata();
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
