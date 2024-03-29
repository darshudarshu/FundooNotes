<?php
/*******************************************************************
 * @discription API for Remainder
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';

/**
 * class Api remainder contoller methods
 */

class RemainderControllerService
{
/**
 * @var string $connect PDO object
 */
    public $connect = "";
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
 * @method constructor to establish the database connection
 * @return void
 */
    public function __construct()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $this->constants = new Constant();
    }
/**
 * @method fetchRemainderNote() to fetch the remainder notes
 * @return void
 */
    public function fetchRemainderNote($email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to Insert data into database (notes) table name
             */
            $query = "SELECT * FROM notes where email='$email' and remainder != 'undefined' and isDeleted='no'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                for ($i = 0; $i < count($arr); $i++) {
                    $arr[$i]['image'] = $this->constants->base64 . base64_encode($arr[$i]['image']);
                }

                /**
                 *  returns json array response
                 */

                print json_encode($arr);
            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 *  returns json array response
                 */

                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             *  returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method changeDateTime function to change the date and time
 * @return void
 */
    public function changeDateTime($id, $email, $presentDateTime)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        /**
         * @var string $query to update the remainder to the notes
         */
        $query     = "UPDATE notes SET remainder = '$presentDateTime' where id = '$id'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $reff = new RemainderControllerService();
            $reff->fetchRemainderNotee($email);
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             *  returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method createRemainderNotes()
 * @return void
 */
    public function createRemainderNotes($notes, $title, $color, $isArchive, $remainder, $label, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to Insert data into database (notes) table name
             */
            $query = "INSERT INTO notes (email,title,notes,remainder,isArchive,color,label) VALUES('$email','$title','$notes','$remainder','$isArchive','$color','$label')";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new RemainderControllerService();
                $reff->fetchRemainderNotee($email);
            } else {
                $data = array(
                    "error" => "202",
                );
                /**
                 *  returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             *  returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method deleteRemainderNote()
 * @return void
 */
    public function deleteRemainderNote($email, $id)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            /**
             * @var string $query to update the isDeleted colom to yes deleted
             */
            $query     = "UPDATE notes SET isDeleted = 'yes' where id = '$id'";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new RemainderControllerService();
                $reff->fetchRemainderNotee($email);
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
             *  returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method fetchRemainderNotee()
 * @param email
 * @return void
 */
    public function fetchRemainderNotee($email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select the notes from database
             */
            $query = "SELECT * FROM notes where email='$email' and remainder != 'undefined' and isDeleted='no'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                for ($i = 0; $i < count($arr); $i++) {
                    $arr[$i]['image'] = $this->constants->base64 . base64_encode($arr[$i]['image']);
                }

                /**
                 *  returns json array response
                 */
                print json_encode($arr);
            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 *  returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             *  returns json array response
             */

            print json_encode($data);
        }
    }
}
