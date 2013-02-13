<?php

/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
global $wp_query;
?>
<?php if ($wp_query->max_num_pages > 1) : ?>
    <nav id="nav-above">
        <h1 class="section-heading"><?php _e('Post navigation', 'toolbox'); ?></h1>
        <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'toolbox')); ?></div>
        <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'toolbox')); ?></div>
    </nav><!-- #nav-above -->
<?php endif; ?>