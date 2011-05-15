<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_applet.php'));
require_once(kin_accord_inc('./config.php'));

$GLOBALS['registered_kintassa_accordion_applets'] = array();

abstract class KintassaAccordionApplet extends KintassaApplet {
	static function register($applet_class, $name, $pretty_name) {
		if (array_key_exists($applet_class, $GLOBALS['registered_kintassa_accordion_applets'])) return;
		$GLOBALS['registered_kintassa_accordion_applets'][$name] = array(
			'class'			=> $applet_class,
			'pretty_name'	=> $pretty_name,
		);
	}

	function __construct($accordion) {
		parent::__construct();
		$this->accordion = $accordion;
	}

	function template_path($applet_name, $template_name) {
		$template_dir = dirname(dirname(__file__)) . DIRECTORY_SEPARATOR . "templates";
		$fname = basename("applet_" . $applet_name . "__" . $template_name . ".php");
		$template = $template_dir . DIRECTORY_SEPARATOR . $fname;
		return $template;
	}

	static function available_applets() {
		return array_keys($GLOBALS['registered_kintassa_accordion_applets']);
	}

	static function is_valid_applet($applet_name) {
		return array_key_exists($applet_name, $GLOBALS['registered_kintassa_accordion_applets']);
	}

	static function applet_info($applet_name) {
		return $GLOBALS['registered_kintassa_accordion_applets'][$applet_name];
	}

	function unique_id() {
		return "kintassa-accordion-{$this->accordion->id}";
	}

	function classes() {
		return array("kintassa-accordion-app");
	}

	function classes_attrib_str() {
		return "class=\"" . implode(" ", $this->classes()) . "\"";
	}

	function styles() {
		$sty = array();
		return $sty;
	}

	function styles_attrib_str() {
		$style_str = "style=\"";
		$styles = $this->styles();
		foreach($styles as $k => $v) {
			$style_str .= "{$k}: {$v};";
		}
		$style_str .= "\"";
		return $style_str;
	}
}

?>