<?php 

/**
 * Class Sample_Integration_Helpers
 */
class Sample_Integration_Helpers {
	/**
	 * Sample_Integration_Helpers constructor.
	 */
	public function __construct() {
		// Load settings
		$this->load_settings();
	}

	/**
	 * Load the settings
	 * 
	 * @return void
	 */
	private function load_settings() {
		include_once __DIR__ . '/../settings/settings-sample.php';
		new Sample_Integration_Settings();
	}
}

new Sample_Integration_Helpers();
