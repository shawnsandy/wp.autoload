<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$key = "key";
$meta_boxes = array(
"image" => array(
"name" => "image",
"title" => "Image",
"description" => "Using the \"<em>Add an Image</em>\" button, upload an image and paste the URL here. Images will be resized. This is the Article's main image and will automatically be sized."),
"tinyurl" => array(
"name" => "tinyurl",
"title" => "Tiny URL",
"description" => "Add a small URL of this post that will be used to track tweets, and share the post.")
);

function create_meta_box() {
global $key;

if( function_exists( 'add_meta_box' ) ) {
add_meta_box( 'new-meta-boxes', ucfirst( $key ) . ' Custom Post Options', 'display_meta_box', 'post', 'normal', 'high' );
}
}

function display_meta_box() {
global $post, $meta_boxes, $key;
?>

<div class="form-wrap">

<?php
wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );

foreach($meta_boxes as $meta_box) {
$data = get_post_meta($post->ID, $key, true);
?>

<div class="form-field form-required">
<label for="<?php echo $meta_box[ 'name' ]; ?>"><?php echo $meta_box[ 'title' ]; ?></label>
<input type="text" name="<?php echo $meta_box[ 'name' ]; ?>" value="<?php echo htmlspecialchars( $data[ $meta_box[ 'name' ] ] ); ?>" />
<p><?php echo $meta_box[ 'description' ]; ?></p>
</div>

<?php } ?>

</div>
<?php
}
function save_meta_box( $post_id ) {
global $post, $meta_boxes, $key;

foreach( $meta_boxes as $meta_box ) {
$data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
}

if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
return $post_id;

if ( !current_user_can( 'edit_post', $post_id ))
return $post_id;

update_post_meta( $post_id, $key, $data );
}
