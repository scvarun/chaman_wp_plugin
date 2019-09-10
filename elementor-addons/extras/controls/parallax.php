<?php

namespace ChamanAddons\ElementorAddons\Extras\Controls;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

class Background_Parallax_Control {
  public function __construct() {
    add_action('elementor/element/section/section_background/after_section_end', [$this, 'add_fields'], 10, 3);
    add_action('elementor/frontend/section/before_render', [$this, 'render_background_parallax'], 10, 3);

    add_action('elementor/element/column/section_background_overlay/after_section_end', [$this, 'add_fields'], 10, 3);
    add_action('elementor/frontend/column/before_render', [$this, 'render_background_parallax'], 10, 3);
  }

  public function add_fields($element, $args) {
    $element->start_controls_section(
      'background_parallax',
      [
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'label' => __( 'Background Parallax', 'chaman_addons' ),
      ]
    );

    $element->add_group_control(
      \Elementor\Group_Control_Background::get_type(),
      [
        'name' => 'background_parallax',
        'types' => [ 'classic' ],
        'fields_options' => [
          'background' => [
            'frontend_available' => true,
          ],
          'video_link' => [
            'frontend_available' => true,
          ],
          'video_start' => [
            'frontend_available' => true,
          ],
          'video_end' => [
            'frontend_available' => true,
          ],
          'play_once' => [
            'frontend_available' => true,
          ],
        ],
        'selector' => '{{WRAPPER}}, {{WRAPPER}} > [id^="jarallax-container"] > div',
      ]
    );

    $element->add_control(
      'background_parallax_speed',
      [
        'label' => __('Parallax Speed', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => .6,
        'min' => -1,
        'max' => 2,
        'step' => .01,
        'description' => __('Parallax effect speed. Provide numbers from -1.0 to 2.0.', 'chaman_addons'),
      ]
    );

    $element->add_control(
      'background_parallax_type',
      [
        'label' => __('Type', 'chaman_addons'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'description' => __('', 'chaman_addons'),
        'options' => [
          'scroll' => 'Scroll',
          'scale' => 'Scale',
          'opacity' => 'Opacity',
          'scroll-opacity' => 'Scroll-Opacity',
          'scale-opacity' => 'Scale-Opacity',
        ],
        'default' => 'scroll',
      ]
    );

    $element->end_controls_section();
  }


  public function render_background_parallax(\Elementor\Element_Base $element) {
    $settings = $element->get_settings();

    if( !isset($settings['background_parallax_background']) || $settings['background_parallax_background'] === '' ) {
      return;
    }

    wp_enqueue_script('jarallax');


    $pluginOptions = [
      'imgSize' => $settings['background_parallax_size'],
      'imgPosition' => $settings['background_parallax_position'],
      'imgRepeat' => $settings['background_parallax_repeat'],
      'speed' => $settings['background_parallax_speed'],
      'type' => $settings['background_parallax_type'],
    ];

    if( $settings['background_parallax_size'] == 'initial' )
      $pluginOptions['imgSize'] = 
        $settings['background_parallax_bg_width']['size'] . $settings['background_parallax_bg_width']['unit'] . ' auto';

    $element->add_render_attribute( '_wrapper', [
      'class' => [
        'background-parallax',
      ],
      'data-plugin-options' => json_encode($pluginOptions),
    ]);
  }
}