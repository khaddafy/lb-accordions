<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_utils.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_panel.php'));
require_once(kin_accord_inc('accord_panel_editform.php'));
require_once(kin_accord_inc('accord_panel_tablepage.php'));

class KintassaAccordionEditPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$accordion_id = $_GET['id'];
		assert (KintassaUtils::isInteger($accordion_id));

		$this->accordion_id = $accordion_id;

		$this->editForm = new KintassaAccordionEditForm("kin_accord_edit", $accordion_id);
	}

	function panels_subform() {
		$form_name = "kaccordion_panels";

		$col_map = array(
			"id"			=> null,
			"sort_pri"		=> "Sort Order",
			"name"			=> "Name",
			"content"		=> "Content",
		);

		$table_name = KintassaAccordionPanel::table_name();
		$pager = new KintassaAccordionPanelDBResultsPager(
			$table_name, $page_size = 10, $accordion_id=$this->accordion_id
		);

		$row_opts = KintassaAccordionPanelRowOptionsForm::All;
		$row_form_fac = new KintassaAccordionPanelRowOptionsFactory($row_opts);
		$panels_table_form = new KintassaAccordionPanelTableForm($form_name, $col_map, $pager, $row_form_fac);
		$panels_table_form->execute();
	}

	function add_options() {
		$add_panel_args = array("mode" => "accordion_panel_add", "accordion_id" => $this->accordion_id);
		$add_panel_link = KintassaUtils::admin_path("KintassaAccordionsMenu", "mainpage", $add_panel_args);

		$this->add_panel_button = new KintassaLinkButton("Add Panel", $name="add_accordion_panel", $uri=$add_panel_link);
		$this->add_panel_button->render();
	}

	function content() {
		$this->editForm->execute();
		$this->panels_subform();
		$this->add_options($this->editForm);
	}
}

?>