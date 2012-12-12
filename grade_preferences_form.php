<?php

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
 * Kaltura video assignment grade preferences form
 *
 * @package    mod
 * @subpackage kalvidassign
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once(dirname(dirname(dirname(__FILE__))) . '/course/moodleform_mod.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once($CFG->libdir.'/formslib.php');

class gradepreferencesform extends moodleform {

    function definition() {
        global $CFG, $COURSE;

        $mform =& $this->_form;

        $mform->addElement('hidden', 'cmid', $this->_customdata['cmid']);

        $mform->addElement('header', 'kal_vid_subm_hdr', get_string('optionalsettings', 'kalvidassign'));

        $filters = array(KALASSIGN_ALL => get_string('all', 'kalvidassign'),
                                KALASSIGN_REQ_GRADING => get_string('reqgrading', 'kalvidassign'),
                                KALASSIGN_SUBMITTED => get_string('submitted', 'kalvidassign'));

        $mform->addElement('select', 'filter', get_string('show'), $filters);
        $mform->addHelpButton('filter', 'show', 'kalvidassign');

        $mform->addElement('text', 'perpage', get_string('pagesize', 'kalvidassign'), array('size' => 3, 'maxlength' => 3));
        $mform->setType('perpage', PARAM_INT);
        $mform->addHelpButton('perpage', 'pagesize', 'kalvidassign');

        $mform->addElement('checkbox', 'quickgrade', get_string('quickgrade', 'kalvidassign'));
        $mform->setDefault('quickgrade', '');
        $mform->addHelpButton('quickgrade', 'quickgrade', 'kalvidassign');

        $savepref = get_string('savepref', 'kalvidassign');

        $mform->addElement('submit', 'savepref', $savepref);

    }

    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (0 == (int) $data['perpage']) {
            $errors['perpage'] = get_string('invalidperpage', 'kalvidassign');
        }

        return $errors;
    }
}