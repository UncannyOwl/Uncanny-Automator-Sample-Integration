<?php

/**
 * Sample Integration Settings
 */
class Sample_Integration_Settings {
	/**
	 * Creates the settings page
	 */
	public function __construct() {
		// Add tab
		add_filter(
			'automator_settings_premium_integrations_tabs',
			array( $this, 'add_tab' ),
			99,
			1
		);
	}

	/**
	 * Adds the new tab
	 * 
	 * @param Array $tabs The tabs
	 */
	public function add_tab( $tabs ) {
		$tabs[ 'custom-integration' ] = (object) array(
			'name'     => esc_html__( 'Custom integration', 'text-domain' ),
			'status'   => 'success', // Either "success" or empty
			'function' => array( $this, 'output' ),
		);

		return $tabs;
	}

	/**
	 * Creates the output of the settings page
	 */
	public function output() {
		// Check whether there is an account connected
		// Dummy data
		$is_connected = true;

		// Get user data
		// Dummy data
		$user_data = (object) array(
			'username' => 'johndoe',
			'name' => 'John Doe',
			'email_address' => 'johndoe@automatorplugin.com'
		);

		// oAuth URL
		$oauth_urls = (object) array(
			'connect' => 'https://...',
			'disconnect' => 'https://...',
		);

		// Load view
		include_once 'settings-view-sample.php';
	}
}
