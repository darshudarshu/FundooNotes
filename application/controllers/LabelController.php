<?php
/*******************************************************************
 * @discription API for labels
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Content-type: image/gif");
include "/var/www/html/codeigniter/application/service/LabelControllerService.php";

/**
 * class Api labeled notes contoller methods
 */
class LabelController
{
/**
 * @var string $connect PDO object
 */
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
 * @var string $serviceReference serviceReference
 */

    public $serviceReference = "";
/**
 * @method constructor to establish the database connection
 * @return void
 */
    public function __construct()
    {
        $this->serviceReference = new LabelControllerService();

    }
/**
 * @method fetchLabelNote() fetch label notes
 * @return void
 */
    public function fetchLabelNote()
    {

        $label = $_POST["label"];
        $email = $_POST["email"];
        $this->serviceReference->fetchLabelNote($label, $email);
    }
/**
 * @method changeLabelDateTime() change the label component data and time
 * @return void
 */
    public function changeLabelDateTime()
    {

        $id              = $_POST["id"];
        $label           = $_POST["label"];
        $email           = $_POST["email"];
        $presentDateTime = $_POST["presentDateTime"];
        $this->serviceReference->changeLabelDateTime($id, $presentDateTime, $label, $email);

    }
/**
 * @method createLabelNotes() to create notes with labels
 * @return void
 */
    public function createLabelNotes()
    {
        $title     = $_POST["title"];
        $notes     = $_POST["notes"];
        $email     = $_POST["email"];
        $color     = $_POST["color"];
        $isArchive = $_POST["isArchive"];
        $label     = $_POST["label"];
        $remainder = $_POST["remainder"];
        $this->serviceReference->createLabelNotes($notes, $title, $color, $isArchive, $remainder, $label, $email);

    }
/**
 * @method deleteLabelNote() to delete the labeled notes
 * @return void
 */
    public function deleteLabelNote()
    {

        $id    = $_POST["id"];
        $label = $_POST["label"];
        $email = $_POST["email"];
        $this->serviceReference->deleteLabelNote($id, $label, $email);
    }
/**
 * @method deleteNoteLabels() to delete the notes label
 * @return void
 */
    public function deleteNoteLabels()
    {

        $id    = $_POST["id"];
        $label = $_POST["label"];
        $email = $_POST["email"];
        $this->serviceReference->deleteNoteLabels($id, $label, $email);

    }


}
