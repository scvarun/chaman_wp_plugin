<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class ContentOnPages extends Meta {
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
      'id'            => 'meta_content',
      'title'         => __( 'Content', 'chaman_addons' ),
      'object_types'  => array( 'page' ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ]);

    // Show default footer field
    $cmb->add_field([
      'name'          => __( 'Background', 'chaman_addons' ),
      'desc'          => __( 'Set background for content wrapper', 'chaman_addons' ),
      'id'            => '__content__background',
      'type'    => 'colorpicker',
    ]);
  }
}