<?php

/**
 * Sample Widget
 * 
 * Usage: [sample_shortcode text=""]
 *
 * @since 1.0.0
 *
 * @var text Text to display
 */
function Chaman_shortcode_sample($atts) {
  $default = [
    'text' => 'world'
  ];

  $a = shortcode_atts($default, $atts);

  $message = sprintf( 'Hello %1$s', $a['text']);

  return esc_html($message);
}

add_shortcode('Chaman_sample', 'Chaman_shortcode_sample');