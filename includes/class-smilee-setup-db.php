<?php
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
class SmileeSetupDB {
	private $smilee_textarea_value;
	private $smilee_table_name;
	private $confirmation_text;

	public function initialize() {
		global $wpdb;
		$this->wpdb = $wpdb;
		// Set database table name
		$this->set_smilee_table_name($wpdb->prefix . 'smilee_setup');
	}

	// Updates the 'string' with the textarea value in the created table.
	public function smilee_db() {
		// Retrieve nonce
		$this->ta_nonce = $_REQUEST['ta_nonce'];

		// Verify nonce
		if(wp_verify_nonce($this->ta_nonce, 'save_textarea_value')) {

			// Check if Save button was pressed
			if(isset($_POST['btn_save_smilee'])) {
				// Set textarea value
				$this->set_smilee_textarea_value(stripslashes($_POST['smilee-text-area']));
/* Commented out to allow more than just <script> tags in the textarea
				// Check if textarea is not empty and verify nonce
				if(!empty($this->get_smilee_textarea_value())) {

					$this->matches = array();
					// Regex. Puts all matches into $this->matches array.
					preg_match_all(
						// Regex pattern
						// /(\<.*?\>)[\s\S]*?(\<.*?\>)/									Not perfect for this case. Seems to match everything between < and >
						// /(?=<[a-zA-Z]+>)[\s\S]*?(<\/[a-zA-Z]+>)/ 		Matches <letters></letters> and everything inside
						'/(?=<script>)[\s\S]*?(<\/script>)/', 			// 	Matches <script></script> and everything inside
																												//	\s = any whitespace character, \S = any non-whitespace character
																												//	*? = 0 to unlimited times, + = 1 to unlimited times
																												// < and > are just those characters, ?= is a positive lookahead, \/ = /
						// String
						$this->get_smilee_textarea_value(),
						// Regex matches (array)
						$this->matches
					);

					$this->matches_string = "";

					// Goes through the array that has the matches
					foreach($this->matches[0] as $m) {
						// Puts the matches into a string
						$this->matches_string .= $m . "\n";
					}
					// Strip slahes ($_POST adds them)
					$this->matches_string = stripslashes($this->matches_string);
					// Set textarea value
					$this->set_smilee_textarea_value($this->matches_string);
				}*/
			}
			else {
				// Set textarea value
				$this->set_smilee_textarea_value('');
			}

			// Creates a row if it doesn't exist OR replaces a row if it does exist
			$this->row_count = $this->wpdb->replace(
				$this->get_smilee_table_name(),	// Table
				array(													// Data
					'id'		=> 1,
					'string'	=> $this->get_smilee_textarea_value()
				),
				array(		// Format
					'%d',			// Integer (whole number)
					'%s'			// String
				)
			);

			// Check if a row was replaced
			if($this->row_count > 1) {
				// Check if textarea value is not empty
				if($this->get_smilee_textarea_value() != '') {
					// Set confirmation text
					$this->set_confirmation_text(__('Script was added to the footer.', 'smilee-setup'));
				}
				// if textarea value is empty
				else {
					// Set confirmation text
					$this->set_confirmation_text(__('Script was removed from the footer.', 'smilee-setup'));
				}
			}
		}
	}

	// Gets 'string' value from the table and echoes it
	public function smilee_query() {
		// get_var executes a SQL query and returns the query's result
		// Gets the 'string' value from the table
		$this->result = $this->wpdb->get_var("SELECT string FROM {$this->get_smilee_table_name()} WHERE id = 1");
		// Check if the result is not empty
		if(!empty($this->result)) {
			// Echo the result
			echo $this->result;
		}
	}

	public function echo_confirmation_text() {
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
			echo '<p class="confirmation">' . $this->get_confirmation_text() . '</p>';
		}
	}

	private function set_confirmation_text($confirmation_text) {
		$this->confirmation_text = $confirmation_text;
	}

	public function get_confirmation_text() {
		return $this->confirmation_text;
	}

	private function set_smilee_table_name($smilee_table_name) {
		$this->smilee_table_name = $smilee_table_name;
	}

	private function set_smilee_textarea_value($smilee_textarea_value) {
		$this->smilee_textarea_value = $smilee_textarea_value;
	}

	public function get_smilee_table_name() {
		return $this->smilee_table_name;
	}

	public function get_smilee_textarea_value() {
		return $this->smilee_textarea_value;
	}
}
?>
