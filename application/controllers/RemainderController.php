<?php
/*******************************************************************
 * @discription API for Remainder
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/RemainderControllerService.php";

/**
 * class Api remainder contoller methods
 */

class RemainderController
{
/**
 * @var string $serviceReference serviceReference
 */

    public $serviceReference = "";
/**
 * @var string $title title
 * @var string $notes notes
 * @var string $email email
 * @var string $color color
 * @var string $isArchive isArchive
 * @var string $label label
 * @var string $remainder remainder
 */
/**
 * @method constructor to establish the service connection
 * @return void
 */
    public function __construct()
    {
        $this->serviceReference = new RemainderControllerService();

    }
/**
 * @method fetchRemainderNote() to fetch the remainder notes
 * @return void
 */
    public function fetchRemainderNote()
    {

        $email = $_POST["email"];
        $this->serviceReference->fetchRemainderNote($email);
    }
/**
 * @method changeDateTime function to change the date and time
 * @return void
 */
    public function changeDateTime()
    {

        $id              = $_POST["id"];
        $email           = $_POST["email"];
        $presentDateTime = $_POST["presentDateTime"];
        $this->serviceReference->changeDateTime($id, $email, $presentDateTime);
    }
/**
 * @method createRemainderNotes()
 * @return void
 */
    public function createRemainderNotes()
    {

        $title     = $_POST["title"];
        $notes     = $_POST["notes"];
        $email     = $_POST["email"];
        $color     = $_POST["color"];
        $isArchive = $_POST["isArchive"];
        $label     = $_POST["label"];
        $remainder = $_POST["remainder"];
        $this->serviceReference->createRemainderNotes($notes, $title, $color, $isArchive, $remainder, $label, $email);
    }
/**
 * @method deleteRemainderNote()
 * @return void
 */
    public function deleteRemainderNote()
    {

        $email = $_POST["email"];
        $id    = $_POST["id"];
        $this->serviceReference->deleteRemainderNote($email, $id);
    }
}
