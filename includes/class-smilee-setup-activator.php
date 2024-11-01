<?php
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
class SmileeSetupActivator {
	// Creates a table to the database
	public static function create_db_table() {
		global $wpdb;
		// Table name with wp database table prefix
		$table_name = $wpdb->prefix . 'smilee_setup';
		// Collate to make sure special characters don't mess things up, AFAIK.
		$charset_collate = $wpdb->get_charset_collate();

		// Creates a table that can only have one row.
		// The table has two columns: 'id' and 'string'
		$sql = "CREATE TABLE {$table_name} (
			id tinyint(1) NOT NULL,
			string varchar(2000),
			PRIMARY KEY  (id)
		) $charset_collate;";

		// Require upgrade.php, because dbDelta() is in it
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// dbDelta helps with creating or modifying a database depending on the situation.
		// In this case it basically creates a table if it doesn't exist.
		dbDelta($sql);
	}
}
?>
