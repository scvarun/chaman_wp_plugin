<?php

namespace ChamanAddons\ElementorAddons\Widgets;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

use UnifatoAddons\ElementorAddons\Controls\Groups;
use \Elementor\Widget_Base;

abstract class ChamanBaseWidget extends Widget_Base {

  /**
   * Register fields/controls of widget.
   * 
   * Adds section, tabs and controls/fields and customize widget settings.
   *
   * @since 1.0.0
   *
   * @access protected
   *
   * @return array Widget categories.
   */
  protected function _register_controls_parent() {
    $this->start_controls_section(
      'custom_css_section',
      [
        'label' => __('Custom CSS', 'unifato_addons'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );


		$this->add_control(
			'custom_css',
			[
				'label' => __( 'Custom CSS', 'unifato_addons' ),
        'description' => __('Use <span style="color: red">[SELECTOR]</span> to target selector. <br/><br/> <i>Example:</i> <br /><pre style="font-style: normal">[SELECTOR] a {<br />  color: red;<br />}</pre>', 'unifato_addons'),
        'default' => '',
				'type' => \Elementor\Controls_Manager::CODE,
				'language' => 'css',
				'rows' => 20,
			]
		);

    $this->end_controls_section();

    $this->start_controls_section(
      'additional_style_section',
      [
        'label' => __('Additional Style', 'unifato_addons'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'white_skin',
      [
        'label' => __('White Skin?', 'unifato_addons'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => __( 'Yes', 'unifato_addons' ),
        'label_off' => __( 'No', 'unifato_addons' ),
        'return_value' => 'text-white',
        'default' => 'no',
        'dynamic' => [
          'active' => true
        ],
        'prefix_class' => '',
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Prints output to frontend
   * 
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function _render_parent() {
    $settings = $this->get_settings_for_display();
    $selector = $this->get_unique_selector();

    if( strlen( $settings['custom_css'] ) > 0 ) {
      ?>
        <style scoped>
          <?php 
            echo str_replace( '[SELECTOR]', $selector, $settings['custom_css'] );
          ?>
        </style>
      <?php
    }
  }

  /**
   * Prints output to Elementor Editor
   * 
   * Written in HTML and Backbone.js MarionetteJS Template Engine.
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function _content_template_parent() {
    ?>
      <#
        var selector = '<?php echo $this->get_unique_selector(); ?>' + id; 
        var css = settings.custom_css;
      #>
      <# if( css.length > 0 ) { #>
      <style scoped>{{ css.replace('[SELECTOR]', selector) }}</style>
      <# } #>
    <?php
  }
  
}
