<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_page.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_addform.php'));

class KintassaAccordionAddPage extends KintassaPage {
	function content() {
		$addForm = new KintassaAccordionAddForm("KintassaAccordion_add");
		$addForm->execute();
	}
}

?>