<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kintassa_core('kin_form.php'));
require_once(kintassa_core('kin_tableform.php'));
require_once(kintassa_core('kin_utils.php'));
require_once(kin_accord_inc('config.php'));
require_once(kin_accord_inc('accordion.php'));
require_once(kin_accord_inc('accord_panel.php'));

class KintassaAccordionPanelTableForm extends KintassaOptionsTableForm {
	function process_actions() {
		$recognised_actions = array("up", "down", "edit", "del");
		$actions_taken = $this->buttons_submitted($recognised_actions);

		if ($actions_taken) {
			$action = $actions_taken[0];
			$row_id = $actions_taken[1];

			$handler = "do_row_action_" . $action;

			return $this->$handler($row_id);
		}
	}

	function do_row_action_edit($row_id) {
		// dummy; this is handled on a new page
	}

	function do_row_action_del($row_id) {
		if (!$this->pager->row_exists($row_id)) {
			exit ("<div class=\"notice\">Row $row_id already deleted.</div>");
		}
		if ($this->pager->delete($row_id)) {
			echo ("<div class=\"notice\">Entry #{$row_id} deleted.</div>");
		}
		return false;
	}

	function do_row_action_up($row_id) {
		$this->pager->sort_up($row_id);
	}

	function do_row_action_down($row_id) {
		$this->pager->sort_down($row_id);
	}

	function handle_submissions() {
		return false;
	}

	function end_table() {
		parent::end_table();
		$this->pager->render_page_nav();
	}

	function begin_col($col) {
		if ($col == 'title' || $col == 'content') {
			echo "<td>";
			echo do_shortcode($this->row->$col);
		} else {
			parent::begin_col($col);
		}
	}
}

class KintassaAccordionPanelRowOptionsForm extends KintassaRowForm {
	const Sort = 1;
	const Edit = 2;
	const Delete = 4;
	const All = 7;

	function __construct($table_form, $row, $opts) {
		$form_name = $table_form->name() . "_row_" . $row->id;
		parent::__construct($form_name);

		$this->row_id_field = new KintassaHiddenField(
			"row_id", $name="row_id", $default_val = $row->id, $non_unique=true
		);
		$this->add_child($this->row_id_field);

		if ($opts & KintassaAccordionPanelRowOptionsForm::Sort) {
			$this->add_child(new KintassaButton("&uarr;", $name="up", $primary=false, $non_unique=true));
			$this->add_child(new KintassaButton("&darr;", $name="down", $primary=false, $non_unique=true));
		}

		if ($opts & KintassaAccordionPanelRowOptionsForm::Edit) {
			$edit_args = array("mode" => "accordion_panel_edit", "id" => $row->id);
			$edit_uri = KintassaUtils::admin_path("KintassaAccordionsMenu", "mainpage", $edit_args);
			$edit_btn = new KintassaLinkButton("Edit", $name="edit", $uri = $edit_uri);
			$this->add_child($edit_btn);
		}

		if ($opts & KintassaAccordionPanelRowOptionsForm::Delete) {
			$this->add_child(new KintassaButton("Del", $name="del", $primary=false, $non_unique=true));
		}
	}

	function handle_submissions() {
		// dummy, handled by parent table
		return false;
	}
}

class KintassaAccordionPanelRowOptionsFactory extends KintassaRowFormFactory {
	function __construct($opts) {
		$this->opts = $opts;
	}

	function instanciate($table_form, $row) {
		return new KintassaAccordionPanelRowOptionsForm($table_form, $row, $this->opts);
	}
}

class KintassaAccordionPanelDBResultsPager extends KintassaPager {
	const RowSpace = 2;
	const RowJump = 3;

	function __construct($table_name, $page_size = 10, $accordion_id = null) {
		parent::__construct();

		assert ($page_size > 0);
		assert($accordion_id != null);

		$this->table_name = $table_name;
		$this->page_size = $page_size;
		$this->accordion_id = $accordion_id;
		$this->results = null;
	}

	private function modify_sort($row_id, $sort_delta) {
		$gal = new KintassaAccordionPanel($row_id);
		if ($gal->is_dirty()) {
			// failed to load from db; probably deleted now due to different
			// browser windows being out of sync, so just ignore the request
			// and let the updated table show the user what's now available.
			return false;
		}
		$gal->sort_pri += $sort_delta;
		$gal->save();

		$this->reorder();

		return true;
	}

	function row_exists($row_id) {
		global $wpdb;
		$table_name = KintassaAccordionPanel::table_name();
		$qry = "SELECT id from {$table_name} WHERE id={$row_id}";
		$res = $wpdb->get_results($qry);
		return ($res != false);
	}

	function sort_up($row_id) {
		assert($this->modify_sort($row_id, -KintassaAccordionPanelDBResultsPager::RowJump) != false);
	}

	function sort_down($row_id) {
		assert($this->modify_sort($row_id, KintassaAccordionPanelDBResultsPager::RowJump) != false);
	}

	private function reorder() {
		global $wpdb;

		$table_name = KintassaAccordionPanel::table_name();
		$accordion_id = $this->accordion_id;

		@mysql_query("BEGIN", $wpdb->dbh);

		$qry = "SELECT id FROM `{$table_name}` WHERE accordion_id={$this->accordion_id} ORDER BY sort_pri ASC,name ASC";
		print_r($qry);
		$rows = $wpdb->get_results($qry);
		if (!$rows) {
			echo("error running query");
		}

		$pri = 0;
		foreach ($rows as $row) {
			$update_qry = "UPDATE `{$table_name}` SET `sort_pri`={$pri} WHERE `id`={$row->id}";
			$res = mysql_query($update_qry, $wpdb->dbh);
			if (!$res) {
				$wpdb->print_error();
			}

			$pri += KintassaAccordionPanelDBResultsPager::RowSpace;
		}

		@mysql_query("COMMIT", $wpdb->dbh);
	}

	function delete($row_id) {
		global $wpdb;

		$qry = "DELETE FROM `{$this->table_name}` WHERE id={$row_id}";
		$res = $wpdb->query($qry);

		return ($res != false);
	}

	function num_results() {
		global $wpdb;
		$qry = $this->build_count_query();
		$res = $wpdb->get_var($qry);
		return $res;
	}

	function page_size() {
		return $this->page_size;
	}

	function current_page() {
		if (isset($_GET['pagenum'])) {
			$pg = (int) $_GET['pagenum'];
			$num_pages = $this->num_pages();

			if ($pg < 1) {
				$pg = 1;
			} else if ($pg > $num_pages) {
				$pg = $num_pages;
			}
		} else {
			$pg = 1;
		}

		return $pg;
	}

	function items_on_page() {
		$db_results = $this->get_db_results();

		$res = array();
		foreach ($db_results as $row) {
			$res[] = $row;
		}
		return $res;
	}

	function page_link($page_num) {
		$page_args = array("mode" => "accordion_edit", "pagenum" => $page_num, "id" => $this->accordion_id);
		$page_uri = KintassaUtils::admin_path("KintassaAccordionsMenu", "mainpage", $page_args);
		return $page_uri;
	}

	function render_page_nav() {
		$num_records = $this->num_results();
		$pages = $this->num_pages();

		if ($pages == 1) return; // no nav if only one page

		$current_page = $this->current_page();

		echo("<div class=\"kintassa-page-nav\">{$num_records} entries found; {$pages} pages, {$this->page_size} entries per page. Go to page: ");

		foreach (range(1, $pages, 1) as $pg) {
			$page_link = $this->page_link($pg);
			if ($pg == $current_page) {
				echo(" <strong>{$pg}</strong> ");
			} else {
				echo (" <a href=\"{$page_link}\" class=\"button\">{$pg}</a> ");
			}
		}

		echo ("</div>");
	}

	function build_count_query() {
		$qry = "SELECT COUNT(*) FROM `{$this->table_name}` WHERE `accordion_id`={$this->accordion_id}";
		return $qry;
	}

	function build_page_query() {
		$page_size = $this->page_size();

		$page_num = $this->current_page();
		$page_num -= 1; // count from zero

		$accordion_id = $this->accordion_id;

		$start_item = $page_size * $page_num;
		$qry = "SELECT id,sort_pri,name,title,content FROM `{$this->table_name}` WHERE `accordion_id`={$accordion_id} ORDER BY `sort_pri` ASC, `name` ASC LIMIT {$start_item},{$page_size}";

		return $qry;
	}

	/***
	 * gets db results if not already cached, then returns them
	 */
	function get_db_results() {
		global $wpdb;

		if ($this->results == null) {
			$qry = $this->build_page_query();
			$this->results = $wpdb->get_results($qry);
		}

		return $this->results;
	}
}

?>