<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class HeaderOnPages extends Meta {
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
      'id'            => 'meta_header',
      'title'         => __( 'Header', 'chaman_addons' ),
      'object_types'  => array( 'page' ), // Post type
      'context'       => 'normal',
      'priority'      => 'high',
      'show_names'    => true, // Show field names on the left
    ]);

    $cmb->add_field([
      'name'          => __( 'Overlay Header', 'chaman_addons' ),
      'desc'          => __( 'Overlay the header over content', 'chaman_addons' ),
      'id'            => '__header__overlay_header',
      'type'          => 'radio_inline',
      'default'       => 'no',
      'options'       =>  [
        'yes' => __('Yes', 'chaman_addons'),
        'no' => __('No', 'chaman_addons'),
      ],
    ]);

    $cmb->add_field([
      'name'          => __('Hide Header?', 'chaman_addons'),
      'desc'          => __('Hide the header on the page.', 'chaman_addons'),
      'id'            => '__header__hide',
      'type'          => 'radio_inline',
      'default'       => 'no',
      'options'       => [
        'yes' => __('Yes', 'chaman_addons'),
        'no' => __('No', 'chaman_addons'),
      ],
    ]);

  }
}