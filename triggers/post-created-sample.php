<?php

/**
 * Class Post_Created_Sample_Trigger
 */
class Post_Created_Sample_Trigger extends Uncanny_Automator\Recipe\Trigger {

	/**
	 * This is a logged-in trigger example that requires a user and allows counting/limiting how many times a user can
	 * trigger the recipe. Logged-in recipes also allow using multiple triggers in a single recipe.
	 *
	 */
	protected function setup_trigger() {

		$this->set_integration( 'SAMPLE_INTEGRATION' );
		$this->set_trigger_code( 'POST_CREATED_SAMPLE' );
		$this->set_trigger_meta( 'POST_TYPE' );
		/* Translators: post type */
		$this->set_sentence( sprintf( esc_attr__( '{{A post type:%1$s}} is created sample trigger', 'automator-sample' ), 'POST_TYPE' ) );
		/* Translators: post type */
		$this->set_readable_sentence( esc_attr__( '{{A post type}} is created sample trigger', 'automator-sample' ) );

		$this->add_action( 'wp_after_insert_post', 90, 4 );
	}

	public function load_options() {

		$post_types_dropdown = array(
			'input_type'      => 'select',
			'option_code'     => 'POST_TYPE',
			'label'           => __( 'Post type', 'automator-sample' ),
			'required'        => true,
			'options'         => $this->helpers->get_post_types(),
			'placeholder' 	  => __( 'Please select a post type', 'automator-sample' ),
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
		if (  '-1' != $selected_post_type && $selected_post_type !== $post->post_type ) {
			return false;
		}

		// Make sure the post is being published and not updated or drafted
		if ( ! $this->helpers->post_is_being_published( $post, $post_before ) ) {
			return false;
		}

		// If all conditions were met, return true
		return true;
	}

	/**
	 * additional_tokens
	 * 
	 * Alter this method if you want to add some additional tokens.
	 *
	 * @param  mixed $tokens
	 * @param  mixed $trigger - options selected in the current recipe/trigger
	 * @return array
	 */
	public function additional_tokens( $tokens, $trigger ) {

		$tokens[] = array(
			'tokenId'         => 'POST_TITLE',
			'tokenName'       => __( 'Post Title', 'automator-sample' ),
			'tokenType'       => 'text',
		);

		$tokens[] = array(
			'tokenId'         => 'POST_URL',
			'tokenName'       => __( 'Post URL', 'automator-sample' ),
			'tokenType'       => 'text',
		);

		return $tokens;
	}
	
	/**
	 * hydrate_tokens
	 * 
	 * Here you need to pass the values for the trigger tokens.
	 * Note that each token field also has a token that has to be populated in this method.
	 *
	 * @param  mixed $trigger
	 * @param  mixed $hook_args
	 * @return void
	 */
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