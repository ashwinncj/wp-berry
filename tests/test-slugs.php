<?php
/**
 * Class SampleTest
 *
 * @package Wp_Berry
 */

use WPBerry\Tickets;

class SlugsTest extends WP_UnitTestCase {

	/**
	 * Test that the slugs are modified as per the taxonomy.
	 */
	public function testSlugsAreModifiedAsExpected() {
		// ToDo: Update this test case to test for the slugs.
		$ticket_obj = new Tickets();
		$term       = wp_insert_term( 'testproject', BERRY_PROJECT_TAXONOMY );
		$args       = array(
			'post_type' => BERRY_CPT,
			'tax_input' => array(
				BERRY_PROJECT_TAXONOMY => array( $term['term_id'] ),
			),
		);
		$post       = static::factory()->post->create_and_get( $args );
		$response   = wp_set_post_terms( $post->ID, $term['term_id'], BERRY_PROJECT_TAXONOMY );
		$slug       = $ticket_obj->get_new_slug_for_ticket( $post->ID );
		$this->assertContains( 'testproject-1', $slug );
	}

	/**
	 * Verify if the default slug is applied if no Taxonomy is selected.
	 *
	 * @return void
	 */
	public function testDefaultSlugIsAppliedIfNoTaxonomy() {
		$ticket_obj = new Tickets();
		$post       = static::factory()->post->create_and_get( array( 'post_type' => 'berry' ) );
		$slug       = $ticket_obj->get_new_slug_for_ticket( $post->ID );
		$this->assertContains( 'triage', $slug );
	}

	/**
	 * Test if Slugs are returned from the function.
	 *
	 * @return void
	 */
	public function testSlugsAreReturnedCorrectly() {
		$method = new ReflectionMethod( new Tickets(), 'get_new_slug_for_ticket' );
		$method->setAccessible( true );
		$post = static::factory()->post->create_and_get( array( 'post_type' => 'berry' ) );
		$slug = $method->invoke( new Tickets(), $post->ID );
		$this->assertContains( 'triage', $slug );
	}

	/**
	 * Test if the function verifies if the Project is updated in a ticket.
	 *
	 * @return void
	 */
	public function testProjectUpdateVerificationIsCorrect() {
		$method = new ReflectionMethod( new Tickets(), 'check_if_project_is_updated' );
		$method->setAccessible( true );
		$post = static::factory()->post->create_and_get( array( 'post_type' => 'berry' ) );

		$project_updated = $method->invoke( new Tickets(), $post->ID, 'wpdt-12' );
		$this->assertTrue( $project_updated );

		$project_updated = $method->invoke( new Tickets(), $post->ID, 'triage-12' );
		$this->assertFalse( $project_updated );

	}
}
