<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings           = array(
  'menu_title'      => 'Form 2 Airtable',
  'menu_type'       => 'menu', // menu, submenu, options, theme, etc.
  'menu_slug'       => 'wp2air-settings',
  'ajax_save'       => false,
  'show_reset_all'  => false,
  'show_all' => true,
  'framework_title' => 'Form 2 Airtable <small>by Samjco</small>',
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options        = array();

// ----------------------------------------
// a option section for options overview  -
// ----------------------------------------
if ((cs_get_option('airtable_key')) && (cs_get_option('base_key')) && (cs_get_option('table_name'))):
$url ="https://api.airtable.com/v0/".cs_get_option('base_key')."/".cs_get_option('table_name')."?api_key=".cs_get_option('airtable_key')."&maxRecords=1";
$column_names = array();
// $arrJson  = array();
$drilled_arrJson = array();

$st = ini_get("default_socket_timeout"); // backup current value
ini_set("default_socket_timeout", 5000); // 5 seconds

$data = file_get_contents($url); 
if($data === false) {
    // error handling
}

ini_set("default_socket_timeout", $st); // restore previous value


$arrJson = json_decode($data, true);
$drilled_arrJson = $arrJson['records'][0]['fields'];

foreach($drilled_arrJson as $key => $val):

    $column_names[ $key ] = $key; 

endforeach;

else:

$column_names = "Please Connect to AirTable first";

endif;

$pagelist = array();
//$all_pages = wp_list_pages( array( 'sort_column' => 'menu_order' ) );
  $all_pages = get_pages(); 
  foreach ( $all_pages as $page ) {

    $pagelist[$page->post_title] = $page->post_title . " (".$page->ID.")";

  }
//var_dump($page);
// print_r($all_pages);
//die();


$field_id ="no id";
if (cs_get_option('field_label')):
  $field_id = str_replace(" ", "-", cs_get_option('field_label'));
endif;



$options[]      = array(
  'name'        => 'general',
  'title'       => 'General',
  'icon'        => 'fa fa-star',

  // begin: fields
  'fields'      => array(

array(
  'id'      => 'airtable_key', // another unique id
  'type'    => 'text',
  'title'   => 'Airtable API Key',
  'desc'    => 'Enter your AirTable Key',
  'validate' => true,
  // 'help'    => 'Write something',
  'default' => 'keymFTtatXs5X8DoA',
),    // end: a field
array(
  'id'      => 'base_key', // another unique id
  'type'    => 'text',
  'title'   => 'Airtable Base Key',
  'desc'    => 'Enter your Base Key',
  // 'help'    => 'Write something',
  'default' => 'app8xDuU5NS817XnM',
),    // end: a field
array(
  'id'      => 'table_name', // another unique id
  'type'    => 'text',
  'title'   => 'Airtable Table Name',
  'desc'    => 'Enter the table name you are submitting to.',
  // 'help'    => 'Write something',
  'default' => 'WP2AIRFORM',
),    // end: a field
// array(
//   'id'              => 'columns_names',
//   'type'            => 'group',
//   'title'           => 'Airtable Column Name(s)',
//   'button_title'    => 'Add New Column',
//   'desc'    => 'Add Column Name(s)',
//   'accordion_title' => cs_get_option( 'col_name' ),
//   'fields'          => array(
//           array(
//             'id'      => 'col_name', // another unique id
//             'type'    => 'text',
//             'title'   => 'Column Name',
//             'desc'    => 'Enter a Column Name',
//             // 'help'    => 'Write something',
//             'default' => '',
//             'debug' => true,
//           ),    // end: a field
//   ),
// ),
          array(
            'id'    => 'cf_enable',
            'type'  => 'switcher',
            'title' => 'Use Caldera Forms',
            'label' => 'Do you want to it ?',
          ),
          array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => 'Info coming soon about Caldera Forms.',
            'dependency' => array( 'cf_enable', '==', 'true' ) // dependency
          ),
          array(
            'id'      => 'primary_email', // another unique id
            'type'    => 'text',
            'title'   => 'Primary Email',
            'desc'    => 'Enter your Primary Email',
            'default' => 'samjco@gmail.com',
            'dependency' => array( 'cf_enable', '==', 'false' ), // dependency
          ),    // end: a field
          array(
            'id'              => 'secondary_emails',
            'type'            => 'group',
            'title'           => 'Secondary Email Address',
            'button_title'    => 'Add New Email',
            'desc'    => 'Add Secondary Email(s)',
            'dependency' => array( 'cf_enable', '==', 'false' ), // dependency
            'accordion_title' => cs_get_option( 'secondary_email' ),
            'fields'          => array(
                    array(
                      'id'      => 'secondary_email', // another unique id
                      'type'    => 'text',
                      'title'   => 'Secondary Email',
                      'desc'    => 'Enter your Secondary Email',
                      // 'help'    => 'Write something',
                      'default' => '',
                      // 'debug' => true,
                    ),    // end: a field
                ),
              ),
          array(
            'id'      => 'redirect_page', // another unique id
            'type'    => 'select',
            'title'   => 'Redirect to Page',
            'desc'    => 'Select Page to redirect to on submission.',
            // 'help'    => 'Write something',
            'default' => '',
            'dependency' => array( 'cf_enable', '==', 'false' ), // dependency
            'options' => $pagelist,
          ),    // end: a field
          array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => '<center>Add Shortcode <strong>[WP2AIR_FORM_PROCESS type="default"]</strong> to Redirected page ('.cs_get_option( 'redirect_page' ).')</center>',
            'dependency' => array( 'cf_enable', '==', 'false' ), // dependency
          ),         

    ),
);


$options[]      = array(
  'name'        => 'form_fields',
  'title'       => 'Form Builder',
  'icon'        => 'fa fa-star',

  // begin: fields
  'fields'      => array(
          array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => 'You have select to use Calderaforms. Please follow the instructions on the General tab.',
            'dependency' => array( 'cf_enable', '==', 'true' ) // dependency
          ),
          array(
            'type'    => 'notice',
            'class'   => 'info',
            'content' => '<center>Add Shortcode <strong>[WP2AIR_FORM]</strong> to your desired page to show form</center> ',
            'dependency' => array( 'cf_enable', '==', 'false' ) // dependency
          ),

    array (
      'id' => 'field_logic',
      'type' => 'group',
      // 'title' => 'Add fields',
      'button_title' => 'Add New',
      'accordion_title' => cs_get_option('field_type'),
      // 'debug' =>true,
      'dependency' => array( 'cf_enable', '==', 'false' ), // dependency
      'fields' => 
            array (
                array (
                  'id' => 'field_label',
                  'type' => 'text',
                  'title' => 'Field Label',
                ),
                array (
                  'id' => 'field_type',
                  'type' => 'select',
                  'title' => 'Select field type',
                  'options'    => array(
                      'text'    => 'Text',
                      'textarea'  => 'TextArea',
                      'email'   => 'Email',
                      'phone'   => 'Phone',
                      'address'   => 'Address',
                      'city'   => 'City',
                      'state'   => 'State',
                      'zip'   => 'Zip',
                      'url'   => 'Url',
                  ),
                  'attributes' => array(
                    // 'multiple' => 'multiple',
                    // 'style'    => 'width: 125px; height: 125px;',
                  ),
                ),
                array (
                  'id' => 'field_desc',
                  'type' => 'text',
                  'title' => 'Field Description',
                ),
                array (
                  'id' => 'field_required',
                  'type' => 'switcher',
                  'title' => 'Required',
                ),
                array (
                  'id' => 'col_name',
                  'type' => 'select',
                  'title' => 'Attach to AirTable Column Name',
                  'options' => $column_names
                ),
          ),

    )

  ), // end: fields


);



// ------------------------------
// backup                       -
// ------------------------------
$options[]   = array(
  'name'     => 'backup_section',
  'title'    => 'Backup & Restore',
  'icon'     => 'fa fa-shield',
  'fields'   => array(

    array(
      // 'debug'   => true,
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => 'You can save your current options. Download a Backup and Import.',
    ),

    array(
      // 'debug'   => true,
      'type'    => 'backup',
    ),

  )
);


CSFramework::instance( $settings, $options );



