<?php

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

class Sample_Control extends \Elementor\Base_Data_Control {

  /**
   * Return the type of control
   *
   * Returns the name by which it is identified in Elementor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function get_type() {
    return 'Chaman_sample';
  }

  /**
   * Returns default value
   *
   * @since 1.0.0
   *
   * @access protected
   */
  public function get_default_value() {
    return '';
  }

  /**
   * Returns default settings
   *
   * @since 1.0.0
   *
   * @access protected
   */
  protected function get_default_settings() {
    return [
    ];
  }

  /**
   * Enqueue the files required
   *
   * Files are enqueued in Elementor Editor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function enqueue() {
  }

  /**
   * Content Template of control
   *
   * Outputs the fields of control
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function content_template() {
    $control_uid = $this->get_control_uid();
    ?>
      <div class="elementor-control-field">
        <label for="<?php echo $control_uid; ?>" class="elementor-control-title">Sample Control</label>
        <div class="elementor-control-input-wrapper">
          <input type="text" id="<?php echo $control_uid; ?>" class="elementor-control-text" />
        </div>
      </div>

      <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
      <# } #>
    <?php
  }
}