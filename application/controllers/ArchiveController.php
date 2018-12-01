<?php
/*******************************************************************
 * @discription API for Archive notes
 ********************************************************************/

header('Access-Control-Allow-Origin: *');

include "/var/www/html/codeigniter/application/service/ArchiveControllerService.php";
/**
 * class Api Archive notes contoller methods
 */

class ArchiveController
{

/**
 * @var string $id id
 * @var string $email email
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
        $this->serviceReference = new ArchiveControllerService();

    }
/**
 * @method archiveNote() to make notes archive
 * @return void
 */
    public function archiveNote()
    {
        $id    = $_POST["id"];
        $email = $_POST["email"];
        $this->serviceReference->archiveNote($id, $email);
    }
/**
 * @method fetchArchiveNote() to fetch all  archived notes
 * @return void
 */
    public function fetchArchiveNote()
    {

        $email = $_POST["email"];
        $this->serviceReference->fetchArchiveNote($email);

    }
/**
 * @method fetchUnArchiveNote() fetch all  unarchive notes
 * @return void
 */
    public function fetchUnArchiveNote()
    {

        $email = $_POST["email"];
        $id = $_POST["id"];
        $this->serviceReference->fetchUnArchiveNote($email,$id);
    }
/**
 * @method deleteArchiveNote() delete the archive notes
 * @return void
 */
    public function deleteArchiveNote()
    {
        $email = $_POST["email"];
        $id = $_POST["id"];
        $this->serviceReference->deleteArchiveNote($email,$id);

    }

}
