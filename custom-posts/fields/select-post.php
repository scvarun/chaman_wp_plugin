<?php

namespace ChamanAddons\CustomPosts\Fields;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

class SelectPost {
  /**
   * Registers fields
   * 
   * @since 1.0.0
   *
   * @access public
   *
   */
  public function run() {
    add_action( 'cmb2_render_uni_select_post', [ $this, 'cmb2_render_callback_uni_select_post' ], 10, 5 );
  }

  public function cmb2_render_callback_uni_select_post($field, $escaped_value, $object_id, $object_type, $field_type) {
    echo $field_type->select([
      'options' => $this->cmb2_get_query_options($field->args['query_args'], $escaped_value),
    ]);
  }

  public function cmb2_get_query_options($query_arr, $value) {
    $ret = '';
    $query = new \WP_Query($query_arr);
    if($query->have_posts()) {
      while($query->have_posts()) {
        $query->the_post();
        $ret .= '<option value="' . get_the_ID() . '"' . ( $value == get_the_ID() ? ' selected' : '' ) . '>' . get_the_title() . '</option>';
      }
    }
    return $ret;
  }
}