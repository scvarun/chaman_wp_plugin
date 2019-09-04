<?php

namespace ChamanAddons\CustomPosts\Types;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class Staff extends Type {
  protected $meta_hook = 'cmb2_admin_init';

  /**
   * Register Post Type
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function register() {
    register_cuztom_post_type(
      'Staff',
      [
        'menu_icon' => 'dashicons-archive',
        'has_archive' => false,
        'publicly_queryable' => true,
        'public' => true,
        'show_in_rest' => false,
        'show_in_admin_bar' => false,
        'exclude_from_search' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
      ]
    );
  }


  /**
   * Register Post Meta
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function meta() {
    $cmb = new_cmb2_box([
      'id'            => 'meta_staff',
      'title'         => __( 'Staff Details', 'chaman_addons' ),
      'object_types'  => array( 'staff' ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ]);

    $cmb->add_field([
      'name'          => __( 'Title', 'chaman_addons' ),
      'desc'          => __( 'Post by which member is identified with', 'chaman_addons' ),
      'id'            => '__staff__title',
      'type'          => 'text',
    ]);

    $cmb->add_field([
      'name'          => __( 'Email', 'chaman_addons' ),
      'desc'          => __( 'Email of the member', 'chaman_addons' ),
      'id'            => '__staff__email',
      'type'          => 'text_email',
      'default'       => '',
    ]);
  }
}