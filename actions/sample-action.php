<?php

/**
 * Class Automator_Sample_Action
 */
class Automator_Sample_Action extends Uncanny_Automator\Recipe\Action {

	/**
	 *
	 */
	protected function setup_action() {

		$this->set_integration( 'AUTOMATOR_SAMPLE' );
		$this->set_action_code( 'SAMPLE_SENDEMAIL' );
		$this->set_action_meta( 'SAMPLE_EMAILTO' );

		/* translators: Action - WordPress */
		$this->set_sentence( sprintf( esc_attr__( 'Send an email to {{email address:%1$s}} from Sample Integration', 'uncanny-automator' ), $this->get_action_meta() ) );
		/* translators: Action - WordPress */
		$this->set_readable_sentence( esc_attr__( 'Send an {{email}} from Sample Integration', 'uncanny-automator' ) );
		$options_group = array(
			$this->get_action_meta() => array(
				/* translators: Email field */
				Automator()->helpers->recipe->field->text(
					array(
						'option_code' => 'SAMPLE_EMAILFROM',
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
						'option_code' => 'SAMPLE_EMAILTO',
						'label'       => 'To',
						'input_type'  => 'email',
					)
				),
				/* translators: Email field */
				Automator()->helpers->recipe->field->text(
					array(
						'option_code' => 'SAMPLE_EMAILCC',
						'label'       => 'CC',
						'input_type'  => 'email',
						'required'    => false,
					)
				),
				/* translators: Email field */
				Automator()->helpers->recipe->field->text(
					array(
						'option_code' => 'SAMPLE_EMAILBCC',
						'label'       => 'BCC',
						'input_type'  => 'email',
						'required'    => false,
					)
				),
				/* translators: Email field */
				Automator()->helpers->recipe->field->text(
					array(
						'option_code' => 'SAMPLE_EMAILSUBJECT',
						'label'       => 'Subject',
						'input_type'  => 'text',
					)
				),
				/* translators: Email field */
				Automator()->helpers->recipe->field->text(
					array(
						'option_code' => 'SAMPLE_EMAILBODY',
						'label'       => 'Body',
						'input_type'  => 'textarea',
					)
				),
			),
		);

		$this->set_options_group( $options_group );

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
		// Parsing fields to return an actual value from token
		$data = array(
			'to'      => Automator()->parse->text( $action_meta['SAMPLE_EMAILTO'], $recipe_id, $user_id, $args ),
			'from'    => Automator()->parse->text( $action_meta['SAMPLE_EMAILFROM'], $recipe_id, $user_id, $args ),
			'cc'      => Automator()->parse->text( $action_meta['SAMPLE_EMAILCC'], $recipe_id, $user_id, $args ),
			'bcc'     => Automator()->parse->text( $action_meta['SAMPLE_EMAILBCC'], $recipe_id, $user_id, $args ),
			'subject' => Automator()->parse->text( $action_meta['SAMPLE_EMAILSUBJECT'], $recipe_id, $user_id, $args ),
			'body'    => Automator()->parse->text( $action_meta['SAMPLE_EMAILBODY'], $recipe_id, $user_id, $args ),
		);
		// Prepare mail
		$this->set_mail_values( $data );

		// Send mail
		$mailed = $this->send_email();
		// If there was an error, it'll be logged in action log with an error message.
		if ( is_automator_error( $mailed ) ) {
			$error_message = $this->get_error_message();
			// Complete action with errors and log Error message.
			Automator()->complete->action( $user_id, $action_data, $recipe_id, $error_message );
		}
		// Everything went fine. Complete action.
		Automator()->complete->action( $user_id, $action_data, $recipe_id );
	}
}

new Automator_Sample_Action();