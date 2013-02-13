<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="related-posts">
    <?php
    while ($related_query->have_posts()) : $related_query->the_post();
        ?>
        <li>
            <a href="<?php the_permalink() ?>" > <?php the_title(); ?> </a>
        </li>
        <?php
    endwhile;
    ?>
</ul>
