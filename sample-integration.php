<?php

/**
 * Class Add_Sample_Integration
 */
class Add_Sample_Integration extends Uncanny_Automator\Recipe\Integration {
	
	/**
	 *
	 */
	protected function setup() {
		$this->set_integration( 'AUTOMATOR_SAMPLE' );
		$this->set_name( 'Automator Sample Integration' );
		$this->set_icon( 'automator-core-icon.svg' );
		$this->set_icon_path( __DIR__ . '/img/' );
		$this->set_plugin_file_path( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'uncanny-automator-sample.php' );
		$this->set_external_integration( true );
	}

	/**
	 * Explicitly return true because this plugin code will only run if it's active.
	 * Add your own plugin active logic here, for example, check for a specific function exists before integration is
	 * returned as active.
	 *
	 * This is an option override. By default Uncanny Automator will check $this->get_plugin_file_path() to validate
	 * if plugin is active.
	 *
	 * @return bool
	 */
	public function plugin_active() {
		return true;
	}
}