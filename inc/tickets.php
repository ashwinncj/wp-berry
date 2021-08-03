<?php

namespace WPBerry;

class Tickets {

	public function __construct() {
		add_action( 'save_post', array( $this, 'modify_slug_on_save' ), 10, 3 );
	}


	/**
	 * Function to intercept the new post addition and update the slug to match the taxonomy.
	 *
	 * @param int    $post_id Post ID.
	 * @param object $post Post object.
	 * @param bool   $update Flag if post is being updated.
	 * @return void
	 */
	public function modify_slug_on_save( $post_id, $post, $update ) {
		// Allow only 'publish', 'draft', 'future' to process or return.
		if ( 'berry' !== $post->post_type || 'auto-draft' === $post->post_status ) {
			return;
		}

		if ( ! $this->check_if_project_is_updated( $post_id, get_post_field( 'post_name', $post_id ) ) ) {
			return;
		}

		$new_slug = $this->get_new_slug_for_ticket( $post_id );
		if ( $new_slug === $post->post_name ) {
			return;
		}

		// Unhook this function to prevent infinite looping.
		remove_action( 'save_post', array( $this, 'modify_slug_on_save' ), 10, 3 );
		// Update the post slug (WP handles unique post slug).
		wp_update_post(
			array(
				'ID'        => $post_id,
				'post_name' => $new_slug,
			)
		);
		// re-hook this function.
		add_action( 'save_post', array( $this, 'modify_slug_on_save' ), 10, 3 );
	}

	/**
	 * Gets new slug for the ticket.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public function get_new_slug_for_ticket( $post_id ) {
		// Get post terms registered for the post under BERRY_PROJECT_TAXONOMY.
		$terms = get_the_terms( $post_id, BERRY_PROJECT_TAXONOMY );

		if ( empty( $terms ) ) {
			$triage_term = get_term_by( 'slug', 'triage', BERRY_PROJECT_TAXONOMY, ARRAY_A );
			if ( empty( $triage_term ) ) {
				$triage_term = wp_insert_term( 'Triage', BERRY_PROJECT_TAXONOMY );
			}
			wp_set_post_terms( $post_id, array( $triage_term['term_id'] ), BERRY_PROJECT_TAXONOMY );
			return $this->get_incremental_for_slug( 'TRIAGE' );
		}

		// From the terms, select the first one and get its slug.
		return $this->get_incremental_for_slug( $terms[0]->slug );

	}

	/**
	 * Get the incremented value for the slug of the ticket.
	 *
	 * @param string $slug Ticket slug.
	 * @return string
	 */
	protected function get_incremental_for_slug( $slug ) {
		$slug = strtolower( $slug );
		// Get the last post inserted( ticket created ) based on the taxonommy slug and get the number at the end of its post slug.
		$last_ticket_number = (int) get_option( 'berry_' . $slug . '_ticket_log' );

		if ( empty( $last_ticket_number ) ) {
			$last_ticket_number = 0;
		}
		$incremented_ticket = ( $last_ticket_number + 1 );
		update_option( 'berry_' . $slug . '_ticket_log', $incremented_ticket );
		return $slug . '-' . $incremented_ticket;
	}

	/**
	 * Checks if the project is being updated on the ticket and returns the result.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $ticket_slug Slug of the ticket.
	 * @return bool
	 */
	protected function check_if_project_is_updated( $post_id, $ticket_slug ) {
		$terms = get_the_terms( $post_id, BERRY_PROJECT_TAXONOMY );

		if ( empty( $terms ) ) {
			return true;
		}

		$project = $terms[0]->slug;

		if ( preg_match( '/^' . $project . '-(\d*$)/', $ticket_slug ) ) {
			return false;
		}

		return true;
	}
}

new Tickets();
