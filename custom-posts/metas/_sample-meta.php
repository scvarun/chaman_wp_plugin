<?php

namespace ChamanAddons\CustomPosts\Metas;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class SampleOnPages extends Meta {
  /**
   * Registers post meta
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function meta() {
  }
}