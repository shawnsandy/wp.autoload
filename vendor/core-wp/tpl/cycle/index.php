<div>
    <?php if(has_post_thumbnail()): ?>
    <span class="slider-img">
        <?php the_post_thumbnail('cycle-image'); ?>
    </span>
    <?php else : ?>
        <span><img src="<?php echo get_template_directory_uri() ?>/images/pool.jpg"/></span>
<!--        <span><img src="<?php echo get_template_directory_uri() ?>/images/old-boat.jpg"/></span>-->
<!--        <span><img src="<?php echo get_template_directory_uri() ?>/images/3-trunk.jpg"/></span>-->

    <?php endif; ?>
    <div class="clear">Cleared</div>
</div>