<?php
/*******************************************************************
 * @discription API for Notes
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/NotesControllerService.php";
/**
 * class Api notes contoller methods
 */

class NotesController
{

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
     * @method constructor to establish the service connection
     * @return void
     */
    public function __construct()
    {
        $this->serviceReference = new NotesControllerService();
    }
/**
 * @method createNotes() insert data into the database
 * @return void
 */
    public function createNotes()
    {
        $title              = $_POST["title"];
        $notes              = $_POST["notes"];
        $email              = $_POST["email"];
        $color              = $_POST["color"];
        $isArchive          = $_POST["isArchive"];
        $label              = $_POST["label"];
        $isHaveCollabarator = $_POST["isHaveCollabarator"];
        $remainder          = $_POST["remainder"];
        $this->serviceReference->createNotes($remainder, $isHaveCollabarator, $label, $title, $notes, $email, $color, $isArchive);
    }
/**
 * @method userNotes() fetch data from the database
 * @return void
 */
    public function userNotes()
    {

        $email = $_POST["email"];
        return $this->serviceReference->userNotes($email);
    }
/**
 * @method changeColor() to change the note color
 * @return void
 */
    public function changeColor()
    {

        $id    = $_POST["id"];
        $color = $_POST["color"];
        $this->serviceReference->changeColor($id, $color);

    }
/**
 * @method changeDateTime() function to update the remainder date and time
 * @return void
 */
    public function changeDateTime()
    {
        $id              = $_POST["id"];
        $presentDateTime = $_POST["presentDateTime"];
        $this->serviceReference->changeDateTime($id, $presentDateTime);
    }
/**
 * @method deleteNote() delete the note
 * @return void
 */
    public function deleteNote()
    {
        $id    = $_POST["id"];
        $email = $_POST["email"];
        return $this->serviceReference->deleteNote($id, $email);

    }
/**
 * @method editNotes() to save  edited data to notes
 * @return void
 */
    public function editNotes()
    {
        $title     = $_POST["title"];
        $notes     = $_POST["notes"];
        $id        = $_POST["id"];
        $color     = $_POST["color"];
        $email     = $_POST["email"];
        $remainder = $_POST["remainder"];
        return $this->serviceReference->editNotes($title, $notes, $id, $color, $email, $remainder);

    }
/**
 * @method addLabel() add labels to the user
 * @return void
 */
    public function addLabel()
    {

        $label = $_POST["label"];
        $email = $_POST["email"];
        $this->serviceReference->addLabel($label, $email);
    }
/**
 * @method saveLabels() save the entered labels
 * @return void
 */
    public function saveLabels()
    {
        $email = $_POST["email"];
        $this->serviceReference->saveLabels($email);
    }

/**
 * @method changeLabel() update the old label
 * @return void
 */
    public function changeLabel()
    {
        $name  = $_POST["name"];
        $id    = $_POST["id"];
        $email = $_POST["email"];
        return $this->serviceReference->changeLabel($name, $id, $email);

    }
/**
 * @method deleteLabel() delete the label
 * @return void
 */
    public function deleteLabel()
    {

        $id    = $_POST["id"];
        $email = $_POST["email"];
        return $this->serviceReference->deleteLabel($id, $email);
    }
/**
 * @method noteLabel() add label
 * @return void
 */
    public function noteLabel()
    {

        $id    = $_POST["id"];
        $label = $_POST["label"];
        $this->serviceReference->noteLabel($id, $label);

    }
/**
 * @method deleteNoteLabel() delete the label note
 * @return void
 */
    public function deleteNoteLabel()
    {

        $id    = $_POST["id"];
        $label = $_POST["label"];
        $this->serviceReference->deleteNoteLabel($id, $label);

    }
/**
 * @method dragDrop() drag and drop the card
 * @return void
 */
    public function dragDrop()
    {

        $diff      = $_POST["diff"];
        $currId    = $_POST["currId"];
        $direction = $_POST["direction"];
        $email     = $_POST["email"];
        $this->serviceReference->dragDrop($diff, $currId, $direction, $email);

    }

}
