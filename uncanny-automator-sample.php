<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName

/**
 * @wordpress-plugin
 * Plugin Name:       Uncanny Automator Sample Integration
 * Plugin URI:        https://www.automatorplugin.com
 * Description:       Sample integration plugin for Uncanny Automator
 * Version:           1.0.0
 * Author:            Uncanny Automator
 * Author URI:        https://www.automatorplugin.com
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       automator-sample
 * Domain Path:       /languages
 */
class Uncanny_Automator_Sample {
	/**
	 * @var
	 */
	public $integration_dir;
	/**
	 * @var string
	 */
	public $integration_code = 'automator-sample';
	/**
	 * @var string
	 */
	public $directory;

	/**
	 * Uncanny_Automator_Sample constructor.
	 */
	public function __construct() {
		$this->directory = __DIR__ . DIRECTORY_SEPARATOR . $this->integration_code;
		/**
		 * Waiting for the Automator to load.
		 */
		add_action( 'plugins_loaded', array( $this, 'setup_integration' ) );

		add_filter( 'automator_integrations_setup', array( $this, 'add_this_integration' ) );
	}

	/**
	 * Add custom integration to Automator
	 *
	 * @throws Exception
	 */
	public function setup_integration() {
		if ( function_exists( 'automator_add_integration' ) ) {
			$this->integration_dir = automator_add_integration( $this->directory );
		} else {
			trigger_error( 'automator_add_integration() function not found. Please upgrade Uncanny Automator to version 3.0+' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
		}
	}

	/**
	 * Add integration and all related files to Automator so that it shows up under Triggers / Actions
	 *
	 * @param $directories
	 *
	 * @return array
	 */
	public function add_this_integration( $directories ) {
		// validate
		if ( empty( $this->integration_dir ) ) {
			return $directories;
		}
		if ( empty( $this->integration_code ) ) {
			return $directories;
		}

		return automator_add_integration_directory( $this->integration_code, $this->integration_dir, $directories );
	}
}

new Uncanny_Automator_Sample();
