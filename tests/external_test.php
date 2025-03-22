<?php
/**
 * Unit tests for the local_ws_mod_get_instanceid external functions
 *
 * @package    local_ws_mod_get_instanceid
 * @category   external
 * @copyright  2025 Maxime Cruzel
 * @license    https://opensource.org/licenses/MIT MIT
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/local/ws_mod_get_instanceid/classes/external.php');

class local_ws_mod_get_instanceid_external_test extends advanced_testcase {
    
    /**
     * Test la récupération d'un module de cours valide
     */
    public function test_get_instance_valid() {
        $this->resetAfterTest(true);
        
        // Créer un cours
        $course = $this->getDataGenerator()->create_course();
        
        // Créer un quiz
        $quiz = $this->getDataGenerator()->create_module('quiz', array('course' => $course->id));
        
        // Créer un utilisateur et l'inscrire au cours
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id);
        
        // Se connecter en tant que l'utilisateur
        $this->setUser($user);
        
        // Récupérer le module de cours
        $cm = get_coursemodule_from_instance('quiz', $quiz->id, $course->id);
        
        // Appeler le webservice
        $result = local_ws_mod_get_instanceid_external::get_instance($cm->id);
        
        // Vérifier le résultat
        $this->assertEquals($quiz->id, $result['instanceid']);
        $this->assertEquals('quiz', $result['modulename']);
    }
    
    /**
     * Test la gestion d'un module de cours invalide
     */
    public function test_get_instance_invalid() {
        $this->resetAfterTest(true);
        
        // Créer un cours
        $course = $this->getDataGenerator()->create_course();
        
        // Créer un utilisateur et l'inscrire au cours
        $user = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($user->id, $course->id);
        
        // Se connecter en tant que l'utilisateur
        $this->setUser($user);
        
        // Tester avec un ID invalide
        $this->expectException(moodle_exception::class);
        local_ws_mod_get_instanceid_external::get_instance(999999);
    }
    
    /**
     * Test la gestion des permissions
     */
    public function test_get_instance_permissions() {
        $this->resetAfterTest(true);
        
        // Créer un cours
        $course = $this->getDataGenerator()->create_course();
        
        // Créer un quiz
        $quiz = $this->getDataGenerator()->create_module('quiz', array('course' => $course->id));
        
        // Créer un utilisateur sans accès au cours
        $user = $this->getDataGenerator()->create_user();
        
        // Se connecter en tant que l'utilisateur
        $this->setUser($user);
        
        // Récupérer le module de cours
        $cm = get_coursemodule_from_instance('quiz', $quiz->id, $course->id);
        
        // Tester l'accès sans permission
        $this->expectException(moodle_exception::class);
        local_ws_mod_get_instanceid_external::get_instance($cm->id);
    }
} 