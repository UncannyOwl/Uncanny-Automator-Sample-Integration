<?php

use Uncanny_Automator\Recipe;

/**
 * Class Add_Automator3_Integration
 */
class Add_Sample_Integration {
	use Recipe\Integrations;

	/**
	 * Add_Integration constructor.
	 */
	public function __construct() {
		$this->setup();
	}

	/**
	 *
	 */
	protected function setup() {
		$this->set_integration( 'AUTOMATOR_SAMPLE' );
		$this->set_name( 'Automator Sample' );
		$this->set_icon( 'automator-core-icon.svg' );
		$this->set_plugin_path( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'uncanny-automator-sample.php' );
	}

	/**
	 * Explicitly return true because WordPress is always active.
	 *
	 * @return bool
	 */
	public function plugin_active() {
		return true;
	}
}
