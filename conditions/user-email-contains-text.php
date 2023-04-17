<?php

/**
 * Class User_Email_Contains_Text
 */

class User_Email_Contains_Text extends \Uncanny_Automator_Pro\Action_Condition {

	public function define_condition() {

		$this->integration = 'SAMPLE_INTEGRATION';
		$this->name         = __( 'User email contains text', 'automator-sample' );
		$this->code         = 'USER_EMAIL_CONTAINS_TEXT';
		$this->dynamic_name = sprintf(
			esc_html__( 'User email contains {{text:%s}}', 'automator-sample' ),
			'TEXT'
		);

		$this->requires_user = true;
	}

	/**
	 * Method fields
	 *
	 * @return array
	 */
	public function fields() {

		return array(
			// The text field
			$this->field->text(
				array(
					'option_code'            => 'TEXT',
					'label'                  => esc_html__( 'Text', 'automator-sample' ),
					'show_label_in_sentence' => true,
					'placeholder'            => esc_html__( 'Text', 'automator-sample' ),
					'input_type'             => 'text',
					'required'               => true,
					'description'            => '',
				)
			)
		);
	}

	/**
	 * Evaluate_condition
	 *
	 * Has to use the $this->condition_failed( $message ); method if the condition is not met.
	 *
	 * @return void
	 */
	public function evaluate_condition() {

		$text = mb_strtolower( $this->get_parsed_option( 'TEXT' ) );

        $user_data = get_userdata( $this->user_id );
        
        $user_email = mb_strtolower( $user_website->email );

		// If the conditions is not met, send an error message and mark the condition as failed.
		if ( false === strpos( $user_email, $text ) ) {

			$this->condition_failed( sprintf( __( 'User email "%s" doesn\'t contain "%s"', 'automator-sample' ), $user_website, $text ) );

		}

		// If the condition is met, do nothing.
	}
}
