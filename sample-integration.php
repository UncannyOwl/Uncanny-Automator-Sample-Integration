<?php

/**
 * Class Add_Sample_Integration
 */
class Add_Sample_Integration extends Uncanny_Automator\Recipe\Integration {
	
	/**
	 *
	 */
	protected function setup() {
		$this->set_integration( 'SAMPLE_INTEGRATION' );
		$this->set_name( 'Automator Sample Integration' );
		$this->set_icon( 'sample-icon.svg' );
		$this->set_icon_path( __DIR__ . '/img/' );
		$this->set_plugin_file_path( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'uncanny-automator-sample.php' );
		$this->set_external_integration( true );
	}
}