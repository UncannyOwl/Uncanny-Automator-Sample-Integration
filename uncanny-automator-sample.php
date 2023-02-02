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


if ( class_exists( 'Uncanny_Automator\Recipe\Integration' ) ) {
	add_action( 'automator_configuration_complete', function() {

		require_once 'sample-integration.php';
		require_once 'actions/sample-action.php';
		require_once 'triggers/sample-trigger.php';
		require_once 'settings/settings-sample.php';
	});
}



