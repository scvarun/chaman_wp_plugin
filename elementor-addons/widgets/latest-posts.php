<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use ChamanAddons\ElementorAddons\Controls\Groups;
use ChamanAddons\ElementorAddons\Widgets\ChamanBaseWidget;
use Elementor\Controls_Manager;

class Chaman_Elementor_Latest_Post_Widget extends ChamanBaseWidget {
  
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
    return 'chaman_latest_post_widget';
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
    return __('Latest Posts', 'chaman_addons');
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

    $args = Groups\CustomQuery_Control::get_query('custom_query', $settings);

    $query = new \WP_Query($args);

    ?>
    
      <?php if( $query->have_posts() ): ?>
        <div id="blogpost-thumbs-<?php echo $id; ?>" class="blogpost-thumbs row text-white">
          <?php while( $query->have_posts() ) : $query->the_post(); ?>
          <div class="col-lg-4">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
              <?php if( has_post_thumbnail() ): ?>
              <figure class="entry-thumbnail">
                <?php the_post_thumbnail(); ?>
                <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
              </figure>
              <?php endif; ?>
              <div class="entry-content">
                <h5 class="entry-title h4">
                  <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                </h5>
                <?php echo wp_trim_words( get_the_content(), 20 ); ?>
              </div>
            </article>
          </div><!-- /.col-lg-4 -->
          <?php endwhile; ?>
        </div><!-- /.blogpost-thumbs -->
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
