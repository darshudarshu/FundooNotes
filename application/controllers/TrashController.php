<?php
/*******************************************************************
 * @discription API for Trash
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
include "DatabaseConnection.php";
require 'JWT.php';

/**
 * class Api notes contoller methods
 */
/**
 * @var string $email email
 * @var string $id id
 */

class TrashController
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
     * @method restoreDeletedNote
     * @return void
     */
    public function restoreDeletedNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);

        $reff = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            $id            = $_POST["id"];
            $email         = $_POST["email"];

            $query     = "UPDATE notes SET isDeleted = 'no' where id = '$id'";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var string $query has query to select deleted notes data from database 
                 */
                $query = "SELECT * FROM notes where email='$email' and isDeleted = 'yes' order by dragId desc";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                $statement->execute();
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
                    "error" => "202",
                );
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
 * @method fetchTrashNote()
 * @return void
 */
    public function fetchTrashNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $email   = $_POST["email"];

        $reff = new JWT();
        if ($reff->verify($token[1])) {

            /**
             * @var string $query has query to select deleted notes data from database
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted = 'yes' order by id desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            $statement->execute();
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
    }
    /**
     * @method deleteNote()
     * @return void
     */
    public function deleteNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            $id            = $_POST["id"];
            $email         = $_POST["email"];
            /**
             * @var string $query has query to delete the roe permanently
             */
            $query     = "DELETE FROM notes WHERE id = '$id'";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new TrashController();
                $reff->fetchTrashNotee($email);

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
 * @method fetchTrashNotee()
 * @param email
 * @return void
 */
    public function fetchTrashNotee($email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);

        $reff = new JWT();
        if ($reff->verify($token[1])) {

            /**
             * @var string $query has query to select deleted notes data from database
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted = 'yes' order by id desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            $statement->execute();
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
    }
}
