<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Facilitators_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_facilitators_widget';
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
    return __('Facilitators', 'chaman_addons');
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
        'description' => __('Add the post id of the facilitator you want to display, in the post id field.', 'unifato_addons'),
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

    ?>
      <?php if( $query->have_posts() ): ?>
        <div class="facilitators">
          <?php while( $query->have_posts() ) : $query->the_post(); ?>
            <div class="facilitator">
              <?php if( has_post_thumbnail() ): ?>
                <figure>
                  <?php the_post_thumbnail('medium'); ?>
                </figure>
              <?php endif; ?>
              <div class="facilitator-content">
                <span><?php echo get_the_title(); ?></span>
                <span><?php echo get_post_meta( get_the_ID(), '__staff__title', true ); ?></span>
                <?php
                  $email = get_post_meta( get_the_ID(), '__staff__email', true ); 
                  if( $email !== '' ): 
                ?>
                  <p><a href="<?php echo $email; ?>" rel="nofollow">Email link</a></p>
                <?php endif; ?>
              </div><!-- /.facilitator-content -->
            </div><!-- /.facilitators -->
          <?php endwhile; ?>
        </div><!-- /.facilitators -->
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
