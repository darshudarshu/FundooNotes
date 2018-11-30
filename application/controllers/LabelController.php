<?php
/*******************************************************************
 * @discription API for labels
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Content-type: image/gif");
include "DatabaseConnection.php";
require 'JWT.php';

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
 * @method fetchLabelNote() fetch label notes
 * @return void
 */
    public function fetchLabelNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $label   = $_POST["label"];
        $email   = $_POST["email"];
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select all notes with label
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);

            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method changeLabelDateTime() change the label component data and time
 * @return void
 */
    public function changeLabelDateTime()
    {
        $ref             = new DatabaseConnection();
        $this->connect   = $ref->Connection();
        $id              = $_POST["id"];
        $label           = $_POST["label"];
        $email           = $_POST["email"];
        $presentDateTime = $_POST["presentDateTime"];
        $query           = "UPDATE notes SET remainder = '$presentDateTime' where id = '$id'";
        $statement       = $this->connect->prepare($query);
        if ($statement->execute()) {
            /**
             * @var string $query has query to select all notes from database
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);
            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method createLabelNotes() to create notes with labels
 * @return void
 */
    public function createLabelNotes()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $title     = $_POST["title"];
            $notes     = $_POST["notes"];
            $email     = $_POST["email"];
            $color     = $_POST["color"];
            $isArchive = $_POST["isArchive"];
            $label     = $_POST["label"];
            $remainder = $_POST["remainder"];
            /**
             * @var string $query has query to Insert data into database (notes) table name
             */
            $query = "INSERT INTO notes (email,title,notes,remainder,isArchive,color,label) VALUES('$email','$title','$notes','$remainder','$isArchive','$color','$label')";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var string $query has query to select all notes
                 */
                $query = "SELECT * FROM notes where email='$email' and  isDeleted='no' and label='$label'  order by dragId desc";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    /**
                     * @var array $arr to store result
                     */
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    /**
                     * returns json array response
                     */
                    print json_encode($arr);
                }
            } else {
                $data = array(
                    "error" => "202",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method deleteLabelNote() to delete the labeled notes
 * @return void
 */
    public function deleteLabelNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            $id            = $_POST["id"];
            $label         = $_POST["label"];
            $email         = $_POST["email"];
            $query         = "UPDATE notes SET isDeleted = 'yes' where id = '$id'";
            $statement     = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var string $query has query to select all the notes
                 */
                $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    /**
                     * @var array $arr to store result
                     */
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    /**
                     * returns json array response
                     */
                    print json_encode($arr);
                }
            } else {
                $data = array(
                    "error" => "202",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method deleteNoteLabels() to delete the notes label
 * @return void
 */
    public function deleteNoteLabels()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $label         = $_POST["label"];
        $email         = $_POST["email"];
        $query         = "UPDATE notes SET label = null where id = '$id'";
        $statement     = $this->connect->prepare($query);
        if ($statement->execute()) {
            /**
             * @var string $query has query to select all the notes
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);
            }
        } else {
            $data = array(
                "error" => "202",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method fetchImage() fetch the user profile pic
 * @return void
 */
    public function fetchImage()
    {
        $email = $_POST["email"];
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
    public function saveImage()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $file          = $_FILES["file"];
        $email         = $_POST["email"];
        $url           = $_POST["url"];
$encode2 = base64_decode($url);

//         $b = array();
// foreach (str_split($url) as $c) {
//     $b[] = sprintf("%08b", ord($c));
// }
// $rr =$b;



        // $mycheckboxarray = serialize($b);
        // $fdfdf= unserialize($mycheckboxarray);  
        // $filee         = json_encode($fdfdf );
        // $fillll        = json_decode($filee);
// $rf="";
// for ($i=0; $i <count($fdfdf); $i++) { 
//    $encode2 = base64_encode($fdfdf);

// }
        // $encode2 = base64_encode($file);
        // $pos      = strpos($filee, 'base64,');
        // $blobData = base64_decode(substr($filee, $pos + 7));

// $filetemp = $file['tmp_name'];
        // $encode = base64_encode($filetemp);
        // $encode2 = base64_encode(addslashes(file_get_contents($filetemp)));
        // $encode2 = base64_encode(addslashes(file_get_contents($_filee["name"]["tmp_name"])));
    //     $imgData         = addslashes(file_get_contents($_FILES['file']['tmp_name']));
    //  $imageProperties = getimageSize($_FILES['file']['tmp_name']);

        // $encode2 = base64_encode(addslashes($_FILES["name"]["tmp_name"]));
        // $encode2 = base64_encode($file);
        // $encode2 = "data:image/jpeg;base64,".$encode2;
        // $image      = addslashes(file_get_contents($file['tmp_name'])); //SQL Injection defence!
        // if($encode2 == $url)
        // {
        // $image_name = addslashes($file['name']);

// }else{
        // $image_name = addslashes($file['name']);

// }
        // $image_name = addslashes($file['name']);

        // $image = new Imagick("image.jpg");
        // $data  = $image->getImageBlob();
        // $data  = $mysqli->real_escape_string($data);

        // $json_obj = json_decode($url); //replace 'post_key' with whatever you use
        // $blob     = base64_decode($url);
        //$sql = "INSERT INTO output_images(imageType ,imageData)
	//VALUES('{$imageProperties['mime']}', '{$imgData}')";


        /**
         * @var string $query has query to update the user profile pic
         */
        $query     = "UPDATE registration  SET profilepic ='$encode2' where email='$email' ";
        $statement = $this->connect->prepare($query);
        $d=$statement->execute();
        if ($statement->execute()) {

            $ref = new LabelController();
            $ref->fetchImage();
        }


     
        print $filee;
    }

}
