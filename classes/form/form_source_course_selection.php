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

namespace local_rollover\form;

use local_rollover\rollover_parameters;
use moodleform;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * @package     local_rollover
 * @author      Daniel Thee Roperto <daniel.roperto@catalyst-au.net>
 * @copyright   2017 Catalyst IT Australia {@link http://www.catalyst-au.net}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class form_source_course_selection extends moodleform {
    /** @var string[] */
    private $usercourses;

    public function get_user_courses() {
        return $this->usercourses;
    }

    /**
     * @param string[] $usercourses Array of "your courses" to display,
     */
    public function __construct($usercourses = []) {
        $this->usercourses = $usercourses;
        parent::__construct();
    }

    private function prepare_options() {
        $options = [];

        foreach ($this->usercourses as $id => $course) {
            $options[$id] = "{$course->shortname}: {$course->fullname}";
        }

        return $options;
    }

    /**
     * Form definition.
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', rollover_parameters::PARAM_CURRENT_STEP);
        $mform->setType(rollover_parameters::PARAM_CURRENT_STEP, PARAM_INT);

        $mform->addElement('hidden', rollover_parameters::PARAM_DESTINATION_COURSE_ID);
        $mform->setType(rollover_parameters::PARAM_DESTINATION_COURSE_ID, PARAM_INT);

        $mform->addElement('select',
                           rollover_parameters::PARAM_SOURCE_COURSE_ID,
                           get_string('originalcourse', 'local_rollover'),
                           $this->prepare_options(),
                           ['id' => 'local_rollover-your_units', 'size' => 10]);
        $mform->setType(rollover_parameters::PARAM_SOURCE_COURSE_ID, PARAM_INT);
        $mform->addHelpButton(rollover_parameters::PARAM_SOURCE_COURSE_ID, 'originalcourse', 'local_rollover');

        $this->add_action_buttons(false, get_string('next'));
    }

    /**
     * Validate the parts of the request form for this module
     *
     * @param mixed[]  $data  An array of form data
     * @param string[] $files An array of form files
     * @return string[] of error messages
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        return $errors;
    }
}
