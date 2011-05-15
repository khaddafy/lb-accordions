<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accord_form.php'));
require_once(kin_accord_inc('accordion.php'));

class KintassaAccordionEditForm extends KintassaAccordionForm {
	function __construct($name, $accordion_id) {
		$kgal = new KintassaAccordion($accordion_id);

		$this->accordion_id = $accordion_id;

		$default_vals = array(
			"name"				=> $kgal->name,
			"display_mode"		=> $kgal->display_mode,
		);
		parent::__construct($name, $default_vals);

		$this->id_field = new KintassaHiddenField('id', $name='id', $default_val = $accordion_id);
		$this->add_child($this->id_field);
	}

	function render_success() {
		echo ("Accordion updated. Thank you.");
	}

	function update_record() {
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$where_dat = array("id"	=> $this->id_field->value());
		$where_fmt = array("%d");

		$wpdb->update(KintassaAccordion::table_name(), $dat, $where_dat, $fmt, $where_fmt);

		return true;
	}
}

?>