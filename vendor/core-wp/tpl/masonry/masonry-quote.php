<!-- <h3>
            <a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'toolbox'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?>
            </a>
        </h3>-->
    <div class="contents">

        <?php the_content(); ?>
        <span class="author-title">by - <?php echo esc_attr(the_title()) ?></span>
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