<?php
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
if ( !class_exists( 'SmileeSetup' ) ) {
	class SmileeSetup {
		private $smilee_db;

		public function __construct($smilee_db) {
			$this->smilee_db = $smilee_db;
			// Initialize $smilee_db (which is the class SmileeSetupDB)
			$this->smilee_db->initialize();
		}

		public function initialize() {
			// Execute load_translations() when plugins are loaded
			add_action('plugins_loaded', array($this, 'load_translations'));
			// Execute add_admin_menu() in the admin_menu action
			add_action('admin_menu', array($this, 'add_admin_menu'));
			// Add admin page stylesheet
			add_action( 'admin_enqueue_scripts', array($this, 'load_smilee_admin_style') );
			// Add smilee_query return result in the footer
			add_action('wp_footer', array($this->smilee_db, 'smilee_query'), 100);
		}

		// Generate the options page
		public function generate_options() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.', 'smilee-setup') );
			}

			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			// Execute smilee_db() from class-smilee-setup-db.php
				$this->smilee_db->smilee_db();
			}
			// This file has the options page contents
			require_once('smilee-setup-options.php');
		}

		// Add an item to the admin menu
		public function add_admin_menu() {
		  add_menu_page('Smilee Chat',  // Page title
							'Smilee Chat',        // Menu title
							'manage_options',     // Capability. Shows the menu if the
												  					// current user has access to admin panel
							'smilee-menu',        // Menu slug
							array($this, 'generate_options'),     // Function to call
							'dashicons-smiley');  // Menu icon
		}

		// Enqueue stylesheet in the admin page 'smilee-menu'
		public function load_smilee_admin_style($hook) {
        if($hook != 'toplevel_page_smilee-menu') {
                return;
        }
				wp_enqueue_style( 'smilee_admin', plugin_dir_url(dirname(__FILE__)) . 'assets/css/admin-style.css' );
		}

		// Load translations from <plugindir>/lang
		public function load_translations() {
			load_plugin_textdomain( 'smilee-setup', false, Smilee_REL_PATH . '/lang' );
		}
	}
}
?>
