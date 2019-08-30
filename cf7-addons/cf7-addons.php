<?php

namespace ChamanAddons\CF7_Addons;

// Prevent Data Leak
if ( !defined( 'ABSPATH') ) exit;

require_once CHAMAN_ADDONS_ROOT . '/vendor/autoload.php';

/**
 * Custom Posts for Chaman Theme
 *
 * The class that initiates and runs custom post types.
 *
 * @since 1.0.0
 */
class CF7_Addons {
  /**
   * Instance
   *
   * @since 1.0.0
   *
   * @access private
   * @static
   *
   * @var Chaman_Addons The single instance of the class.
   */
  private static $_instance = null;

  /**
   * Initialize CF7 Addons
   *
   * @since 1.0.0
   *
   * @access public
   */
  public static function instance() {
    if( is_null(self::$_instance) ) {
      self::$_instance = new self();
      return self::$_instance;
    }
  }

  /**
   * Constructor
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function __construct() {
    add_action( 'wpcf7_init', [ $this, 'add_form_tags' ] );
    add_action( 'wpcf7_admin_init', [ $this, 'admin_add_tag_generator'] );
    add_action( 'wpcf7_submit', [ $this, 'cf7_submit' ] );
    add_action( 'wpcf7_before_send_mail', [$this, 'cf7_before_send_mail'] );
  }

  /**
   * Add form tags
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function add_form_tags() {
    wpcf7_add_form_tag( 'unique_key', [ $this, 'custom_unique_key_form_tag_handler' ], true );
    wpcf7_add_form_tag( 'message_to_pdf', [ $this, 'custom_message_to_pdf_form_tag_handler' ], true );
  }


  public function admin_add_tag_generator() {
    $tag_generator = \WPCF7_TagGenerator::get_instance();
  }

  /**
   * Serial Id Tag
   *
   * @since 1.0.0
   *
   * @access public
   */
  public function custom_unique_key_form_tag_handler($tag) {
    $wpcf7 = \WPCF7_ContactForm::get_current();
    $formid = $wpcf7->id();
    $value = get_post_meta( $formid, "cf7_unique_key_COUNTER", true);
    if ($value == '') {
      $value = 100;
      update_post_meta( $formid, "cf7_unique_key_COUNTER", $value );
    }
    $value++;
    return '<input type="hidden" name="unique_key" id="unique_key" value="'.$value.'" />';
  }

  public function custom_message_to_pdf_form_tag_handler($tag) {
    return '<input type="file" name="message_to_pdf" />';
  }

  public function cf7_submit( $cf7 ) {
    foreach($cf7->scan_form_tags() as $tag) {
      if($tag->type == 'unique_key') {
        $this->cf7_submit_unique_key_render($cf7);
      }
    } 
    return $cf7;
  }

  public function cf7_submit_unique_key_render($cf7) {
    $value = get_post_meta( $cf7->id() , "cf7_unique_key_COUNTER", true) + 1;
    update_post_meta( $cf7->id() , "cf7_unique_key_COUNTER", $value );
  }

  public function cf7_before_send_mail($cf7) {
    if( strpos($cf7->prop('mail')['attachments'], '[message_to_pdf]') !== false ) {
      $location = wp_upload_dir()['path'] . '/admissionPDFs';
      $submission = \WPCF7_Submission::get_instance();
      $posted_data = $submission->get_posted_data();
      $html = '';
      $template = "<p><strong>%s</strong>: %s</p><br/>";
      foreach($posted_data as $key=>$val) {
        if(
          strpos($key, '_wpcf7') !== false ||
          strpos($key, 'unique_key') !== false
        )
          continue;
        $string = str_replace("_", " ", $key);
        $string = str_replace("-", " ", $key);
        $string = ucwords($string);
        $html .= sprintf($template, $string, $val);
      }
      $mpdf = new \Mpdf\Mpdf(['tempDir' => $location]);
      $mpdf->WriteHTML($html);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->Output($location . '/something.pdf', 'F');
      $submission->add_uploaded_file('message_to_pdf', $location . '/something.pdf');
    }

    return $cf7;
  }
}