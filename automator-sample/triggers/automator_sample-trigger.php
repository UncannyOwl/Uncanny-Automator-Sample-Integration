<?php

use Uncanny_Automator\Recipe;


/**
 * Class Automator_Sample_Trigger
 */
class Automator_Sample_Trigger {
	use Recipe\Triggers;

	/**
	 * Automator_Sample_Trigger constructor.
	 */
	public function __construct() {
		$this->setup_trigger();
	}

	/**
	 *
	 */
	protected function setup_trigger() {
		$this->set_integration( 'AUTOMATOR_SAMPLE' );
		$this->set_trigger_code( 'VIEWPAGE_SAMPLE' );
		$this->set_trigger_meta( 'WPPAGE' );
		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( esc_attr__( 'A user views {{a page:%1$s}} from Sample Integration', 'uncanny-automator' ), $this->trigger_meta, 'NUMTIMES' ) );
		/* Translators: Some information for translators */
		$this->set_readable_sentence( esc_attr__( 'A user views {{a page}} from Sample Integration', 'uncanny-automator' ) );

		$this->add_action( 'template_redirect', 90 );

		$options = array(
			Automator()->helpers->recipe->wp->options->all_pages( null, $this->get_trigger_meta(), true ),
			Automator()->helpers->recipe->options->number_of_times(),
		);

		$this->set_options( $options );

		$this->register_trigger();
	}

	/**
	 * @return bool
	 */
	public function validate_trigger(): bool {

		if ( ! is_page() && ! is_archive() ) {
			return false;
		}

		return true;
	}

	/**
	 * @param mixed ...$args
	 */
	protected function prepare_to_run( ...$args ) {
		// Set Post ID here.
		global $post;
		$this->set_post_id( $post->ID );

	}
}
