<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class ContentOnPosts extends Meta {
  protected $hook = 'cmb2_admin_init';
  
  /**
   * Registers post meta
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function meta() {
    $cmb = new_cmb2_box([
      'id'            => 'meta_content_on_posts',
      'title'         => __( 'Content', 'chaman_addons' ),
      'object_types'  => array( 'posts' ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ]);

    $cmb->add_field([
      'name'          => __( 'Alternate Title', 'chaman_addons' ),
      'desc'          => __( 'A title to display above the post title', 'chaman_addons' ),
      'id'            => '__content_posts__alternate_title',
      'type'          => 'text',
    ]);
  }
}