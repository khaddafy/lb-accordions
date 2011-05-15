<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_utils.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_panel_form.php'));
require_once(kin_accord_inc('accord_panel.php'));

class KintassaAccordionPanelEditForm extends KintassaAccordionPanelForm {
	function __construct($name, $accord_panel_id) {
		$this->id = $accord_panel_id;
		$panel = new KintassaAccordionPanel($accord_panel_id);
		assert(!$panel->is_dirty());

		$default_vals = array(
			"name"				=> $panel->name,
			"sort_pri"			=> $panel->sort_pri,
			"accordion_id"		=> $panel->accordion_id,
			"title"				=> $panel->title,
			"content"			=> $panel->content,
		);
		parent::__construct($name, $default_vals);

		$this->id_field = new KintassaHiddenField('id', $name='id', $default_value = $accord_panel_id);
		$this->add_child($this->id_field);
	}

	function render_success() {
		echo("<p>" . __("Your accordion panel changes have been saved.  Thank you.") . "</p>");

		$this->accordion_return_link();
	}

	function update_record() {
		global $wpdb;

		$dat = $this->data();
		$fmt = $this->data_format();

		$where_dat = array("id"	=> $this->id);
		$where_fmt = array("%d");

		$res = $wpdb->update(KintassaAccordionPanel::table_name(), $dat, $where_dat, $fmt, $where_fmt);
		if (!$res) return false;

		return true;
	}
}

?>