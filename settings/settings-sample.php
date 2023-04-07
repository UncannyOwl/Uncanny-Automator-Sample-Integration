<?php

/**
 * Sample Integration Settings
 */
class Sample_Integration_Settings extends \Uncanny_Automator\Settings\Premium_Integration_Settings {

	public $helpers;
	private $api_key;
	private $is_connected;

	public function set_properties() {

		$this->helpers = array_shift( $this->dependencies );

		$this->set_id( 'sample-integration' );

		$this->set_icon( 'SAMPLE_INTEGRATION' );

		$this->set_name( 'Sample integration' );

		$this->register_option( 'some_sample_intgeration_setting' );

		add_action( 'init', array( $this, 'disconnect' ) );

	}

	public function get_status() {

		$this->is_connected = false;

		$this->api_key = get_option( 'some_sample_intgeration_setting', false );
		
		if ( false !== $this->api_key ) {
			$this->is_connected = true;
		}

		if ( false === $this->api_key ) {
			return '';
		}

		return 'success';
	}

	/**
	 * Creates the output of the settings page
	 */
	public function output_panel_content() {
		// Get user data
		$user_data = (object) array(
			'username' => 'johndoe',
			'name' => 'John Doe',
			'email_address' => 'johndoe@automatorplugin.com'
		);

		// oAuth URL
		$oauth_urls = (object) array(
			'connect' => 'https://...',
			'disconnect' => 'https://...',
		);

		if ( ! $this->is_connected ) {

			$args = array(
				'id'       => 'some_sample_intgeration_setting',
				'value'    => $this->api_key,
				'label'    => 'API key',
				'required' => true,
			);

			$this->text_input( $args );

		} else { ?>
			<p> <?php echo __( 'You have successfully connected!', 'automator-sample' ); ?> </p>
			<?php
		}

	}

	public function output_panel_bottom_right() {

		if ( ! $this->is_connected ) {
			$button_label = __( 'Save settings', 'automator-sample' );

			$this->submit_button( $button_label );
		} else {

			$button_label = __( 'Disconnect', 'automator-sample' );
			$link = $this->get_settings_page_url() . '&disconnect=1';

			$this->redirect_button( $button_label, $link );
		}
	}

	public function settings_updated() {

		$this->api_key = get_option( 'some_sample_intgeration_setting', false );

		if ( is_numeric( $this->api_key ) ) {
			$this->add_alert(
				array(
					'type'    => 'success',
					'heading' => __( 'Your API key is a number!', 'automator-sample' ),
					'content'  => 'Additional content'
				)
			);
		} else {
			$this->add_alert(
				array(
					'type'    => 'error',
					'heading' => __( 'Your API key is not a number!', 'automator-sample' ),
					'content' =>  __( 'The API key failed the numeric check', 'automator-sample' ),
				)
			);
		}

	}

	public function disconnect() {

		if ( ! $this->is_current_page_settings() ) {
			return;
		}

		if ( '1' !== automator_filter_input( 'disconnect' ) ) {
			return;
		}

		delete_option( 'some_sample_intgeration_setting' );

		wp_safe_redirect( $this->get_settings_page_url() );

		exit;
	}
}