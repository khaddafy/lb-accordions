<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('config.php'));
require_once(kintassa_core('kin_micro_orm.php'));

class KintassaAccordionPanel extends KintassaMicroORMObject {
	function init() {
		$this->sort_pri = null;
		$this->name = null;
		$this->title = null;
		$this->content = null;
		$this->accordion_id = null;
	}

	static function table_name() {
		global $wpdb;
		return $wpdb->prefix . "kintassa_accordion_panel";
	}

	function save() {
		global $wpdb;

		assert(file_exists($this->filepath) && is_file($this->filepath));

		$table_name = KintassaAccordionPanel::table_name();
		$data = array(
			"sort_pri"		=> $this->sort_pri,
			"name"			=> $this->name,
			"title"			=> $this->title,
			"content"		=> $this->content,
			"accordion_id"	=> (int) $this->accordion_id,
		);
		$where = array(
			"id"			=> $this->id,
		);
		$data_fmt = array(
			"%d",
			"%s",
			"%s",
			"%s",
			"%d"
		);
		$where_fmt = array("%d");

		$res = $wpdb->update($table_name, $data, $where, $data_fmt, $where_fmt);
		if ($res != 1) {
			return false;
		}

		return true;
	}

	function load() {
		global $wpdb;

		assert($this->id != null);

		$table_name = $this->table_name();
		$qry = "SELECT sort_pri,name,title,content,accordion_id FROM `{$table_name}` WHERE `id`=%d;";
		$args = array($this->id);
		$qry = $wpdb->prepare($qry, $args);
		$res = $wpdb->get_row($qry);
		if (!$res) {
			echo("Couldn't load panel: $this->id");
			return false;
		}

		$this->sort_pri = $res->sort_pri;
		$this->name = stripslashes($res->name);
		$this->title = stripslashes($res->title);
		$this->content = stripslashes($res->content);
		$this->accordion_id = $res->accordion_id;

		return true;
	}

	function file_path() {
		return $this->filepath;
	}

	function mime_type() {
		return $this->mimetype;
	}

	function accordion_id() {
		return $this->accordion_id;
	}
}

?>