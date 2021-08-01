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

		$editor = get_role( 'editor' );
		$admin = get_role( 'administrator' );
		$this->assertTrue( $admin->has_cap( 'berry_admin' ) );
		$this->assertTrue( $editor->has_cap( 'berry_user' ) );

	}

    public function testBerryUserRoleExists() {
        $berry_role = get_role( 'berry_user' );
        $this->assertNotEmpty( $berry_role );
    }
}
