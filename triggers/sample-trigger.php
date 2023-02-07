<?php

/**
 * Class Automator_Sample_Trigger
 */
class Automator_Sample_Trigger extends Uncanny_Automator\Recipe\Trigger {

	/**
	 *
	 */
	protected function setup_trigger() {

		$this->set_integration( 'AUTOMATOR_SAMPLE' );
		$this->set_trigger_code( 'POST_CREATED_SAMPLE' );
		$this->set_trigger_meta( 'POST_TYPES_DROPDOWN' );
		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( esc_attr__( 'A {{a post type:%1$s}} is created sample trigger', 'automator-sample' ), 'POST_TYPES_DROPDOWN' ) );
		/* Translators: Some information for translators */
		$this->set_readable_sentence( esc_attr__( 'A {{a post type}} is created sample trigger', 'automator-sample' ) );

		$this->add_action( 'wp_after_insert_post', 90, 4 );
	}

	public function load_options() {

		$post_types_dropdown = array(
			'input_type'      => 'select',
			'option_code'     => 'POST_TYPES_DROPDOWN',
			'label'           => __( 'Post type', 'automator-sample' ),
			'required'        => true,
			'options'         => $this->helpers->get_post_types(),
			'placeholder' 	  => __( 'Please select a page', 'automator-sample' ),
		);

		return array(
			'options' => array(
				$post_types_dropdown
			)
		);
	}

	/**
	 * @return bool
	 */
	public function validate_trigger( $trigger, $hook_args ) {

		// Parse the args from the wp_after_insert_post hook
		$post_id = array_shift( $hook_args );
		$post = array_shift( $hook_args );
		$update = array_shift( $hook_args ); 
		$post_before = array_shift( $hook_args ); 

		// Make sure the trigger has some value selected in the options
		if ( ! isset( $trigger['meta']['POST_TYPES_DROPDOWN'] ) ) {
			//Something is wrong, the trigger doesn't have the required option value.
			return false;
		}

		// Get the dropdown value
		$selected_post_type = $trigger['meta']['POST_TYPES_DROPDOWN'];

		// If the post type selected in the trigger options doesn't match the post type being inserted, bail.
		if ( $selected_post_type !== $post->post_type ) {
			return false;
		}

		// Make sure the post is being published and not updated or drafted
		if ( ! $this->post_is_being_published( $post, $post_before ) ) {
			return false;
		}

		// If all conditions were met, return true
		return true;
	}

	public function process_tokens( $trigger, $hook_args, $trigger_log_entry ) {

		elog( 'process_tokens' );
		elog( $trigger, '$trigger' );
		elog( $hook_args, '$hook_args' );
		elog( $trigger_log_entry, '$trigger_log_entry' );
	}
}