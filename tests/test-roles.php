<?php
/**
 * Class SampleTest
 *
 * @package Wp_Berry
 */

use WPBerry\Settings;

class RolesTest extends WP_UnitTestCase {

	/**
	 * Test to berify that administrator users are `berry_admin` and editors are `berr_user`
	 */
	public function testRolesAreAppledToAdminAndEditor() {
		berry_activation();
		$admin = get_role( 'administrator' );
		$this->assertTrue( $admin->has_cap( 'berry_admin' ) );

		$editor = get_role( 'editor' );
		$this->assertTrue( $editor->has_cap( 'berry_user' ) );

	}
}
