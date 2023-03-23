<?php

/**
 * Class Send_Email_Sample
 */
class Send_Email_Sample extends \Uncanny_Automator\Recipe\Action {

	/**
	 *
	 */
	protected function setup_action() {

		$this->set_integration( 'SAMPLE_INTEGRATION' );
		$this->set_action_code( 'SEND_EMAIL_SAMPLE' );
		$this->set_action_meta( 'EMAIL_TO' );

		/* translators: Action - WordPress */
		$this->set_sentence( sprintf( esc_attr__( 'Send an email to {{email address:%1$s}} from Sample Integration', 'automator-sample' ), $this->get_action_meta() ) );
		/* translators: Action - WordPress */
		$this->set_readable_sentence( esc_attr__( 'Send an {{email}} from Sample Integration', 'automator-sample' ) );
		
	}

	public function options() {

		return array(
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_FROM',
					'label'       => 'From',
					'description' => 'Sample description',
					'placeholder' => 'Enter from email',
					'input_type'  => 'email',
					'default'     => 'john@doe.com',
				)
			),
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_TO',
					'label'       => 'To',
					'input_type'  => 'email',
				)
			),
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_CC',
					'label'       => 'CC',
					'input_type'  => 'email',
					'required'    => false,
				)
			),
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_BCC',
					'label'       => 'BCC',
					'input_type'  => 'email',
					'required'    => false,
				)
			),
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_SUBJECT',
					'label'       => 'Subject',
					'input_type'  => 'text',
				)
			),
			/* translators: Email field */
			Automator()->helpers->recipe->field->text(
				array(
					'option_code' => 'EMAIL_BODY',
					'label'       => 'Body',
					'input_type'  => 'textarea',
				)
			),
		);
	}

	/**
	 * @param int $user_id
	 * @param array $action_data
	 * @param int $recipe_id
	 * @param array $args
	 * @param $parsed
	 */
	protected function process_action( $user_id, $action_data, $recipe_id, $args, $parsed ) {

		$action_meta = $action_data['meta'];

		$to = sanitize_email( Automator()->parse->text( $action_meta['EMAIL_TO'], $recipe_id, $user_id, $args ) );
		$from = sanitize_email( Automator()->parse->text( $action_meta['EMAIL_FROM'], $recipe_id, $user_id, $args ) );
		$subject = sanitize_text_field( Automator()->parse->text( $action_meta['EMAIL_SUBJECT'], $recipe_id, $user_id, $args ) );
		$body = wp_filter_post_kses( stripslashes( ( Automator()->parse->text( $action_meta['EMAIL_BODY'], $recipe_id, $user_id, $args ) ) ) );
		$headers = array( 
			'Content-Type: text/html; charset=utf-8',
			'From: ' . get_bloginfo('name') . ' <' . $from . '>',
			'Reply-To: ' . get_bloginfo('name') . ' <' . $from . '>',
		 );

		$success = wp_mail( $to, $subject, $body, $headers );

		if ( ! $success ) {
			$this->add_log_error( __( 'Email was not sent', 'automator-sample' ) );
			return false;
		}

		return true;

	}
}