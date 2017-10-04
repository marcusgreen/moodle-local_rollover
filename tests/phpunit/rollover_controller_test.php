<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_rollover
 * @author      Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright   2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_rollover\rollover_controller;
use local_rollover\tests\mock_output;
use local_rollover\tests\rollover_testcase;

defined('MOODLE_INTERNAL') || die();

class local_rollover_rollover_controller_test extends rollover_testcase {
    public function test_it_requires_capability_to_rollover() {
        $this->markTestSkipped('Test/Feature not yet implemented.');
    }

    public function test_it_has_the_rollover_source_route() {
        self::setAdminUser();
        $this->resetAfterTest(true);
        $course = $this->generator()->create_course();

        $_GET['into'] = $course->id;

        $controller = new rollover_controller();
        $controller->set_output(new mock_output());

        ob_start();
        $controller->rollover_source_selection_page();
        $html = ob_get_clean();

        self::assertContains('[header]', $html);
        self::assertContains('[footer]', $html);
    }
}
