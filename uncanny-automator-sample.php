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

		add_filter( 'uncanny_automator_integrations', array( $this, 'add_this_integration' ) );
	}

	/**
	 * Add custom integration to Automator
	 *
	 * @throws Exception
	 */
	public function setup_integration() {
		$this->integration_dir = automator_add_integration( $this->directory );
	}

	/**
	 * Add integration and all related files to Automator so that it shows up under Triggers / Actions
	 *
	 * @param $directories
	 *
	 * @return mixed
	 */
	public function add_this_integration( $directories ) {
		$directories[ $this->integration_code ] = $this->integration_dir;

		return $directories;
	}
}

new Uncanny_Automator_Sample();
