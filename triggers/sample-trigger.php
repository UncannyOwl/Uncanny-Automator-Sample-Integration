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
		$this->set_trigger_code( 'VIEWPAGE_SAMPLE' );
		$this->set_trigger_meta( 'WPPAGE' );
		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( esc_attr__( 'A user views {{a page:%1$s}} from Sample Integration', 'automator-sample' ), $this->get_trigger_meta(), 'NUMTIMES' ) );
		/* Translators: Some information for translators */
		$this->set_readable_sentence( esc_attr__( 'A user views {{a page}} from Sample Integration', 'automator-sample' ) );

		$this->add_action( 'template_redirect', 90 );

		$this->set_options_callback( array( $this, 'load_options' ) );
	}

	public function load_options() {

		$wp_pages_dropdown = array(
			'input_type'      => 'select',
			'option_code'     => $this->get_trigger_meta(),
			'label'           => __( 'Page', 'automator-sample' ),
			'required'        => true,
			'options'         => $this->get_wp_pages(),
			'placeholder' 	  => __( 'Please select a page', 'automator-sample' ),
		);

		return array(
			'options' => array(
				$wp_pages_dropdown
			)
		);
	}

	public function get_wp_pages() {

		$options = array();

		$wp_pages = get_pages();

		foreach ( $wp_pages as $page ) {

			if ( 'publish' !== $page->post_status ) {
				continue;
			}

			$options[] = array(
				'text' => $page->post_title,
				'value' => $page->ID
			);
		}

		return $options;
	}

	/**
	 * @return bool
	 */
	public function validate_trigger( ...$args ) {

		if ( ! is_page() && ! is_archive() ) {
			return false;
		}

		return true;
	}

	/**
	 * @param mixed ...$args
	 */
	protected function prepare_to_run( $args ) {
		// Set Post ID here.
		global $post;
		$this->set_post_id( $post->ID );

	}
}

new Automator_Sample_Trigger();