<?php
/**
 * @package WordPress
 * @subpackage Core-SF
 */
?>


<section id="footer" class="container">

        <div class="row dotted-border"><!-- container -->
            <ul class="block-grid mobile four-up">
                <li>
                    <?php if (!dynamic_sidebar('info-1')) : ?>

                        <!-- class content -->
                        <h3>Pages-info</h3>
                        <nav>
                            <ul>
                                <?php wp_list_pages('title_li=&number=6') ?>
                            </ul>
                        </nav>

                    <?php endif; ?>
                </li>
                <li>
                    <?php if (!dynamic_sidebar('info-2')) : ?>
                        <h3>Categories-info</h3>
                        <nav>
                            <ul>
                                <?php wp_list_categories('title_li=&number=6') ?>
                            </ul>
                        </nav>
                    <?php endif ?>
                </li>
                <li>
                    <?php if (!dynamic_sidebar('info-3')) : ?>

                        <h3>Social Connections</h3>
                        <p>
                            Inceptos turpis convallis dolor etiam arcu sapien nibh fames, curabitur torquent eu nostra iaculis nisl blandit sit, ut ipsum elit iaculis orci litora primis.
                        </p>
                    <?php endif ?>
                </li>
                <li>
                    <?php if (!dynamic_sidebar('info-4')) : ?>

                        <h3>Contact-info</h3>
                        <p>
                            Inceptos turpis convallis dolor etiam arcu sapien nibh fames, curabitur torquent eu nostra iaculis nisl blandit sit, ut ipsum elit iaculis orci litora primis.
                        </p>
                    <?php endif ?>
                </li>
            </ul>

        </div>
        <div class="row">
            <div class="twelve columns">
                <div id="copright-info">
                    <p class="copyright">&copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>.
                        All Rights Reserved.
                        <br />
                    </p>
                    <p class="designer-copy"> <a href="http://craftedandpressed.com" target="_BLANK">
                            Designed by Crafted and Pressed</a>.
                    </p>
                </div>
                <!-- ###end-row### -->
            </div>
        </div>

</section>

    <!-- ***page*** -->

</div>