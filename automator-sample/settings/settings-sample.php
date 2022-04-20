<?php

namespace Uncanny_Automator;

/**
 * Sample Integration Settings
 */
class Sample_Integration_Settings {
	/**
	 * This trait defines properties and methods shared across all the
	 * settings pages of Premium Integrations
	 */
	use Settings\Premium_Integrations;

	/**
	 * Creates the settings page
	 */
	public function __construct() {

		// Register the tab
		$this->setup_settings();

		// The methods above load even if the tab is not selected
		if ( ! $this->is_current_page_settings() ) {
			return;
		}

	}

	/**
	 * Sets up the properties of the settings page
	 */
	protected function set_properties() {
		
		// Define the ID
		// This should go first
		$this->set_id( 'sample-integration' );

		// Set the icon
		// This doesn't support images for now
		$this->set_icon( 'bolt' );

		// Set the name
		$this->set_name( 'Sample integration' );

		// Whether the user connected this integration
		$this->is_connected = false;

		// Status: either `success` or empty string
		$this->set_status( $this->is_connected ? 'success' : '' );

		// Add settings (optional)
		$this->register_option( 'uap_automator_sample_integration_name' );

	}

	/**
	 * Creates the output of the settings page
	 */
	public function output() {
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
