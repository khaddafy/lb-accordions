<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accord_form.php'));

class KintassaAccordionAddForm extends KintassaAccordionForm {
	function __construct($name) {
		$default_vals = array(
			"name"			=> "",
			"width"			=> 320,
			"height"		=> 200,
			"display_mode"	=> "horiz_accordion",
		);
		parent::__construct($name, $default_vals);
	}

	function render_success() {
		$page_args = array("mode" => "accordion_edit", "id" => $this->id);
		$edit_uri = KintassaUtils::admin_path('KintassaAccordionsMenu', 'mainpage', $page_args);

		echo("<h2>" . __("Accordion Added") . "</h2>");
		echo(
			"<p>"
			. __("Your accordion has been added.  You might want to <a href=\"{$edit_uri}\">Edit this accordion</a> now.")
			. "</p>"
		);
	}

	function update_record() {
		// create and populate the db record in one step
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$wpdb->insert(KintassaAccordion::table_name(), $dat, $fmt);
		$this->id = $wpdb->insert_id;

		return true;
	}
}

?>