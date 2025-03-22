<?php
/**
 * Web service definitions for the local_ws_mod_get_instanceid plugin
 *
 * @package    local_ws_mod_get_instanceid
 * @category   external
 * @copyright  2025 Maxime Cruzel
 * @license    https://opensource.org/licenses/MIT MIT
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'local_ws_mod_get_instanceid_get_instance' => array(
        'classname'     => 'local_ws_mod_get_instanceid_external',
        'methodname'    => 'get_instance',
        'description'   => 'Récupère l\'ID d\'instance et le type de module à partir d\'un cmid',
        'type'          => 'read',
        'capabilities'  => 'moodle/course:view',
        'services'      => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
); 