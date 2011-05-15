<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accord_panel_addform.php'));

class KintassaAccordionPanelAddPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		if (!isset($_GET['accordion_id']) || !KintassaUtils::isInteger($_GET['accordion_id'])) {
			echo("<div class=\"error\">Error: invalid accordion id specified</div>");
			return;
		} else {
			$accordion_id = $_GET['accordion_id'];
		}

		$default_vals = array(
			"sort_pri"		=> 0,
			"filepath"		=> null,
			"name"			=> null,
			"description"	=> "",
			"accordion_id"	=> $accordion_id,
		);
		$this->addForm = new KintassaAccordionPanelAddForm("kaccord_panel_add", $default_vals);
	}

	function content() {
		$this->addForm->execute();
	}
}

?>
