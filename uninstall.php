<?php
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
if(!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

global $wpdb;

// Database table name with prefix
$table_name = $wpdb->prefix . 'smilee_setup';

// Removes the table from database if it exists
$wpdb->query("DROP TABLE IF EXISTS {$table_name}");
?>
