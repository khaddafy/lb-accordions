<?php
/*
Author: Lee Braiden
Author URI: http://www.kintassa.com
Copyright: Copyright (c) 2011 Kintassa.
License: All rights reserved.  Contact Kintassa should you wish to license this product.
*/

require_once(kin_accord_inc('accordion.php'));
require_once(kin_accord_inc('accord_panel.php'));

global $wpdb;

function kintassa_accordions_create_tables() {
	global $wpdb;

	$accordions_tbl_name = KintassaAccordion::table_name();

	$accordions_tbl_sql = <<<SQL
		CREATE TABLE {$accordions_tbl_name} (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`name` VARCHAR(128) NULL ,
			`display_mode` VARCHAR(16),
			PRIMARY KEY (`id`)
		)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET = utf8
		COLLATE = utf8_unicode_ci;
SQL;

	$panels_tbl_name = KintassaAccordionPanel::table_name();

	$panels_tbl_sql = <<<SQL
		CREATE  TABLE `{$panels_tbl_name}` (
		  `id` INT NOT NULL AUTO_INCREMENT ,
		  `sort_pri` INT NULL DEFAULT 0 ,
		  `name` VARCHAR(255) NULL ,
		  `title` TEXT,
		  `content` TEXT,
		  `accordion_id` INT NOT NULL,
		  PRIMARY KEY (`id`)
		)
		ENGINE = InnoDB
		DEFAULT CHARACTER SET = utf8
		COLLATE = utf8_unicode_ci;
SQL;

	if (!KintassaMicroORMObject::table_exists($accordions_tbl_name)) {
		$wpdb->query($accordions_tbl_sql);
	}

	if (!KintassaMicroORMObject::table_exists($panels_tbl_name)) {
		$wpdb->query($panels_tbl_sql);
	}
}

function kintassa_accordions_setup_db() {
	$dbver = get_option("kintassa_accordions_dbver", null);
	if ($dbver == null) {
		kintassa_accordions_create_tables();
		add_option("kintassa_accordions_dbver", "1.0");
	} else {
		// already installed, no upgrades needed (as non exist yet)
	}
}

?>