<?php
/*******************************************************************
 * @discription API for Trash
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';

/**
 * class Api notes contoller methods
 */
/**
 * @var string $email email
 * @var string $id id
 */

class ImageControllerService
{
/**
 * @var string $connect PDO object
 */
    public $connect = "";
    /**
     * @method constructor to establish the database connection
     * @return void
     */
    public function __construct()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
    }
/**
 * @method fetchImage() fetch the user profile pic
 * @return void
 */
    public function fetchImage($email)
    {
        /**
         * @var string $query has query to select the profile pic of the user
         */
        $query     = "SELECT profilepic FROM registration where email='$email'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {

            $arr = $statement->fetch(PDO::FETCH_ASSOC);
            /**
             * returns json array response
             */
            print json_encode($arr);
        }

    }
/**
 * @method saveImage() upload the profile pic
 * @return void
 */
    public function saveImage( $url, $email)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $encode2       = base64_decode($url);





// $conf = new NoteStoreConfig();
// $conn = $conf->configs();

// $email = $_POST['email'];
// if ($email != null) {

// $filePath = base64_decode($_POST['fileKey']);
// $stmt = $conn->prepare("UPDATE users SET `profilepic` = :filePath where `email`= :email ");

// $stmt->execute(array(
// ':filePath' => $filePath,
// ':email' => $email
// ));

// print json_encode($data);

// if ($stmt->execute()) {
// $conff = new ProfilePic();
// $conff->getPic();

// } else {
// $data = array(
// "status" => "401"
// );
// print json_encode($data);
// }






        /**
         * @var string $query has query to update the user profile pic
         */
        $query     = "UPDATE registration  SET profilepic ='$encode2' where email='$email' ";
        $statement = $this->connect->prepare($query);
        $d         = $statement->execute();
        if ($statement->execute()) {

            $ref = new ImageControllerService();
            $ref->fetchImage();
        }

        print $filee;
    }
}
