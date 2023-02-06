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
		$this->set_sentence( sprintf( esc_attr__( 'A Sample {{a post type:%1$s}} is created action', 'automator-sample' ), 'POST_TYPES_DROPDOWN' ) );
		/* Translators: Some information for translators */
		$this->set_readable_sentence( esc_attr__( 'A sample {{a post type}} is created action', 'automator-sample' ) );

		$this->add_action( 'wp_after_insert_post', 90, 4 );

		$this->set_options_callback( array( $this, 'load_options' ) );
	}

	public function load_options() {

		$post_types_dropdown = array(
			'input_type'      => 'select',
			'option_code'     => 'POST_TYPES_DROPDOWN',
			'label'           => __( 'Post type', 'automator-sample' ),
			'required'        => true,
			'options'         => $this->get_post_types(),
			'placeholder' 	  => __( 'Please select a page', 'automator-sample' ),
		);

		return array(
			'options' => array(
				$post_types_dropdown
			)
		);
	}

	public function get_post_types() {

		$options = array();

		$post_types = get_post_types();

		foreach ( $post_types as $type ) {

			$options[] = array(
				'text' => $type,
				'value' => $type
			);
		}

		return $options;
	}

	/**
	 * @return bool
	 */
	public function validate_trigger( ...$args ) {

		// Get the data passed to the wp_after_insert_post hook
		$hook_data = array_shift( $args );

		$post_id = array_shift( $hook_data );
		$post = array_shift( $hook_data ); 
		$update = array_shift( $hook_data ); 
		$post_before = array_shift( $hook_data ); 

		// If this post was published before, bail
		if ( ! empty( $post_before->post_status ) && 'publish' === $post_before->post_status ) {
			return false;
		}

		// If this post is not published yet, bail
		if ( 'publish' !== $post->post_status ) {
			return false;
		}

		// If all conditions were met, return true
		return true;
	}

	/**
	 * Prepare to run the trigger.
	 *
	 * @param $data
	 *
	 * @return void
	 */
	public function prepare_to_run( $data ) {

		// If there are any fields we need to check before we fire the trigger, we need to set this trigger to a conditional one.
		$this->set_conditional_trigger( true );

	}

	public function validate_conditions( $args ) {

		elog( $args, 'validate_conditions' );

		$post_id = array_shift( $args );
		$post = array_shift( $args ); 
		$update = array_shift( $args ); 
		$post_before = array_shift( $args );

		$matching_recipes_triggers = $this->find_all( $this->trigger_recipes() )
			->where( array( 'POST_TYPES_DROPDOWN' ) )
			->match( array( $post->post_type ) )
			->get();

		return $matching_recipes_triggers;

	}

	// protected function process_trigger( $args ) {

	// 	elog( $args, 'process_trigger' );

	// 	$post_id = array_shift( $args );
	// 	$post = array_shift( $args ); 
	// 	$update = array_shift( $args ); 
	// 	$post_before = array_shift( $args );

	// 	$matched_recipes = $this->get_trigger_recipes_with_meta( 'POST_TYPES_DROPDOWN' );

	// 	elog( $matched_recipes, '$matched_recipes' );

	// 	foreach ( $matched_recipes as $recipe_id => $triggers ) {

	// 		foreach ( $triggers as $trigger_id => $meta_value ) {
	// 			if ( $post->post_type === $meta_value ) {
	// 				Automator()->process->user->maybe_trigger_complete( $result['args'] );
	// 			}
	// 		}

	// 	}

	// 	//Automator()->complete->trigger( $args );
	// }
}

new Automator_Sample_Trigger();