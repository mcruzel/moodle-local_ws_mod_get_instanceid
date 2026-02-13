<?php
/**
 * External functions for the local_ws_mod_get_instanceid plugin
 *
 * @package    local_ws_mod_get_instanceid
 * @category   external
 * @copyright  2025 Maxime Cruzel
 * @license    https://opensource.org/licenses/MIT MIT
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->libdir . '/moodlelib.php');

class local_ws_mod_get_instanceid_external extends external_api {
    
    /**
     * Returns the parameter description for get_instance
     *
     * @return external_function_parameters
     */
    public static function get_instance_parameters() {
        return new external_function_parameters(
            array(
                'cmid' => new external_value(PARAM_INT, get_string('cmid_param_desc', 'local_ws_mod_get_instanceid'))
            )
        );
    }

    /**
     * Retrieves the instance ID and module type from a cmid
     *
     * @param int $cmid Course module ID
     * @return array
     * @throws moodle_exception
     */
    public static function get_instance($cmid) {
        global $DB;

        // Validate parameters
        $params = self::validate_parameters(self::get_instance_parameters(), array('cmid' => $cmid));

        // Check that the module exists
        $cm = $DB->get_record('course_modules', array('id' => $params['cmid']), '*', MUST_EXIST);

        // Get the associated course
        $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

        // Check user permissions
        $context = context_course::instance($course->id);
        require_capability('moodle/course:view', $context);

        // Get the module name
        $module = $DB->get_record('modules', array('id' => $cm->module), '*', MUST_EXIST);

        return array(
            'instanceid' => $cm->instance,
            'modulename' => $module->name
        );
    }

    /**
     * Returns the return value description for get_instance
     *
     * @return external_single_structure
     */
    public static function get_instance_returns() {
        return new external_single_structure(
            array(
                'instanceid' => new external_value(PARAM_INT, get_string('instanceid_return_desc', 'local_ws_mod_get_instanceid')),
                'modulename' => new external_value(PARAM_TEXT, get_string('modulename_return_desc', 'local_ws_mod_get_instanceid'))
            )
        );
    }
} 