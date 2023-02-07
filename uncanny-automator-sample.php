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


function sample_integration_load_files() {
	// If this class doesn't exist Uncanny Automator plugin needs to be updated.
	if ( ! class_exists( 'Uncanny_Automator\Recipe\Integration' ) ) {
		return;
	}

	require_once 'helpers/helpers.php';
	$helpers = new Helpers();

	require_once 'sample-integration.php';
	new Add_Sample_Integration( $helpers );

	require_once 'settings/settings-sample.php';
	new Sample_Integration_Settings( $helpers );

	require_once 'actions/sample-action.php';
	new Automator_Sample_Action( $helpers );

	require_once 'triggers/sample-trigger.php';
	new Automator_Sample_Trigger( $helpers );
	
}

add_action( 'automator_add_integration', 'sample_integration_load_files' );

