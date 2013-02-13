<?php

class Example_Admin_Page extends scbAdminPage {

	function setup() {
		$this->args = array(
			'page_title' => 'scb Example',
		);
	}

	function page_content() {
		echo html( 'h3', 'Text fields' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'text',
				'name' => 'text_field',
			),
			array(
				'title' => 'Nested Name',
				'type' => 'text',
				'name' => array( 'parent', 'child', 'grand-child' ),
			),
			array(
				'title' => 'Pre-filled',
				'type' => 'text',
				'name' => 'text_field',
				'value' => 'Lorem Ipsum',
			),
			array(
				'title' => 'With description',
				'type' => 'text',
				'name' => 'text_field2',
				'desc' => 'You know what to do.'
			),
		) );

		echo html( 'h3', 'Textareas' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'textarea',
				'name' => 'text_area',
			),
			array(
				'title' => 'Larger',
				'type' => 'textarea',
				'name' => 'text_area',
				'extra' => 'rows="5" cols="50"'
			),
			array(
				'title' => 'A textarea',
				'type' => 'textarea',
				'name' => 'text_area',
				'value' => "Lorem <em>Ipsum</em>\nDolor",
				'extra' => array( 'rows' => 7, 'cols' => 100 )
			),
		) );

		echo html( 'h3', 'Checkboxes' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'checkbox',
				'name' => 'check_box',
				'desc' => 'Yes, do that.'
			),
			array(
				'title' => 'Nested name',
				'type' => 'checkbox',
				'name' => array( 'check', 'box' ),
				'desc' => 'Yes, do that.'
			),
			array(
				'title' => 'Pre-checked',
				'type' => 'checkbox',
				'name' => 'check_box',
				'desc' => 'Yes, do that.',
				'checked' => true
			),
			array(
				'title' => 'Description before',
				'type' => 'checkbox',
				'name' => 'check_box',
				'desc' => 'Yes, do that.',
				'desc_pos' => 'before'
			),
		) );

		echo html( 'h3', 'Radio buttons' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'radio',
				'name' => 'fruit',
				'value' => array(
					'apple' => 'Apple',
					'banana' => 'Banana',
					'orange' => 'Orange'
				),
			),
			array(
				'title' => 'Basic (deprecated)',
				'type' => 'radio',
				'name' => 'fruit3',
				'value' => array( 'apple', 'banana', 'orange' ),
				'desc' => array( 'Apple', 'Banana', 'Orange' ),
			),
			array(
				'title' => 'Nested name',
				'type' => 'radio',
				'name' => array( 'produce', 'fruit' ),
				'value' => array( 'apple', 'banana', 'orange' ),
				'desc' => array( 'Apple', 'Banana', 'Orange' ),
			),
			array(
				'title' => 'Pre-selected value',
				'type' => 'radio',
				'name' => 'fruit2',
				'value' => array(
					'apple' => 'Apple',
					'banana' => 'Banana',
					'orange' => 'Orange'
				),
				'selected' => 'banana'
			),
		) );

		echo html( 'h3', 'Dropdowns' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'select',
				'name' => 'color',
				'value' => array( 'green', 'blue', 'white' ),
			),
			array(
				'title' => 'Nested name',
				'type' => 'select',
				'name' => array( 'house', 'color' ),
				'value' => array( 'green', 'blue', 'white' ),
			),
			array(
				'title' => 'Without blank option',
				'type' => 'select',
				'name' => 'color',
				'value' => array( 'green', 'blue', 'white' ),
				'text' => false
			),
			array(
				'title' => 'With text',
				'type' => 'select',
				'name' => 'color',
				'value' => array( 'green', 'blue', 'white' ),
				'text' => '&ndash; Color &ndash;'
			),
			array(
				'title' => 'Pre-selected value',
				'type' => 'select',
				'name' => 'radio_box',
				'value' => array( 'foo', 'bar', 'baz' ),
				'selected' => 'bar',
				'text' => '&ndash; Color &ndash;'
			),
			array(
				'title' => 'Numeric values',
				'type' => 'select',
				'name' => 'radio_box',
				'value' => array( 1 => 'Jan', 2 => 'Feb' ),
				'text' => '&ndash; Month &ndash;'
			),
		) );

		echo html( 'h3', 'Multiple choice' );
		echo $this->form_table( array(
			array(
				'title' => 'Basic',
				'type' => 'checkbox',
				'name' => 'color',
				'value' => array( 'green', 'blue', 'white' ),
			),
			array(
				'title' => 'Nested name',
				'type' => 'checkbox',
				'name' => array( 'bikeshed', 'color' ),
				'value' => array( 'green', 'blue', 'white' ),
			),
			array(
				'title' => 'Pre-selected values',
				'type' => 'checkbox',
				'name' => array( 'bikeshed', 'color' ),
				'value' => array( 'green', 'blue', 'white' ),
				'checked' => array( 'green', 'white' ),
			),
		) );
	}

	function page_footer() {
		parent::page_footer();

		// Reset all forms
?>
		<script type="text/javascript">
		(function() {
			var forms = document.getElementsByTagName('form');
			for (var i = 0; i < forms.length; i++) {
				forms[i].reset();
			}
		}());
		</script>
<?php
	}
}


class Example_Boxes_Page extends scbBoxesPage {

	function setup() {
		$this->args = array(
			'page_title' => 'scb Example Boxes',
		);

		$this->boxes = array(
			array( 'settings', 'Settings Box', 'normal' ),
			array( 'right', 'Right Box', 'side' ),
		);
	}

	function settings_box() {
		Echo html( 'p', 'This is the settings box.' );
	}

	function right_box() {
		Echo html( 'p', 'This is the box on the right.' );
	}
}

