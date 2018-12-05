<?php
require_once "/var/www/html/codeigniter/application/controllers/NotesController.php";
include "/var/www/html/codeigniter/application/tests/controllers/TeastCaseConstants.php";
/*******************************************************************
 * @discription API for TestCase for NotesController
 ********************************************************************/

class NotesController_test extends \PHPUnit_Framework_TestCase
{
    /**
     * variable to the constants
     */
    public $constantClassObj = null;
    public function __construct()
    {
        $this->constantClassObj = new TeastCaseConstants();
    }
/**
 * @method testUserNotes
 * @description test case for thr user fetch notes
 */
    public function testUserNotes()
    {

        $file                 = $this->constantClassObj->forgotTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);

        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['email'] = $value['email'];
            $ref            = new NotesController();
            $result         = $ref->userNotes();
            $res            = $this->assertEquals("200", $result);

        }

    }
/**
 * @method testEditNotes
 * @description test case for thr user edit notes
 */
    public function testEditNotes()
    {
        $file                 = $this->constantClassObj->notesCreateTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        $testCaseExampleArray = $testCaseExampleArray[0]['userNotes'];
        foreach ($testCaseExampleArray as $key => $value) {

            $_POST["notes"]     = $value['notes'];
            $_POST["title"]     = $value['title'];
            $_POST["email"]     = $value['email'];
            $_POST["id"]        = $value['id'];
            $_POST["remainder"] = $value['remainder'];
            $_POST["color"]     = $value['color'];

            $ref    = new NotesController();
            $result = $ref->editNotes();
            $res    = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testDeleteNotes
 * @description test case for delete the notes
 */
    public function testDeleteNotes()
    {
        $file                 = $this->constantClassObj->notesCreateTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        $testCaseExampleArray = $testCaseExampleArray[0]['delete'];
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST["email"] = $value['email'];
            $_POST["id"]    = $value['id'];
            $ref            = new NotesController();
            $result         = $ref->deleteNote();
            $res            = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testDeleteLabel
 * @description test case for delete the note label
 */
    public function testDeleteLabel()
    {
        $file                 = $this->constantClassObj->notesCreateTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        $testCaseExampleArray = $testCaseExampleArray[0]['deleteLabel'];
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST["email"] = $value['email'];
            $_POST["id"]    = $value['id'];
            $ref            = new NotesController();
            $result         = $ref->deleteLabel();
            $res            = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testchangeLabel
 * @description test case for change label of notes
 */
    public function testchangeLabel()
    {
        $file                 = $this->constantClassObj->notesCreateTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        $testCaseExampleArray = $testCaseExampleArray[0]['changeLabel'];
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST["email"] = $value['email'];
            $_POST["id"]    = $value['id'];
            $_POST["name"]  = $value['name'];
            $ref            = new NotesController();
            $result         = $ref->changeLabel();
            $res            = $this->assertEquals($value['expected'], $result);
        }
    }
}
