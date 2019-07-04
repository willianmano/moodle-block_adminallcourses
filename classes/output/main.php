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
 * Class containing data for the block.
 *
 * @package    block_adminallcourses
 * @copyright  2019 onwards Guilherme Oliveira
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_adminallcourses\output;

defined('MOODLE_INTERNAL') || die();

use core_course_list_element;
use moodle_url;
use renderable;
use renderer_base;
use stdClass;
use templatable;

/**
 * Class containing data for the block.
 *
 * @package    block_adminallcourses
 * @copyright  2019 Willian Mano {@link http://conecti.me}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements renderable, templatable {

    /**
     * @param renderer_base $output
     * @return array|\external_warnings|\stdClass
     * @throws \Exception
     */
    public function export_for_template(renderer_base $output) {
        global $DB, $CFG;

        $sql = 'SELECT c.id, c.shortname, c.fullname, c.visible, cc.name as coursecategory
                FROM {course} c
                INNER JOIN {course_categories} cc ON cc.id = c.category 
                WHERE c.id > 0';

        $courses = $DB->get_records_sql($sql);

        $returndata = [];
        foreach ($courses as $course) {
            $returndata['courses'][] = [
                'id' => $course->id,
                'shortname' => $course->shortname,
                'fullname' => $course->fullname,
                'visible' => $course->visible,
                'courseimage' => $this->get_summary_image_url($course),
                'coursecategory' => $course->coursecategory,
                'viewurl' => $CFG->wwwroot . '/course/view.php?id=' . $course->id
            ];
        }

        return $returndata;
    }

    /**
     * Returns the first course's summary issue
     *
     * @param $course
     *
     * @return string
     *
     * @throws \moodle_exception
     */
    public function get_summary_image_url($course) {
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }

        foreach ($course->get_course_overviewfiles() as $file) {
            if ($file->is_valid_image()) {
                $pathcomponents = [
                    '/pluginfile.php',
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea() . $file->get_filepath() . $file->get_filename()
                ];

                $path = implode('/', $pathcomponents);

                return (new moodle_url($path))->out();
            }
        }

        return (new moodle_url('/blocks/adminallcourses/pix/default_course.jpg'))->out();
    }
}
