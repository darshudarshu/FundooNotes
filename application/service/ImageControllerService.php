<?php
/*******************************************************************
 * @discription API for Trash
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';
require '/var/www/html/codeigniter/application/cloud/vendor/cloudinary/cloudinary_php/src/Cloudinary.php';
require '/var/www/html/codeigniter/application/cloud/vendor/cloudinary/cloudinary_php/src/Uploader.php';
require '/var/www/html/codeigniter/application/cloud/vendor/cloudinary/cloudinary_php/src/Helpers.php';
require '/var/www/html/codeigniter/application/cloud/vendor/cloudinary/cloudinary_php/src/Api.php';
require '/var/www/html/codeigniter/application/cloud/settings.php';
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
         * @var string $query has query to select the profile stored in the cloudinary of the user
         */
        $query     = "SELECT cloudImage FROM registration where email='$email'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {

            $arr = $statement->fetch(PDO::FETCH_ASSOC);
            /**
             * returns json array response
             */
            print json_encode($arr['cloudImage']);
        }

    }
/**
 * @method saveImage() upload the profile pic
 * @return void
 */
    public function saveImage($url, $email)
    {
        if ($url != null) {
            /**
             * @var returnResponse array having the response after adding image to the cloudinary using uploader method
             */
            $returnResponse = \Cloudinary\Uploader::upload($url);
            /**
             * @var imageUrl the cloudinary url
             */
            $imageUrl      = $returnResponse['url'];
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            /**
             * @var string $query has query to update the user profile pic to the data base
             */
            $query     = "UPDATE registration  SET cloudImage = '$imageUrl'  where email= '$email' ";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $ref = new ImageControllerService();
                $ref->fetchImage($email);
            } else {
                $data = array(
                    "message" => "404",
                );
                /**
                 * return thye json response
                 */
                print json_encode($data);
            }

        } else {
            $data = array(
                "message" => "404",
            );
            /**
             * return the json response
             */
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
        $redis     = $this->redis->config();
        $userEmail = $redis->get('email');

        print json_encode($userEmail);
    }
}
