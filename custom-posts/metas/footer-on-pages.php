<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class FooterOnPages extends Meta {
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
      'id'            => 'meta_footer',
      'title'         => __( 'Footer', 'chaman_addons' ),
      'object_types'  => array( 'page' ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ]);

    // Show default footer field
    $cmb->add_field([
      'name'          => __( 'Show default?', 'chaman_addons' ),
      'desc'          => __( 'Show default footer set in theme options?', 'chaman_addons' ),
      'id'            => '__show_default_footer',
      'type'          => 'radio_inline',
      'default'       => 'yes',
      'options'       =>  [
        'yes' => __('Yes', 'chaman_addons'),
        'no' => __('No', 'chaman_addons'),
      ],
    ]);

    // Select Footer field
    $cmb->add_field([
      'name'          => __('Select Footer', 'chaman_addons'),
      'desc'          => __('Select exact footer to show'),
      'id'            => '__override_footer',
      'type'          => 'uni_select_post',
      'query_args'    => [
        'post_type' => 'footer',
        'posts_per_page' => -1,
      ],
    ]);

  }
}