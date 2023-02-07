<?php 

class Helpers {

    /**
	 * get_post_types
	 *
	 * Returns an array of registered post types.
	 * 
	 * @return void
	 */
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
	 * post_is_being_published
	 * 
	 * Checks if the post status changed from non 'publish' to 'publish'
	 *
	 * @param  mixed $post
	 * @param  mixed $post_before
	 * @return void
	 */
	public function post_is_being_published( $post, $post_before ) {

		// If this post is not published yet, bail
		if ( 'publish' !== $post->post_status ) {
			return false;
		}

		// If this post was published before, bail
		if ( ! empty( $post_before->post_status ) && 'publish' === $post_before->post_status ) {
			return false;
		}
		
		// Otherwise, return true
		return true;
	}
}