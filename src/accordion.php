<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_micro_orm.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accord_panel.php'));

// load applets
$applets_dir = dirname(dirname(__file__)) . DIRECTORY_SEPARATOR . "applets";
$applets_dir_handle = opendir($applets_dir);
while ($applet_fname = readdir($applets_dir_handle)) {
	if ( (substr($applet_fname, 0, strlen("applet_")) == "applet_") &&
	     (substr($applet_fname, -strlen(".php")) == ".php")
	) {
		$full_path = $applets_dir . DIRECTORY_SEPARATOR . $applet_fname;
		require_once($full_path);
	}
}

class KintassaAccordion extends KintassaMicroORMObject {
	static function table_name() {
		global $wpdb;
		return $wpdb->prefix . "kintassa_accordion";
	}

	function save() {
		global $wpdb;

		if (!isset($this->id)) {
			// saving for the first time, so we need to insert a record
			$dat = array(
				"name" => $this->name,
				"display_mode" => $this->display_mode
			);
			$dat_fmt = array('%s', '%s');
			$res = $wpdb->insert($this->table_name, &$dat, &$dat_fmt);
			$this->id = $wpdb->insert_id;
		} else {
			$dat = array(
				"id" => $this->id,
				"name" => $this->name,
				"display_mode" => $this->display_mode
			);
			$dat_fmt = array('%d', '%s', '%s');
			$where = array("id" => $this->id);
			$res = $wpdb->update($this->table_name, &$dat, &$where, &$dat_fmt);
		}
	}

	function init() {
		$this->name = null;
		$this->display_mode = null;
	}

	function load() {
		global $wpdb;

		assert ($this->id != null);

		$qry = "SELECT * FROM `{$this->table_name()}` WHERE id=%d";
		$args = array($this->id);
		$qry = $wpdb->prepare($qry, $args);
		$row = $wpdb->get_row($qry);
		if (!$row) {
			return false;
		}

		$this->name = stripslashes($row->name);
		$this->display_mode = stripslashes($row->display_mode);

		return true;
	}

	function render($width, $height) {
		assert($this->id != null);

		if (!KintassaAccordionApplet::is_valid_applet($this->display_mode)) {
			$this->display_mode = 'invalid';
		}

		$applet_info = KintassaAccordionApplet::applet_info($this->display_mode);
		$applet_class = $applet_info['class'];

		$applet = new $applet_class($this, $width, $height);
		return $applet->render();
	}

	function panels() {
		global $wpdb;

		$table_name = KintassaAccordionPanel::table_name();
		$qry = "SELECT id,sort_pri FROM `{$table_name}` WHERE accordion_id=%d ORDER BY sort_pri ASC,name ASC";
		$args = array($this->id);
		$qry = $wpdb->prepare($qry, $args);
		$rows = $wpdb->get_results($qry);

		$panels = array();
		foreach ($rows as $row) {
			$panel = new KintassaAccordionPanel($row->id);
			$panels[] = $panel;
		}

		return $panels;
	}
}

?>