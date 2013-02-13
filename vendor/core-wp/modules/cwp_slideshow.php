<?php

/**
 * Description of cwp_slideshow
 *
 * @author Studio365
 */
class cwp_slideshow {
    //put your code here

    public function __construct() {
        $this->post_type();
    }

    public function post_type(){
        $type = new cwp_post_type('slide');
        $type->set_publicly_queryable(false)
                ->set_capability_type('slide')
                ->set_public(false)
                ->set_menu_title("Slider Settings")
                ->set_hierarchical(true)
                ->set_supports(array('title','excerpt','custom-fields','thumbnail'))
                ->set_map_meta_cap(true)
                ->register();
    }


}

