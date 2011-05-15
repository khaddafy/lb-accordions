<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_editpage.php'));
require_once(kin_accord_inc('accord_addpage.php'));
require_once(kin_accord_inc('accord_tablepage.php'));
require_once(kin_accord_inc('accord_panel_addpage.php'));
require_once(kin_accord_inc('accord_panel_editpage.php'));

class KintassaAccordionMainPage extends KintassaPage {
	function content() {
		$recognised_modes = array(
			"accordion_list"		=> array("KintassaAccordionTablePage", __("Kintassa Accordions")),
			"accordion_add"			=> array("KintassaAccordionAddPage", __("Add Accordion")),
			"accordion_edit"		=> array("KintassaAccordionEditPage", __("Edit Accordion")),
			"accordion_panel_add"	=> array("KintassaAccordionPanelAddPage", __("Add Panel")),
			"accordion_panel_edit"	=> array("KintassaAccordionPanelEditPage", __("Edit Panel"))
		);

		// determine appropriate mode from web request
		$mode = 'accordion_list';	// default mode
		if (isset($_GET['mode'])) {
			$given_mode = $_GET['mode'];

			if (array_key_exists($given_mode, $recognised_modes)) {
				$mode = $given_mode;
			}
		}

		// determine the correct function handler for the mode, and call it
		$handler_details = $recognised_modes[$mode];
		$page_handler_class = $handler_details[0];
		$page_title = $handler_details[1];

		$page_handler = new $page_handler_class($page_title);
		$page_handler->execute();
	}
}

?>