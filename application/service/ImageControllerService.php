<?php
/*******************************************************************
 * @discription API for Trash
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';

/**
 * class Api notes contoller methods
 */
/**
 * @var string $email email
 * @var string $id id
 */

class ImageControllerService extends CI_Controller
{
/**
 * @var string $connect PDO object
 */
    public $connect = "";
    /**
     * @var string base64
     */
    public $constants = "";
    /**
     * @method constructor to establish the database connection
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $constants     = new Constant();
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
            print json_encode(base64_encode($arr['profilepic']));
        }

    }
/**
 * @method saveImage() upload the profile pic
 * @return void
 */
    public function saveImage($url, $email)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $file          = base64_decode($url);
        /**
         * @var string $query has query to update the user profile pic
         */
        $query     = "UPDATE registration  SET `profilepic` = :file  where `email`= :email ";
        $statement = $this->connect->prepare($query);
        if ($statement->execute(array(
            ':file'  => $file,
            ':email' => $email))) {

            $ref = new ImageControllerService();
            $ref->fetchImage($email);
        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);

        }
    }

    /**
     * @method noteSaveImage() upload the profile pic
     * @return void
     */
    public function noteSaveImage($url, $email, $id)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $file          = base64_decode($url);
        /**
         * @var string $query has query to update the user profile pic
         */
        $query     = "UPDATE notes  SET `image` = :file  where `email`= :email  and `id`= :id ";
        $statement = $this->connect->prepare($query);
        if ($statement->execute(array(
            ':file'  => $file,
            ':email' => $email,
            ':id'    => $id))) {

            // $ref = new ImageControllerService();
            // $ref->notesFetchImage($email);
        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);

        }
    }
/**
 * @method noteFetchImage() fetch the user profile pic
 * @return void
 */
    public function notesDeleteImage($email, $noteId)
    {
        /**
         * @var string $query has query to select the profile pic of the user
         */
        $query     = "UPDATE notes  SET image=null  where email= '$email'  and where id= '$noteId'";
        $statement = $this->connect->prepare($query);
        $true      = $statement->execute();
    }
/**
 * @method fetchUserEmail() fetching the user email from the chache
 * @return void
 */
    public function fetchUserEmail()
    {
        // $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        // $userEmail = $this->cache->get('email');
        $this->load->library('Redis');
        $redis = $this->redis->config();
        $userEmail = $redis->get('email');

        print json_encode($userEmail);
    }
}
