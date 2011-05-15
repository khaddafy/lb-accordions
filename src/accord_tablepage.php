<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_tableform.php'));

class KintassaAccordionTablePage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$table_name = "KintassaAccordion_list";

		$col_map = array(
			"id"				=> null,
			"name"				=> "Name",
			"display_mode"		=> "Display Mode"
		);

		$table_name = KintassaAccordion::table_name();
		$pager = new KintassaAccordionDBResultsPager($table_name);

		$row_opts = KintassaAccordionRowOptionsForm::Edit | KintassaAccordionRowOptionsForm::Delete;
		$row_form_fac = new KintassaAccordionRowOptionsFactory($row_opts);
		$this->table_form = new KintassaAccordionTableForm($table_name, $col_map, $pager, $row_form_fac);
	}

	function content() {
		$this->table_form->execute();

		$page_args = array(
			"mode" => "accordion_add",
		);
		$page_uri = KintassaUtils::admin_path("KintassaAccordionsMenu", "mainpage", $page_args);

		echo("<a href=\"{$page_uri}\" class=\"button\">Add Accordion</a>");
	}
}

?>