<?php
/*
 * Plugin Name: Smilee.io
 * Description: Smilee Chat is a powerful tool to connect with your customers
 * Author: Smilee
 * Text Domain: smilee-chat-plugin
 * Domain Path: /lang
 * Version: 1.0.1
*/
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
if(!defined('ABSPATH')) { exit; }

define('Smilee_REL_PATH', dirname(plugin_basename(__FILE__)));

require_once('includes/class-smilee-setup-db.php');
require_once('includes/class-smilee-setup.php');
require_once('includes/class-smilee-setup-activator.php');

register_activation_hook(__FILE__, array('SmileeSetupActivator', 'create_db_table'));

function smilee_setup_start() {
	// Create a new instance of the SmileeSetupDB class
	$smilee_db = new SmileeSetupDB();
	// Create a new instance of the SmileeSetup class
	$smilee_setup = new SmileeSetup($smilee_db);
	// Initialize the $smilee_setup class object
	$smilee_setup->initialize();
}
smilee_setup_start();
?>
