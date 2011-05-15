<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accordion.php'));

class KintassaAccordionsShortcode {
	function __construct() {
		add_shortcode('kintassa_accordion', array(&$this, 'render_shortcode'));
	}

	/***
	 * wordpress shortcode handler for kintassa galleries
	 */
	function render_shortcode($atts) {
		$known_attribs = array(
			"id"			=> null,
		);
		$parsed_atts = shortcode_atts(&$known_attribs, $atts);

		$id = $parsed_atts['id'];
		if (!KintassaUtils::isInteger($id)) {
			echo ("(invalid accordion id requested)");
			return;
		}

		$accordion = new KintassaAccordion($id);
		$template_html = $accordion->render();

		return $template_html;
	}
}

?>