<?php



function SHOW_WP2AIR_FORM( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'name' => 'Contact Form',
            'title' => 'Please Drop a Line.',
            'redirect' => '',
        ),
        $atts,
        'WP2AIR_FORM'
    );


if ($atts['redirect'] == "self"):
    $redirect = htmlspecialchars($_SERVER["PHP_SELF"]);
    echo do_shortcode('[WP2AIR_FORM_PROCESS]');
else:
    $redirect = get_permalink( get_page_by_title(cs_get_option( 'redirect_page' )));
    $redirect = str_replace(get_home_url(), "", $redirect);
    //echo $redirect;
endif;

 //var_dump(cs_get_option( 'field_logic' ));
$values = cs_get_option( 'field_logic' );
?>

<script src="https://code.jquery.com/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


<?
$field_req = "";
$formdata = '<form class="needs-validation" method="post" action="'.$redirect.'" novalidate >
  <div class="">';


foreach($values as $val):
$field_id = str_replace(" ", "-", $val['field_label']);
// if (in_array($val['field_required'], $values)):
if (array_key_exists('field_required', $val)):
$field_req = 'required';
$field_valid = '<div class="valid-feedback">'.$val['field_label'].' Looks good!</div>';
$field_invalid ='<div class="invalid-feedback">Please provide a valid entry.</div>';
else:
$field_req = '';
$field_valid = '';
$field_invalid ='';
endif;

//echo $val['field_label']. "<br>";

switch ($val['field_type']) {
    case "text":
        $formdata .=  '<div class="form-group">
      <label for="'.$field_id.'">'.$val['field_label'].'</label>
      <input type="text" class="form-control form-control-lg" name="'.$field_id.'" name="'.$field_id.'" id="'.$field_id.'" placeholder="'.$val['field_label'].'" value="" '.$field_req.'>
      '.$field_valid.'
      '.$field_invalid.'
    </div>';
        break;
    case "city":
        $formdata .= '<div class="row"><div class="form-group col-md-6">
      <label for="inputCity">'.$val['field_label'].'</label>
      <input type="text" class="form-control form-control-lg" name="'.$field_id.'" id="inputCity" placeholder="'.$val['field_label'].'" '.$field_req.'>
      '.$field_valid.'
      '.$field_invalid.'
    </div>';
        break;
    case "state":
        $formdata .= '<div class="form-group col-md-4">
     <label for="inputState">'.$val['field_label'].'</label>
      <select name="'.$field_id.'" id="inputState" class="custom-select form-control form-control-lg" '.$field_req.'>
    <option selected>Choose...</option>
    <option value="AL">Alabama</option>
    <option value="AK">Alaska</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
    <option value="CT">Connecticut</option>
    <option value="DE">Delaware</option>
    <option value="DC">District Of Columbia</option>
    <option value="FL">Florida</option>
    <option value="GA">Georgia</option>
    <option value="HI">Hawaii</option>
    <option value="ID">Idaho</option>
    <option value="IL">Illinois</option>
    <option value="IN">Indiana</option>
    <option value="IA">Iowa</option>
    <option value="KS">Kansas</option>
    <option value="KY">Kentucky</option>
    <option value="LA">Louisiana</option>
    <option value="ME">Maine</option>
    <option value="MD">Maryland</option>
    <option value="MA">Massachusetts</option>
    <option value="MI">Michigan</option>
    <option value="MN">Minnesota</option>
    <option value="MS">Mississippi</option>
    <option value="MO">Missouri</option>
    <option value="MT">Montana</option>
    <option value="NE">Nebraska</option>
    <option value="NV">Nevada</option>
    <option value="NH">New Hampshire</option>
    <option value="NJ">New Jersey</option>
    <option value="NM">New Mexico</option>
    <option value="NY">New York</option>
    <option value="NC">North Carolina</option>
    <option value="ND">North Dakota</option>
    <option value="OH">Ohio</option>
    <option value="OK">Oklahoma</option>
    <option value="OR">Oregon</option>
    <option value="PA">Pennsylvania</option>
    <option value="RI">Rhode Island</option>
    <option value="SC">South Carolina</option>
    <option value="SD">South Dakota</option>
    <option value="TN">Tennessee</option>
    <option value="TX">Texas</option>
    <option value="UT">Utah</option>
    <option value="VT">Vermont</option>
    <option value="VA">Virginia</option>
    <option value="WA">Washington</option>
    <option value="WV">West Virginia</option>
    <option value="WI">Wisconsin</option>
    <option value="WY">Wyoming</option>
</select>
      '.$field_valid.'
      '.$field_invalid.'
</div>';
        break;
    case "zip":
        $formdata .= '<div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control form-control-lg" name="'.$field_id.'" id="inputZip" placeholder="Zip" '.$field_req.'>
      '.$field_valid.'
      '.$field_invalid.'
    </div>
    </div> <!-- close row -->';
        break;
    case "address":
        $formdata .= '<div class="form-group">
      <label for="'.$field_id.'">'.$val['field_label'].'</label>
      <input type="text" class="form-control form-control-lg" name="'.$field_id.'" id="'.$field_id.'" placeholder="'.$val['field_label'].'" value="" '.$field_req.'>
      '.$field_valid.'
      '.$field_invalid.'
    </div>';
        break;
    case "phone":
        $formdata .= '<div class="form-group">
      <label for="'.$field_id.'">'.$val['field_label'].'</label>
      <input type="phone" class="form-control form-control-lg" name="'.$field_id.'" id="'.$field_id.'" placeholder="'.$val['field_label'].'" value="" '.$field_req.'>
      '.$field_valid.'
      '.$field_invalid.'
    </div>';
        break;
    case "textarea":
        $formdata .=  '  <div class="form-group">
    <label for="'.$field_id.'">'.$val['field_label'].'</label>
    <textarea class="form-control" name="'.$field_id.'" id="'.$field_id.'" rows="3"></textarea>
      '.$field_valid.'
      '.$field_invalid.'
  </div>';
        break;
    case "url":
        //$formdata .=  "Your favorite color is blue!";
        break;
    case "email":
        $formdata .=  '  <div class="form-group">
    <label for="'.$field_id.'">Email address</label>
    <input type="email" class="form-control form-control-lg" name="'.$field_id.'" id="'.$field_id.'" aria-describedby="emailHelp" placeholder="'.$val['field_label'].'">
    <small name="'.$field_id.'" id="emailHelp" class="form-text text-muted">We will never share your email with anyone else.</small>
      '.$field_valid.'
      '.$field_invalid.'
  </div>';


}



endforeach;

  $formdata .=  '</div>
    <button class="btn btn-primary" type="submit">Submit form</button>
  </form>';  

echo $formdata;
?>

  <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<?php
//die();

};
add_shortcode( 'WP2AIR_FORM', 'SHOW_WP2AIR_FORM' );



