<?php

/**
 * Sample Integration Settings
 */
class Sample_Integration_Settings  extends Uncanny_Automator\Settings\Premium_Integration_Settings {

	public function set_properties() {

		$this->set_id( 'sample-integration' );

		$this->set_icon( __DIR__ . 'img\automator-core-icon.svg'  );

		$this->set_name( 'Sample integration' );

		//$this->register_option( 'some_sample_intgeration_setting' );

	}

	public function get_status() {
		return 'success';
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