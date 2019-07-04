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
 * block_popular_courses clicked event.
 *
 * @package    block_popular_courses
 * @copyright  2019 Guilherme Oliveira <guilhermeoliveira.f11@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_popular_courses\event;

defined('MOODLE_INTERNAL') || die();

/**
 * block_popular_courses clicked event.
 *
 * @package    block_popular_courses
 * @copyright  2019 Guilherme Oliveira <guilhermeoliveira.f11@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class popular_courses_viewed extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpopularcoursesviewed', 'block_adminallcourses');
    }

    /**
     * Get URL related to the action.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/blocks/popular_courses/course.php', array('id' => $this->courseid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, $this->objecttable, 'view', 'course.php?id=' . $this->contextinstanceid, $this->objectid,
            $this->contextinstanceid);
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the course with id '$this->courseid' in " .
            "the popular courses with course module id '$this->contextinstanceid'.";
    }
}
