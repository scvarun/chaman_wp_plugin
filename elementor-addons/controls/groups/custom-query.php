<?php

namespace ChamanAddons\ElementorAddons\Controls\Groups;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use \Elementor\Controls_Manager;

/*
 * =================================================
 * =================================================
 *
 * Usage:

$this->add_group_control(
  Groups\Custom_Query_Control::get_type(),
  [
    'name' => 'custom_query',
    'label' => __('Custom Query', 'unifato_addons'),

    // optional
  ]
);

 *
 * =================================================
 * =================================================
 */
class CustomQuery_Control extends \Elementor\Group_Control_Base {

  /**
   * Fields.
   *
   * Holds all the control fields.
   *
   * @since 1.0.0
   * @access protected
   * @static
   *
   * @var array control fields.
   */
  protected static $fields;

  /**
   * Return the type of control
   *
   * Returns the name by which it is identified in Elementor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public static function get_type() {
    return 'unifato_custom_query';
  }

  /**
   * Content Template of control
   *
   * Outputs the fields of control
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function init_fields() {
    $fields = [];

    $fields['posts_per_page'] = [
      'type' => Controls_Manager::NUMBER,
      'label' => __('Posts Per Page', 'unifato_addons'),
      'description' => __('The number of posts on a page.', 'unifato_addons'),
    ];

    $fields['post__in'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Posts ID', 'unifato_addons'),
      'description' => __('List of posts id to display.', 'unifato_addons'),
      'multiple' => true,
    ];

    $fields['author__in'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Authors', 'unifato_addons'),
      'description' => __('Select the authors whose posts you want to display.', 'unifato_addons'),
      'multiple' => true,
    ];

    $fields['category__in'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Categories', 'unifato_addons'),
      'description' => __('Select the categories you want posts of.', 'unifato_addons'),
      'multiple' => true,
    ];

    $fields['tag__in'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Tags', 'unifato_addons'),
      'description' => __('Select the tags you want posts of.', 'unifato_addons'),
      'multiple' => true,
    ];

    $fields['post_type'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Post Type', 'unifato_addons'),
      'description' => __('Select the post type you want posts of.', 'unifato_addons'),
      'multiple' => true,
    ];

    $fields['before'] = [
      'type' => Controls_Manager::DATE_TIME,
      'label' => __('Posted Before', 'unifato_addons'),
      'description' => __('Posts of published date before this will be displayed.', 'unifato_addons'),
    ];

    $fields['after'] = [
      'type' => Controls_Manager::DATE_TIME,
      'label' => __('Posted After', 'unifato_addons'),
      'description' => __('Posts of published date after this will be displayed.', 'unifato_addons'),
    ];

    $fields['inclusive'] = [
      'type' => Controls_Manager::SWITCHER,
      'label' => __('Inclusive Date?', 'unifato_addons'),
      'label_on' => __('Yes', 'unifato_addons'),
      'label_off' => __('No', 'unifato_addons'),
      'return_value' => 'yes',
      'default' => '',
    ];

    $fields['order'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Order', 'unifato_addons'),
      'options' => [
        'ASC' => __('Ascending', 'unifato_addons'),
        'DESC' => __('Descending', 'unifato_addons'),
      ],
      'default' => 'DESC'
    ];

    $fields['orderby'] = [
      'type' => Controls_Manager::SELECT2,
      'label' => __('Order By', 'unifato_addons'),
      'options' => [
        'ID' => __('ID', 'unifato_addons'),
        'author' => __('Author', 'unifato_addons'),
        'title' => __('Title', 'unifato_addons'),
        'type' => __('Post Type', 'unifato_addons'),
        'date' => __('Date Posted', 'unifato_addons'),
        'modified' => __('Date Last Modified', 'unifato_addons'),
        'parent' => __('Parent ID', 'unifato_addons'),
        'rand' => __('Random', 'unifato_addons'),
        'comment_count' => __('Comment Count', 'unifato_addons'),
      ],
    ];

    return $fields;
  }

  /**
   * Returns default options
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function get_default_options() {
    return [
      'popover' => true,
    ];
  }

  /**
   * Get child default args
   *
   * Retrieve the default arguments for all the child controls for a specific
   * group control.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function get_child_default_args() {
    return [
      'posts_per_page' => [
        'default' => 10,
      ],
    ];
  }

  /**
   * Prepare fields.
   *
   * Process custom-query control fields before adding them to `add_control()`.
   *
   * @since 1.0.0
   * @access protected
   *
   * @param array $fields CustomQuery control fields.
   *
   * @return array Processed fields.
   */
  protected function prepare_fields($fields) {
    $args = $this->get_args();

    // Post Count Field
    $fields = $this->set_field_from_args($fields, 'posts_per_page', $args, 'posts_per_page');

    if( isset($args['posts_per_page_field']) ) {
      $args['posts_per_page'] = array_merge(
        $args['posts_per_page'],
        $args['posts_per_page_field']
      );

      $fields = $this->set_field_from_args($fields, 'posts_per_page', $args, 'posts_per_page');

      if( $args['posts_per_page_field']['disabled'] == true )
        unset($fields['posts_per_page_field']);
    }

    // Authors Field
    $authors = get_users(['fields' => ['ID', 'display_name']]);
    $author_for_field = [];
    foreach($authors as $author) {
      $author_for_field[$author->ID] = $author->display_name;
    }
    $fields['author__in']['options'] = $author_for_field;

    // Category Field
    $categories = get_categories();
    $category_for_field = [];
    foreach($categories as $category) {
      $category_for_field[$category->cat_ID] = $category->cat_name;
    }
    $fields['category__in']['options'] = $category_for_field;

    // Tags Field
    $tags = get_tags();
    $tags_for_field = [];
    foreach($tags as $tag) {
      $tags_for_field[$tag->term_id] = $tag->name;
    }
    $fields['tag__in']['options'] = $tags_for_field;

    // Post Type Field
    $post_types = get_post_types([
      'public' => true,
    ], 'classes');
    $post_types_for_field = [];

    foreach($post_types as $post_type) {
      $post_types_for_field[$post_type->name] = $post_type->label;
    }
    $fields['post_type']['options'] = $post_types_for_field;

    return parent::prepare_fields( $fields );
  }

  /**
   * Set default parameter from args to fields
   *
   * @since 1.0.0
   * @access protected
   *
   * @param array $fields CustomQuery control fields.
   * @param array $fields_id ID to target.
   * @param array $args Arguments.
   * @param array $args_id ID of args to target.
   *
   * @return array Processed fields.
   */
  private function set_field_from_args($fields, $fields_id, $args, $args_id) {
    $fields[$fields_id] = array_merge(
      $fields[$fields_id],
      $args[$args_id]
    );

    return $fields;
  }

  /**
   * Returns wp_query array
   *
   * @since 1.0.0
   * @access public
   *
   * @param string $name CustomQuery control fields.
   * @param array $settings Settings array.
   *
   * @return array WP_Query Array.
   */
  public static function get_query($name, $settings) {
    $arr = [];
    $regex = '/^' . $name . '_[a-zA-Z_]+/';

    foreach($settings as $key => $value) {
      if( preg_match($regex, $key) ) {
        $pos = stripos($key, $name . '_') + strlen($name) + 1;
        $new_key = substr($key, $pos);

        if($new_key == 'before') {
          $arr['date_query']['before'] = $value;
        } else if($new_key == 'after') {
          $arr['date_query']['after'] = $value;
        } else if($new_key == 'inclusive') {
          $arr['date_query']['inclusive'] = $value == 'yes';
        }else {
          $arr[$new_key] = $value;
        }
      }
    }

    return $arr;
  }
}