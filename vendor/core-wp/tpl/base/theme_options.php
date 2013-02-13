<?php
/**
 * @package WordPress
 * @subpackage Core-WP
 * @author shawnsandy
 */
?>
<div class="wrap">
    <!-- class content -->
    <h2>Theme Options</h2>
    <form action="options.php" method="POST">
        <?php settings_fields($settings); ?>
        <p>
            <label>Sample 1</label>
            <input type="text" name="<?php echo $opt_name ?>[sample1]" value="<?php echo $options['sample1'] ?>" />
        </p>
        <p>
            <label>Sample 2</label>
            <input type="text" name="<?php echo $opt_name ?>[sample2]" value="<?php echo $options['sample2'] ?>" />
        </p>
        <p>
            <label>Sample 3</label>
            <input type="text" name="option1" value="" />
        </p>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes','toolbox') ?>" />
        </p>
    </form>
</div>
