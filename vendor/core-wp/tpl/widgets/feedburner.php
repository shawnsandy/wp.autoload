<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */


?>
<form  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('<?php echo cwp_social::feedburner_subscriptions(); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
    <p>Enter your email address:</p>
    <p><input type="text" style="width:140px" name="email"/></p>
    <input type="hidden" value="ifitiscreative/feeds" name="uri"/>
    <input type="hidden" name="loc" value="en_US"/>
    <input type="submit" value="Subscribe" />
</form>