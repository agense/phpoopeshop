<?php 
class FH{
// FORM HELPER CLASS
// CREATES HTML FOR FORM INPUTS DYNAMICALLY
// DISPLAYS FORM ERRORS
// SETS AND CHECKS CSRF TOKENS

  // RETURN HTML FOR ERROR DISPLAY
  // Requires an array of errors
  // Returns an html 
  public static function displayErrors($errors){
    $hasErrors = (!empty($errors) && $errors != null) ? ' has errors' : '';
    $html = '<div class="form-errors"><ul class="bg-danger '.$hasErrors.'">';
    if($hasErrors){
      foreach($errors as $field => $error){
        $html.= '<li>'.$error.'</li>';
        $html .= '<script>jQuery(document).ready(function(){ jQuery("#'.$field.'").parent().closest("div").addClass("has-error");});</script>';
      }
    }
    $html .= '</ul></div>';
    return $html;
  }

  // CROSS SITE SCRIPT PROTECTION

  // RETURN A CSRF TOKEN
  // Generates and returns a random token string and sets it in the session
  public static function generateToken(){
    $token = base64_encode(openssl_random_pseudo_bytes(32));
    Session::set('csrf_token', $token);
    return $token;
  }  

  // RETURN HTML CODE FORM CSRF TOKEN INPUT CREATION
  // Creates a hidden form input with token
  // Returns html 
  public static function csrfInput(){
      return '<input type="hidden" name="csrf_token" id="csrf_token" value="'.self::generateToken().'" />';
  }

  // RETURN CSRF TOKEN CHECK RESULT
  // Accepts a token string as argument
  // Checks if a token exists in a session and if its value corresponds to the value passed as argument.
  // Returns boolean true or false
  public static function checkToken($token){
    return (Session::exists('csrf_token') && Session::get('csrf_token') == $token);
  } 

  // HELPER METHOD - STRINGITIES  ATTRIBUTE ARRAYS
  // Convert attribute arrays to strings
  // Returns a string of attributes
  public static function stringifyAttrs(array $attrs){
    $attrString = '';
    foreach($attrs as $key => $val){
      $attrString .= ' '.$key.' = "'.$val.'"';
    }
    return $attrString;
  }  

  // FORM FIELD CREATION METHODS

  // SUBMIT BUTTON
  // Required Arguments: button text(string)
  // Optional Arguments: button tag attributes(assoc array)
  // Returns html
  /* Usage Syntax: 
     FH::submitTag('Save', ['class'=>'btn btn-success']); 
  */
  public static function submitTag(string $buttonTxt, $inputAttrs = []){
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<input type="submit" value="'.$buttonTxt.'" '.$inputString.'/>';
    return $html;
  }

  // SUBMIT BLOCK - A SUBMIT BUTTON IN A DIV HOLDER TAG
  // Required Arguments: button text(string)
  // Optional Arguments: button tag attributes(assoc array), holders(div tag) attributes(assoc array)
  // Returns html
  /* Usage Syntax: 
     FH::submitBlock('Save', ['class'=>'btn btn-success'], ['class'=>'form-group']); 
  */
  public static function submitBlock(string $buttonTxt, $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);	
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    $html.= '<input type="submit" value="'.$buttonTxt.'" '.$inputString.'/>';
    $html .= '</div>';
    return $html;
  }

  // INPUT FIELD
  // Returns html
  // Required Arguments: input type(string), label name(string), field name(string)
  // Optional Arguments: field value(string), input tag attributes(assoc array), input holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax: 
      FH::inputBlock('text', 'First Name', 'first_name', '', ['class'=>'form-control'], ['class'=>'form-group']); 
  */
  public static function inputBlock($type, $label, $name, $value='', $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);	
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div'.$divString.'>';
    $html .= '<label for="'.$name.'">'.$label.'</label>';
    $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'" '.$inputString.'/>';
    $html .= '</div>';
    return $html;
  }

  // TEXTAREA FIELD
  // Returns html
  // Required Arguments: field name(string)
  // Optional Arguments: field value(string), label name(string), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax: 
     FH::textAreaBlock('comments', 'comments', 'Your Comments', ['class' => 'form-control'], ['class' => 'form-group'])
  */
  public static function textAreaBlock($name, $value='', $label = '', $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    if($label){
      $html .= '<label for="'.$name.'">'.$label.'</label>';
    }
    $html .= '<textarea name="'.$name.'" id="'.$name.'" ' .$inputString.' >'.$value.'</textarea>';
    $html .= '</div>';
    return $html;
  }

  // FILE UPLOAD FIELD
  // Returns html
  // Required Arguments: none
  // Optional Arguments: field name(string), label name(string), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax: 
     FH::uploadBlock('image', 'Featured Image', ['class' => 'form-control'], ['class' => 'form-group']);
  */
  public static function uploadBlock($name = 'file', $label = '', $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    if($label){
      $html .= '<label for="'.$name.'">'.$label.'</label>';
    }
    $html.= '<input type="file" name="'.$name.'" id="'.$name.'" '.$inputString.'>';
    $html .= '</div>';
    return $html;
  }

  // MULTIPLE FILES UPLOAD FIELD
  // Returns html
  // Required Arguments: none
  // Optional Arguments: field name(string), label name(string), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax: 
     FH::uploadMultipleBlock('images', 'Upload New Images', ['class' => 'form-control'], ['class' => 'form-group']);
  */
  public static function uploadMultipleBlock($name = 'file', $label = '', $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    if($label){
      $html .= '<label for="'.$name.'">'.$label.'</label>';
    }
    $html.= '<input type="file" name="'.$name.'[]" multiple id="'.$name.'" '.$inputString.'>';
    $html .= '</div>';
    return $html;
  }

  // SELECT FIELDS

  // AN EMPTY SELECT FIELD
  // Returns html
  // Required Arguments: field name(string)
  // Optional Arguments: label name(string), multiple selections(true/false), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax: 
     FH::emptySelect('category', 'Category', false, ['class' => 'form-control'], ['class' => 'form-group'])
  */
  public static function emptySelect($name, $label = '', $multiple = false, $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    if($label){
      $html .= '<label for="'.$name.'">'.$label.'</label>';
    }
    if($multiple){
      $html .= '<select name="'.$name.'[]" multiple="multiple" id="'.$name.'" '.$inputString.'>';
    }else{
      $html .= '<select name="'.$name.'" id="'.$name.'" '.$inputString.'>';
    }
    $html .= '</select></div>';
    return $html;
  }

  // A SELECT FIELD WITH OPTIONS
  // Returns html
  // Requires an associative array of arguments with predefined keys(key names are specified in parenthesis here below): 
  /**Required arguments:
      * ('name') - field name
   *Optional arguments(can be omitted without restrictions):
      * ('label') - label name,
      * ('options') - an associative array of options for select options creation,
      * ('preselect') - a value(string) or an array of values of select option fields that should be preselected by default,
      * ('multiple') - allow multiple selections - value should be true or this key should be omitted,
      * ('empty') - create an empty option in select list - value should be true or this key should be omitted
      * ('input_attrs') - an associative array of select tag attributes,
      * ('div_attrs') - an associative array of holder div tag attributes. 
  */
  /* Usage Syntax: 
    FH::selectionBlock([
        'name' => 'featured',
        'label' => 'Featured Product',
        'options' => ['No'=>'0','Yes'=>'1'],
        'preselect' => ['No'],
        'input_attrs' => ['class' => 'form-control'],
        'div_attrs' => ['class' => 'form-group']
 		]);
  */
  public static function selectionBlock($params){ 
    if($params){
        // Set input name and label
        $name = (array_key_exists('name', $params)) ? $params['name'] : '';
        $label = (array_key_exists('label', $params)) ? $params['label']: '';  
        // Set holder div attibutes if exist
        if(array_key_exists('div_attrs', $params) && is_array($params['div_attrs'])){
            $divString = self::stringifyAttrs($params['div_attrs']);  
        }else{
            $divString = null;
        }
        // Set select tag attibutes if exist
        if(array_key_exists('input_attrs', $params) && is_array($params['input_attrs'])){
            $inputString = self::stringifyAttrs($params['input_attrs']);
        }else{
            $inputString = null;
        }
        // Set preselected items into an array
        $seletedArr = '';
        if(array_key_exists('preselect', $params)){
          if(is_array($params['preselect'])){
              $seletedArr = $params['preselect'];
          }elseif(is_string($params['preselect'])){
              // If preselect is a string, convert it into an array
              $seletedArr = ["{$params['preselect']}"];
          }else{
              $seletedArr = '';
          }
        }
        // Build option list
        $optionList = '';
        if(array_key_exists('options', $params) && is_array($params['options'])){
          foreach($params['options'] as $key => $value){
            if($seletedArr && in_array($value, $seletedArr)){
              $selected = 'selected="selected"';
            }else{
              $selected = "";
            }
          $optionList .= '<option value="'.$value.'" '.$selected.' >'.$key.'</option>';
          }  
        }
      $html = '<div '.$divString.'>';
      // Add a label if required
        if($label){
          $html .= '<label for="'.$name.'">'.$label.'</label>';
        }
        // Check if it is a multiple select or not and create select tag
        if(array_key_exists('multiple', $params) && ($params['multiple'] == true)){
          $html .= '<select name="'.$name.'[]" multiple="multiple" id="'.$name.'" '.$inputString.'>';
        }else{
          $html .= '<select name="'.$name.'" id="'.$name.'" '.$inputString.'>';
        }
        // Add an empty option if required
        if(array_key_exists('empty', $params)){
          $html .= '<option value="" selected="selected">...</option>';
        }
        // Add options to select tag
        $html .= $optionList;
        $html .= '</select></div>';
        return $html;
    }
  }

  // RADIO BUTTONS

  // A SINGLE RADIO BUTTON
  // Returns html
  // Required Arguments: field name(string), field value(string)
  // Optional Arguments: checked(true/false), field label(string), tag attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax:
     FH::radioButton('featured', '1', true, 'Yes', ['class' => 'form-control']);
     FH::radioButton('featured', '0', false, 'No', ['class' => 'form-control']);
  */
  public static function radioButton($name, $value, $check ='false', $label='', $inputAttrs = []){
    $inputString = self::stringifyAttrs($inputAttrs);
    $checked = ($check == true) ? 'checked="checked"' : ''; 
    $html = '<input type="radio" name="'.$name.'" id="'.$name.'" value="'.$value.'" '.$checked.' '.$inputString.' >';
    if($label){
      $html .= ' <label for="'.$name.'">'.$label.'</label> ';
    }
    return $html;
  }

  // RADIO BUTTON BLOCK
  // Returns html
  // Creates a group of radio buttons.
  // Required Arguments: field name(string), radio buttons to be created (assoc array('field label' => 'field value'))
  // Optional Arguments: checked(true/false), field label(string), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax:
     FH:: radioButtonBlock('featured', ['Yes' => '1', 'No' => '0'], 'no', [], ['class' => 'form-group']);
  */
  public static function radioButtonBlock($name, $buttons = [], $checked='', $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $html = '<div '.$divString.'>';
    if($buttons){
      foreach($buttons as $key => $value){
        $check = '';
        $check = (strcmp(strtolower($key), strtolower($checked)) == 0) ? 'checked="checked"' : '' ;
        $html .= '<input type="radio" name="'.$name.'" id="'.$name.'_'.strtolower($key).'" value="'.$value.'" '.$check.' '.$inputString.' >';
        $html .= ' <label for="'.$name.'_'.strtolower($key).'">'.$key.'</label> ';
      }
    }
    $html .= '</div>';
    return $html;
  }

  //CHECKBOX FIELDS

  // SINGLE CHECKBOX
  // Returns html
  // Required Arguments: field label(string), field name(string)
  // Optional Arguments: checked(true/false), tag attributes(assoc array), holders(div) attributes(assoc array)
  /* !!! Note, all arguments are in predefined order, if any of the optional arguments that are in between other 
        arguments are omitted, they must be replaced by an empty string or array (as required by argument type)
  */
  /* Usage Syntax:
     FH::checkboxBlock('Featured Item', 'featured', true, ['class' => 'form-control', ['class' => 'form-group']);
  */
  public static function checkboxBlock($label, $name, $checked=false, $inputAttrs = [], $divAttrs = []){
    $divString = self::stringifyAttrs($divAttrs);  
    $inputString = self::stringifyAttrs($inputAttrs);
    $checkString = ($checked) ? 'checked = "checked"': '';
    $html = '<div '.$divString.'>';
    $html.= '<label for="'.$name.'">'.$label.' ';
    $html .='<input type="checkbox" name="'.$name.'" id="'.$name.'" value="on" '.$checkString.' '.$inputString.' />';
    $html .= '</label></div>';
    return $html;
  }

  // RELATED CHECKBOX BLOCK
  // Returns html
  // Requires an associative array of arguments with predefined keys(key names are specified in parenthesis here below): 
  /**Required arguments:
      * ('name') - field name,
      * ('checkboxes') - assoc array of checkboxes to be created, where keys represent each checkboxes label, and values represent each checkboxes value
   *Optional arguments (can be omitted without restrictions):
      * ('checked') - a value(string) or an array of values of checkboxes that should be checked by default,
      * ('multiple') - allow multiple checkbox check - value should be true or this key should be omitted,
      * ('input_attrs') - an associative array of checkbox tag attributes,
      * ('div_attrs') - an associative array of holder div tag attributes,
      * ('label_add_txt') - an associative array with additional text to be appended to each checkboxes label, where 
        * each array element's key must match the value of the checkbox to the label of whichwe want to append  
        * the additional text. The value of that array element must be the text to be appended.
        * !!!Note, additional label text can also be a multidimentional array, where each elements value is an array.
  */
  /** Usage example
  *   FH::groupedCheckboxBlock([
     * 'name' => 'collections',
     * 'checkboxes' => ['Collection One' => 'collection_1', 'Collection Two' => 'collection_2', 'Collection Three' => 'collection_3'],
     * 'checked' => ['collection_1', 'collection_2'], //or 'checked' => 'collection_2',
     * 'multiple' => true,
     * 'input_attrs' => ['class' => 'checkbox-in-block'],
     * 'div_attrs' => ['class' => 'form-group'],
     * 'label_add_txt' => ['collection_1' => 'Additional text for collection one', 'collection_2' => 'Additional text for collection two'  ] 
     * ]); 
  **/
  public static function groupedCheckboxBlock($params){
    if($params){
      // Set the field name
      $name = (array_key_exists('name', $params)) ? $params['name'] : '';
      // Set holder div attributes
      if(array_key_exists('div_attrs', $params) && is_array($params['div_attrs'])){
          $divString = self::stringifyAttrs($params['div_attrs']);  
      }else{
          $divString = null;
      }
      // Set checkbox attributes
      if(array_key_exists('input_attrs', $params) && is_array($params['input_attrs'])){
          $inputString = self::stringifyAttrs($params['input_attrs']);
      }else{
          $inputString = null;
      }
      // Set the checked checkboxes
      $check = [];
      if(array_key_exists('checked', $params)){
        if(is_array($params['checked'])){
          $check = array_map('strtolower', $params['checked']);
        }elseif(is_string($params['checked'])){
          $conv = strtolower($params['checked']);
          $check = ["{$conv}"];
        }else{
          $check = '';
        }
      }
      // Build html
      $html = '<div '.$divString.'>';
      if(array_key_exists('checkboxes', $params) && is_array($params['checkboxes'])){
        foreach($params['checkboxes'] as $label => $value){
        if($check && in_array(strtolower($value), $check)){
            $checked = 'checked="checked"'; 
        }else{
            $checked = '';
        } 
        $html .= ' <label for="'.$name.'_'.strtolower($value).'" '.$inputString.'>';
        if(array_key_exists('multiple', $params) && $params['multiple'] == true){
        $html .= '<input type="checkbox" name="'.$name.'[]" id="'.$name.'_'.strtolower($value).'" value="'.$value.'" '.$checked.'>';
        }else{
        $html .= '<input type="checkbox" name="'.$name.'" id="'.$name.'_'.strtolower($value).'" value="'.$value.'" '.$checked.'>';
        }
        $html.= ' <span>'.ucwords($label).'</span>';
        // If additional texts exists for label, add that to the label
        if(array_key_exists('label_add_txt', $params) && is_array($params['label_add_txt'])){
            foreach($params['label_add_txt'] as $labelkey => $labelvalue){
            // Check if the key of the array is the same as option value
              if($labelkey == $value){
                  if(is_array($labelvalue)){
                      foreach( $labelvalue as $txtname => $txtvalue){
                        $html .= ' <span>'.$txtname.' '.$txtvalue.'</span>';
                      }
                  }elseif(is_string($labelvalue)){
                        $html .= '<span>'.$labelvalue.'</span>';
                  }
              }
            }
        }
        $html .= '</label> ';
        }
      }
      $html .= '</div>';
      return $html;
  }
  return false;
  } 


}
