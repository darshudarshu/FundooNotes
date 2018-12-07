<?php
/*******************************************************************
 * @discription API for labels
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Content-type: image/gif");
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/ImageControllerService.php";

/**
 * class Api labeled notes contoller methods
 */
class ImageController
{

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
        $this->serviceReference = new ImageControllerService();

    }
/**
 * @method fetchImage() fetch the user profile pic
 * @return void
 */
    public function fetchImage()
    {
        $email = $_POST["email"];
        $this->serviceReference->fetchImage($email);

    }
/**
 * @method saveImage() upload the profile pic
 * @return void
 */
    public function saveImage()
    {
        $email = $_POST["email"];
        $url   = $_POST["url"];
        $this->serviceReference->saveImage($url, $email);

    }
/**
 * @method noteSaveImage() upload the profile pic
 * @return void
 */
    public function noteSaveImage()
    {
        $email = $_POST["email"];
        $url   = $_POST["url"];
        $id    = $_POST["id"];
        $this->serviceReference->noteSaveImage($url, $email, $id);

    }
/**
 * @method noteFetchImage() upload the profile pic
 * @return void
 */
    public function notesFetchImage()
    {
        $email = $_POST["email"];
        $this->serviceReference->notesFetchImage($email);

    }
/**
 * @method fetchUserEmail() upload the profile pic
 * @return void
 */
    public function fetchUserEmail()
    {
        $email = $_POST["email"];
        $this->serviceReference->fetchUserEmail($email);
    }
}
