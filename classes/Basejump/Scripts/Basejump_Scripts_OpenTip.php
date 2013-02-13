<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Basejump_Scripts_OpenTip
 *
 * @author studio
 */
class Sharre_Scripts_OpenTip extends Basejump_Abstracts_JSLoader {

    public function footer_scripts() {
        ob_start();
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){

            })
        </script>



        <?php

        return ob_get_clean();
    }

    public function head_scripts() {

    }

    public static function factory($scripts, $stylesheets = '') {
        $fc = new Sharre_Scripts_OpenTip();
        $fc->set_scripts($scripts);
        $fc->set_styles($stylesheets);
    }

}