<?php
// This file is part of Moodle - http://moodle.org/
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
 *
*
* @package    local
* @subpackage paperattendance
* @copyright  2016 Jorge Cabané (jcabane@alumnos.uai.cl) 					
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
//Pertenece al plugin PaperAttendance
defined('MOODLE_INTERNAL') || die();
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');
require_once($CFG->libdir . "/formslib.php");
class upload_form extends moodleform {
	/**
	 * Defines forms elements
	 */
	public function definition() {
		global $CFG, $DB;
		
		$mform = $this->_form;

<<<<<<< HEAD
		//retrieve course id
		$instance = $this ->_customdata;
		$courseid = $instance['courseid'];
		$maxbytes = 6000000;
=======
		//$maxbytes = $course->maxbytes;
>>>>>>> refs/remotes/webcursosuai/master
		
		//header
		$mform->addElement('header', 'header', get_string('header', 'local_paperattendance'));
		//uploader
		$sqlteachers = "SELECT u.id, CONCAT (u.firstname, ' ', u.lastname)AS name
					FROM {user} u
					INNER JOIN {role_assignments} ra ON (ra.userid = u.id)
					INNER JOIN {context} ct ON (ct.id = ra.contextid)
					INNER JOIN {course} c ON (c.id = ct.instanceid AND c.id = ?)
					INNER JOIN {role} r ON (r.id = ra.roleid AND r.shortname IN ('teacher', 'editingteacher'))";
		$teachers = $DB->get_records_sql($sqlteachers, array($courseid));
		
		$arrayteachers = array();
		$arrayteachers["no"] = get_string('selectteacher', 'local_paperattendance');
		foreach ($teachers as $teacher){
			$arrayteachers[$teacher->id] = $teacher->name;
		}
		$mform->addElement("select", "teacher", get_string('uploadteacher', 'local_paperattendance'), $arrayteachers);
		
		//filepicker
		$mform->addElement('filepicker', 'file', get_string('uploadfilepicker', 'local_paperattendance'), null, array('maxbytes' => $maxbytes, 'accepted_types' =>array('*.pdf')));	
		$mform->setType('file', PARAM_FILE);
		$mform->addRule('file', get_string('uploadrule', 'local_paperattendance'), 'required', null, 'client');
		
		//courseid
		$mform->addElement('hidden', 'courseid', $courseid);
		$mform->setType('courseid', PARAM_INT);
		$this->add_action_buttons(true);
	}
	public function validation($data, $files) {

		$errors = array();
		$realfilename = $data ['file'];
	    if($realfilename ==''){  // checking this to see if any file has been uploaded
           $errors ['upload'] = get_string('uploadplease', 'local_paperattendance');
        }
		return $errors;
	}
}