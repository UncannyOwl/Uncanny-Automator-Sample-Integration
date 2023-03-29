<?php

/**
 * Plugin Name:       Uncanny Automator Sample Integration
 */

add_action( 'automator_add_integration', 'sample_integration_load_files' );

function sample_integration_load_files() {
	// If this class doesn't exist Uncanny Automator plugin needs to be updated.
	if ( ! class_exists( '\Uncanny_Automator\Integration' ) ) {
		return;
	}

	require_once 'helpers/helpers.php';
	$helpers = new Helpers();

	require_once 'sample-integration.php';
	new Sample_Integration( $helpers );

	require_once 'settings/settings-sample.php';
	new Sample_Integration_Settings( $helpers );

	require_once 'actions/send-email-sample.php';
	new Send_Email_Sample( $helpers );

	require_once 'triggers/post-created-sample.php';
	new Post_Created_Sample_Trigger( $helpers );

	require_once 'triggers/anon-comment-submitted.php';
	new Comment_Submitted_Sample( $helpers );
	
	// Register an ajax endpoint for the get posts field
	add_action( 'wp_ajax_automator_sample_get_posts', array( $helpers, 'ajax_get_posts' ) );

}

add_action( 'automator_add_integration', 'sample_integration_load_files' );


