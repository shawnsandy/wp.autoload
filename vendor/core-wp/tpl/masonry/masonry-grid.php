<?php if (has_post_thumbnail()) : ?>
    <div class="grid-thumbnail">
        <?php the_post_thumbnail('home-thumb'); ?>
        <div class="clear">Cleared</div>
    </div>
<?php endif ?>
<h3>
    <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'toolbox'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?>
    </a>
</h3>
<?php cwp::excerpt(); ?>
