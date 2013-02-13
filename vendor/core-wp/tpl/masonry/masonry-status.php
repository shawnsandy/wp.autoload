<h3>
        <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'toolbox'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?>
        </a>
    </h3>
    <?php if (has_post_thumbnail()) : ?>
        <div class="grid-thumbnail">
            <?php //the_post_thumbnail('home-thumb'); ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'toolbox'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                <?php cwp::fluid_img('home-thumb', 100); ?></a>
            <div class="clear">Cleared</div>
        </div>
    <?php endif ?>
    <div class="contents">

        <?php cwp::excerpt(200); ?>
        <div class="post-meta">
            <?php
            //the_time('F j, Y');
            the_category('/');
            echo " (" . core_functions::time_ago() . ")";
            ?>
            <!-- class content -->
        </div>
        <div class="clear">Cleared</div>
    </div>
