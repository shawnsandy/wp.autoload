<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="icons">
    <!-- class content -->
    <?php //$cwp_feedburner = cwp_social::feedburner_subscriptions()  ?>
    <a href="http://feeds.feedburner.com/<?php the_author_meta('feedburner_page', 1); ?>" target="_blank">
        <img src="<?php echo get_template_directory_uri() ?>/images/rss_blue.png" class="twitter-bird" />
    </a>
    <a href="<?php the_author_meta('facebook', 1); ?>" target="_blank">
        <img src="<?php echo get_template_directory_uri() ?>/images/facebook_blue.png" class="twitter-bird" />
    </a>
    <a href="<?php the_author_meta('twitter', 1); ?>" target="_blank">
        <img src="<?php echo get_template_directory_uri() ?>/images/twitter_blue.png" class="twitter-bird" />
    </a>
</div>