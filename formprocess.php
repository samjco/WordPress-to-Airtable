<?php

function PROCESS_WP2AIR_FORM( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'type' => 'default',
            'redirect' => '',
            'success_message' =>'',
            'error_message' => '',
        ),
        $atts,
        'WP2AIR_FORM_PROCESS'
    );


  if ($atts['type']=='default'):


          // Show Preview of submission
       ?>   
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>  
      
      <?php

        echo '<table class="table"><caption>Form Submitted Data</caption><tbody>';

          foreach($_POST as $key=>$value):
           $key = str_replace("-", " ", $key);
           echo '<tr><th scope="row">'.$key.':</th><td>'.$value.'</td></tr>';
           $formvalues[] = $value;
          endforeach;

        echo '</tbody></table>';



        //$tablenames = array();
        $values = cs_get_option('field_logic');
        foreach($values as $val):
          $tablenames[] = $val['col_name'];
        endforeach;

        if(count($tablenames) == count($formvalues)) {
            $result = array_combine($tablenames, $formvalues);
        }

        //Move results to AirTable
        $data = array(
            "fields" => $result
        );
        $url ="https://api.airtable.com/v0/".cs_get_option('base_key')."/".cs_get_option('table_name')."?api_key=".cs_get_option('airtable_key');
        $data_json = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);

        //Show if data was uploaded to Airtable
        //echo $result;

  else: 

    //Caldera Forms data
     echo "Hooray!";

  endif;

$semails = cs_get_option('secondary_emails');
//var_dump(cs_get_option('secondary_emails'));
if (cs_get_option('secondary_emails')):
  foreach ($semails as $value) { 
     $other_recipients[] = $value['secondary_email'].",";
  }
endif;
$other_recipients = implode(" ",$other_recipients);

// print_r($other_recipients);
if (cs_get_option('primary_email')):
$multiple_recipients = array(
    cs_get_option('primary_email').",",
    $other_recipients

);

$multiple_recipients = implode(" ",$multiple_recipients);
//$to = 'emailsendto@example.com';
$subject = 'New Submission to AirTable';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8','From: My Site Name &lt;'.cs_get_option('primary_email'));
  
wp_mail($multiple_recipients, $subject, $body, $headers );

echo "A notification was sent to: ".$multiple_recipients ."";

endif;



};
add_shortcode( 'WP2AIR_FORM_PROCESS', 'PROCESS_WP2AIR_FORM' );

