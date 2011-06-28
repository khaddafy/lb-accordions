<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accordion.php'));

/***
 * publically callable function for rendering galleries in templates
 */
function kintassa_accordion($accordion_id) {
	$accordion = new KintassaAccordion($accordion_id);
	$rendered_html = $accordion->render();
	return($rendered_html);
}

?>
