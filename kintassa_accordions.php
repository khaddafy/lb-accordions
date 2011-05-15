<?php
/*
Plugin Name: Kintassa Accordion
Plugin URI: http://www.kintassa.com/projects/kintassa_accordion/
Description: A accordion page editing and presentation plugin
Version: 1.0
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa for licensing.
*/

if (!function_exists('kintassa_core')) {
	require_once ( WP_PLUGIN_DIR . '/Kintassa_Core/kintassa_core.php' );
}

function kin_accord_inc($subpath) {
	$full_subpath = "src/" . $subpath;
	if (DIRECTORY_SEPARATOR == "/") {
		$real_subpath = $full_subpath;
	} else {
		$real_subpath = str_replace("/", DIRECTORY_SEPARATOR, $full_subpath);
	}
	return dirname(__file__) . DIRECTORY_SEPARATOR . $real_subpath;
}

require_once(kintassa_core('kin_wp_plugin.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('db.php'));
require_once(kin_accord_inc('menu.php'));
require_once(kin_accord_inc('shortcode.php'));
require_once(kin_accord_inc('db.php'));
require_once(kin_accord_inc('tags.php'));

class KintassaAccordionsPlugin extends KintassaWPPlugin {
	function __construct() {
		parent::__construct(__file__);

		$kintassa_accordion_menu = new KintassaAccordionsMenu();
		$kintassa_accordion_shortcode = new KintassaAccordionsShortcode();

		add_action('init', array($this, 'install_scripts'));
	}

	function install_scripts() {
        $myStyleUrl = plugins_url('/stylesheets/kintassa_accordions.css', __file__);
	    wp_register_style('kintassa_accordions', $myStyleUrl);

		wp_enqueue_script("jquery");
        wp_enqueue_style('kintassa_accordions');
	}

	function install() {
		kintassa_accordions_setup_db();
	}

	function remove() {
	}
}

// instanciate the plugin
$kAccordionsPlugin = new KintassaAccordionsPlugin();
$kAccordionsPlugin->install();

?>