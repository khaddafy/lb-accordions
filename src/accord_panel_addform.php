<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accord_panel_form.php'));

class KintassaAccordionPanelAddForm extends KintassaAccordionPanelForm {
	function render_success() {
		$page_args = array("mode" => "accordion_panel_edit", "id" => $this->id);
		$edit_uri = KintassaUtils::admin_path('KintassaAccordionsMenu', 'mainpage', $page_args);

		echo("<h2>" . __("Entry Added") . "</h2>");
		echo("<p>" . __("Your accordion panel has been added.  Thank you.") . "</p>");

		$this->accordion_return_link();
	}

	function update_record() {
		// create and populate the db record in one step
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$wpdb->insert(KintassaAccordionPanel::table_name(), $dat, $fmt);
		$this->id = $wpdb->insert_id;

		return true;
	}
}

?>