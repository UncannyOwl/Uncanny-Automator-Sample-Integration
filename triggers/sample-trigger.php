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
		$this->set_trigger_meta( 'POST_TYPE' );
		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( esc_attr__( 'A {{a post type:%1$s}} is created sample trigger', 'automator-sample' ), 'POST_TYPE' ) );
		/* Translators: Some information for translators */
		$this->set_readable_sentence( esc_attr__( 'A {{a post type}} is created sample trigger', 'automator-sample' ) );

		$this->add_action( 'wp_after_insert_post', 90, 4 );

		$this->set_tokens(
			array(
				array(
					'tokenId'         => 'POST_TITLE',
					'tokenName'       => __( 'Post Title', 'automator-sample' ),
					'tokenType'       => 'text',
				),
				array(
					'tokenId'         => 'POST_URL',
					'tokenName'       => __( 'Post URL', 'automator-sample' ),
					'tokenType'       => 'text',
				),
			)
		);
	}

	public function load_options() {

		$POST_TYPE = array(
			'input_type'      => 'select',
			'option_code'     => 'POST_TYPE',
			'label'           => __( 'Post type', 'automator-sample' ),
			'required'        => true,
			'options'         => $this->helpers->get_post_types(),
			'placeholder' 	  => __( 'Please select a page', 'automator-sample' ),
		);

		return array(
			'options' => array(
				$POST_TYPE
			)
		);
	}

	/**
	 * maybe_add_recipe_specific_tokens
	 * 
	 * Alter this method if you want to add recipe-specific tokens that depend on values selected in the trigger options.
	 *
	 * @param  mixed $tokens
	 * @param  mixed $args
	 * @return void
	 */
	public function maybe_add_recipe_specific_tokens( $tokens, $args ) {
		return $tokens;
	}

	/**
	 * @return bool
	 */
	public function validate_trigger( $trigger, $hook_args ) {

		// Make sure the trigger has some value selected in the options
		if ( ! isset( $trigger['meta']['POST_TYPE'] ) ) {
			//Something is wrong, the trigger doesn't have the required option value.
			return false;
		}

		// Get the dropdown value
		$selected_post_type = $trigger['meta']['POST_TYPE'];

		// Parse the args from the wp_after_insert_post hook
		$post_id = array_shift( $hook_args );
		$post = array_shift( $hook_args );
		$update = array_shift( $hook_args ); 
		$post_before = array_shift( $hook_args ); 

		// If the post type selected in the trigger options doesn't match the post type being inserted, bail.
		if ( $selected_post_type !== $post->post_type ) {
			return false;
		}

		// Make sure the post is being published and not updated or drafted
		if ( ! $this->helpers->post_is_being_published( $post, $post_before ) ) {
			return false;
		}

		// If all conditions were met, return true
		return true;
	}


	public function hydrate_tokens( $trigger, $hook_args ) {

		$post_id = array_shift( $hook_args );
		$post = array_shift( $hook_args );

		$token_values = array(
			'POST_TYPE' => $trigger['meta']['POST_TYPE'],
			'POST_TITLE' => $post->post_title,
			'POST_URL' => get_permalink( $post->ID )
		); 

		return $token_values;
	}

}