<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accord_panel_editform.php'));

class KintassaAccordionPanelEditPage extends KintassaPage {
	function __construct($title) {
		parent::__construct($title);

		$accordion_panel_id = $_GET['id'];
		assert (KintassaUtils::isInteger($accordion_panel_id));

		$this->editForm = new KintassaAccordionPanelEditForm("kaccord_entry_edit", $accordion_panel_id);
	}

	function content() {
		$this->editForm->execute();
	}
}

?>
