<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Extended
 *
 * @author studio
 */


include_once dirname(__FILE__).'/class-usage-demo.php';


class Metabox_Extended extends AT_Meta_Box {

    public function __construct($meta_box) {

        parent::__construct($meta_box);

    }


  /**
   * Show Repeater Fields.
   *
   * @param string $field
   * @param string $meta
   * @since 1.0
   * @access public
   */
  public function show_field_repeater( $field, $meta ) {
    global $post;
    // Get Plugin Path
    $plugin_path = $this->SelfPath;
    $this->show_field_begin( $field, $meta );
    $class = '';
      if ($field['sortable'])
        $class = " repeater-sortable";
    echo "<div class='at-repeat".$class."' id='{$field['id']}'>";

    $c = 0;
    $meta = get_post_meta($post->ID,$field['id'],true);

      if (count($meta) > 0 && is_array($meta) ){
         foreach ($meta as $me){
           //for labling toggles
           $mmm =  isset($me[$field['fields'][0]['id']])? $me[$field['fields'][0]['id']]: "";
           echo '<div class="at-repater-block">'.$mmm.'<br/><table class="repeater-table" style="display: none;">';
           if ($field['inline']){
             echo '<tr class="at-inline" VALIGN="top">';
           }
        foreach ($field['fields'] as $f){
          //reset var $id for repeater
          $id = '';
          $id = $field['id'].'['.$c.']['.$f['id'].']';
          $m = isset($me[$f['id']]) ? $me[$f['id']]: '';
          $m = ( $m !== '' ) ? $m : $f['std'];
          if ('image' != $f['type'] && $f['type'] != 'repeater')
            $m = is_array( $m) ? array_map( 'esc_attr', $m ) : esc_attr( $m);
          //set new id for field in array format
          $f['id'] = $id;
          if (!$field['inline']){
            echo '<tr>';
          }
          call_user_func ( array( &$this, 'show_field_' . $f['type'] ), $f, $m);
          if (!$field['inline']){
            echo '</tr>';
          }
        }
        if ($field['inline']){
          echo '</tr>';
        }
        echo '</table>
        <span class="at-re-toggle"><img src="';
           if ($this->_Local_images){
             echo $plugin_path.'/images/edit.png';
           }else{
             echo 'http://i.imgur.com/ka0E2.png';
           }
           echo '" alt="Edit" title="Edit"/></span>
        <img src="';
        if ($this->_Local_images){
          echo $plugin_path.'/images/remove.png';
        }else{
          echo 'http://i.imgur.com/g8Duj.png';
        }
        echo '" alt="'.__('Remove','mmb').'" title="'.__('Remove','mmb').'" id="remove-'.$field['id'].'"></div>';
        $c = $c + 1;

        }
      }

    echo '<img src="';
    if ($this->_Local_images){
      echo $plugin_path.'/images/add.png';
    }else{
      echo 'http://i.imgur.com/w5Tuc.png';
    }
    echo '" alt="'.__('Add','mmb').'" title="'.__('Add','mmb').'" id="add-'.$field['id'].'"><br/></div>';

    //create all fields once more for js function and catch with object buffer
    ob_start();
    echo '<div class="at-repater-block"><table class="repeater-table">';
    if ($field['inline']){
      echo '<tr class="at-inline" VALIGN="top">';
    }
    foreach ($field['fields'] as $f){
      //reset var $id for repeater
      $id = '';
      $id = $field['id'].'[CurrentCounter]['.$f['id'].']';
      $f['id'] = $id;
      if (!$field['inline']){
        echo '<tr>';
      }
      if ($f['type'] != 'wysiwyg')
        call_user_func ( array( &$this, 'show_field_' . $f['type'] ), $f, '');
      else
        call_user_func ( array( &$this, 'show_field_' . $f['type'] ), $f, '',true);
      if (!$field['inline']){
        echo '</tr>';
      }
    }
    if ($field['inline']){
      echo '</tr>';
    }
    echo '</table><img src="';
    if ($this->_Local_images){
      echo $plugin_path.'/images/remove.png';
    }else{
      echo 'http://i.imgur.com/g8Duj.png';
    }
    echo '" alt="'.__('Remove','mmb').'" title="'.__('Remove','mmb').'" id="remove-'.$field['id'].'"></div>';
    $counter = 'countadd_'.$field['id'];
    $js_code = ob_get_clean ();
    $js_code = str_replace("\n","",$js_code);
    $js_code = str_replace("\r","",$js_code);
    $js_code = str_replace("'","\"",$js_code);
    $js_code = str_replace("CurrentCounter","' + ".$counter." + '",$js_code);
    echo '<script>
        jQuery(document).ready(function() {
          var '.$counter.' = '.$c.';
          jQuery("#add-'.$field['id'].'").live(\'click\', function() {
            '.$counter.' = '.$counter.' + 1;
            jQuery(this).before(\''.$js_code.'\');
            update_repeater_fields();
          });
              jQuery("#remove-'.$field['id'].'").live(\'click\', function() {
                  jQuery(this).parent().remove();
              });
          });
        </script>';
    echo '<br/><style>
.at-inline{line-height: 1 !important;}
.at-inline .at-field{border: 0px !important;}
.at-inline .at-label{margin: 0 0 1px !important;}
.at-inline .at-text{width: 70px;}
.at-inline .at-textarea{width: 100px; height: 75px;}
.at-repater-block{background-color: #FFFFFF;border: 1px solid;margin: 2px;}
</style>';
    $this->show_field_end($field, $meta);
  }

}