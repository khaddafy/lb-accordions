<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

$_PLUGIN_ROOT = dirname(dirname(__file__));
require_once(kin_accord_inc('accord_applet.php'));

/***
 * Dummy renderer used for error messages when the requested renderer
 * doesn't exist
 */
class KintassaInvalidAccordionApplet extends KintassaAccordionApplet {
	static function register() {
		KintassaAccordionApplet::register('KintassaInvalidAccordionApplet', 'invalid', null);
	}

	function classes() {
		$cls = parent::classes();
		$cls[] = "kintassa-applet-invalid";
		return $cls;
	}

	function render() {
		$applet = $this;

		$accordion = $this->accordion;

		$unique_id = $this->unique_id();

		$cls = $this->classes_attrib_str();
		$sty = $this->styles_attrib_str();

		$not_avail_msg = __("This accordion cannot be displayed. Please check the accordion ID exists, (re)install the necessary AccordionApplets for its display method, or change the display method to one that's currently available.");

		$template = $this->template_path("invalid", "render");

		ob_start();
		require($template);
		$template_html = ob_get_contents();
		ob_end_clean();

		return $template_html;
	}
}

KintassaInvalidAccordionApplet::register();

?>
