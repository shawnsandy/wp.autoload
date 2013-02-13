<?php


/**
 * Sample Setup ****************************************************************
 */
$array_sample = array
    (
    'id' => '_full_meta',
    'title' => 'Full Inputs',
    'types' => array('page', 'events'), // added only for pages and to custom post type "events"
    'context' => 'normal', // same as above, defaults to "normal" (‘normal’, ‘advanced’, or ‘side’)
    'priority' => 'high', // same as above, defaults to "high" (‘high’ or ‘low’)
    'mode' => WPALCHEMY_MODE_ARRAY, // defaults to WPALCHEMY_MODE_ARRAY / WPALCHEMY_MODE_EXTRACT
    'template' => get_stylesheet_directory() . '/metaboxes/full-meta.php',
    'init_action' => 'my_init_action_func', // runs only when metabox is present - defaults to NULL
    'lock' => WPALCHEMY_LOCK_TOP, // defaults to NULL ; WPALCHEMY_LOCK_XXX  (“top”, “bottom”, “before_post_title”, “after_post_title”)
    'prefix' => '_my_' // defaults to NULL
    //
);
$full_mb = new WPAlchemy_MetaBox($array_sample);

/**
 * Sample Form *****************************************************************
 */
?>
<div class="my_meta_control">

	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras orci lorem, bibendum in pharetra ac, luctus ut mauris.</p>

	<label>Title</label>

	<p>
		<?php $mb->the_field('title'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter in a title</span>
	</p>

	<label>Description <span>(optional)</span></label>

	<p>
		<?php $mb->the_field('description'); ?>
		<textarea name="<?php $mb->the_name(); ?>" rows="3"><?php $mb->the_value(); ?></textarea>
		<span>Enter in a description</span>
	</p>

        <label>Select Single</label><br/>

	<?php $mb->the_field('s_single'); ?>
	<select name="<?php $mb->the_name(); ?>">
		<option value="">Select...</option>
		<option value="a"<?php $mb->the_select_state('a'); ?>>a</option>
		<option value="b"<?php $mb->the_select_state('b'); ?>>b</option>
		<option value="c"<?php $mb->the_select_state('c'); ?>>c</option>
	</select>

        <label>Single Checkbox</label><br/>

	<?php $mb->the_field('r_single'); ?>
	<input type="radio" name="<?php $mb->the_name(); ?>" value="abc"<?php $mb->the_radio_state('abc'); ?>/> abc<br/>


	<label>Checkbox Group</label><br/>

	<?php $clients = array('a','b','c'); ?>

	<?php foreach ($clients as $i => $client): ?>
		<?php $mb->the_field('r_ex2'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $client; ?>"<?php $mb->the_radio_state($client); ?>/> <?php echo $client; ?><br/>
	<?php endforeach; ?>

</div>



<?php

/**
 * Use In Post
 */

// usually needed
global $custom_metabox;

// get the meta data for the current post
$custom_metabox->the_meta();

// set current field, then get value
$custom_metabox->the_field('name');
$custom_metabox->the_value();

// get value directly
$custom_metabox->the_value('description');

// loop a set of fields
while ($custom_metabox->have_fields('authors')) {
    $custom_metabox->the_value();
}

// loop a set of field groups
while ($custom_metabox->have_fields('links')) {
    $custom_metabox->the_value('title');

    $custom_metabox->the_value('url');

    if ($custom_metabox->get_the_value('nofollow'))
        echo 'is-nofollow';

    $custom_metabox->the_value('target');
}