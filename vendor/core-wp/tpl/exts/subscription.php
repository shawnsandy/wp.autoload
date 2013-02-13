<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php $status = isset( $_REQUEST['subscribe'] ) ? $_REQUEST['subscribe'] : false; ?>
<?php if ( $status == 'invalid_email' ) : ?>
    <p>You have entered an invalid e-mail, please try again!</p>
<?php elseif ( $status == 'success' ) : ?>
    <p>Thank you for subscribing! Please check your e-mail to confirm.</p>
<?php else : ?>
    <form method="POST">
        <input type="hidden" name="my-form-action" value="subscribe" />
        <input name="my-email" value="" placeholder="Enter your e-mail" />
        <input type="submit" />
    </form>
<?php endif; ?>