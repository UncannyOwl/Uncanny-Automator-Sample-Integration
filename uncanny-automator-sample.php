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
	if ( ! class_exists( '\Uncanny_Automator\Integration' ) ) {
		return;
	}

	require_once 'helpers/helpers.php';
	require_once 'sample-integration.php';
	require_once 'settings/settings-sample.php';
	require_once 'actions/send-email-sample.php';
	require_once 'triggers/post-created-sample.php';
	require_once 'triggers/anon-comment-submitted.php';

	
	$helpers = new Helpers();
	
	new Sample_Integration( $helpers );
	new Sample_Integration_Settings( $helpers );
	new Send_Email_Sample( $helpers );
	new Post_Created_Sample_Trigger( $helpers );
	new Comment_Submitted_Sample( $helpers );

	// Register an ajax endpoint for the get posts field
	add_action( 'wp_ajax_automator_sample_get_posts', array( $helpers, 'ajax_get_posts' ) );

}

add_action( 'automator_add_integration', 'sample_integration_load_files' );


