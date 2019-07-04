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
 * Class definition for the Recently accessed items block.
 *
 * @package    block_adminallcourses
 * @copyright  2019 Willian Mano {@link http://conecti.me}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Recently accessed items block class.
 *
 * @package    block_adminallcourses
 * @copyright  2019 Willian Mano {@link http://conecti.me}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_adminallcourses extends block_base {
        /**
     * Initialize class member variables
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_adminallcourses');
    }

    /**
     * Returns the contents.
     *
     * @return stdClass contents of block
     *
     * @throws coding_exception
     */
    public function get_content() {
        global $USER;

        if (isset($this->content)) {
            return $this->content;
        }

        if (!has_capability('block/adminallcourses:myaddinstance', context_system::instance())) {
            return;
        }

        $main = new block_adminallcourses\output\main();

        $renderer = $this->page->get_renderer('block_adminallcourses');

        $this->content = new stdClass();
        $this->content->text = $renderer->render($main);
        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Locations where block can be displayed.
     *
     * @return array
     */
    public function applicable_formats() {
        return array('my' => true);
    }
}
