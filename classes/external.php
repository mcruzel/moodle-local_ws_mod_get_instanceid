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
     * Retourne la description des paramètres pour get_instance
     *
     * @return external_function_parameters
     */
    public static function get_instance_parameters() {
        return new external_function_parameters(
            array(
                'cmid' => new external_value(PARAM_INT, 'ID du module de cours (course module id)')
            )
        );
    }

    /**
     * Récupère l'ID d'instance et le type de module à partir d'un cmid
     *
     * @param int $cmid ID du module de cours
     * @return array
     * @throws moodle_exception
     */
    public static function get_instance($cmid) {
        global $DB;

        // Valider les paramètres
        $params = self::validate_parameters(self::get_instance_parameters(), array('cmid' => $cmid));

        // Vérifier que le module existe
        $cm = $DB->get_record('course_modules', array('id' => $params['cmid']), '*', MUST_EXIST);
        
        // Récupérer le cours associé
        $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
        
        // Vérifier les permissions de l'utilisateur
        $context = context_course::instance($course->id);
        require_capability('moodle/course:view', $context);
        
        // Récupérer le nom du module
        $module = $DB->get_record('modules', array('id' => $cm->module), '*', MUST_EXIST);

        return array(
            'instanceid' => $cm->instance,
            'modulename' => $module->name
        );
    }

    /**
     * Retourne la description de la valeur de retour pour get_instance
     *
     * @return external_single_structure
     */
    public static function get_instance_returns() {
        return new external_single_structure(
            array(
                'instanceid' => new external_value(PARAM_INT, 'ID de l\'instance du module'),
                'modulename' => new external_value(PARAM_TEXT, 'Nom du type de module (ex: quiz, assign)')
            )
        );
    }
} 