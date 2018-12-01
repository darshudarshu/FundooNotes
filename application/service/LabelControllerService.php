<?php
/*******************************************************************
 * @discription API for labels
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Content-type: image/gif");
include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';

/**
 * class Api labeled notes contoller methods
 */

class LabelControllerService
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
    public function fetchLabelNote($label, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
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
    public function changeLabelDateTime($id, $presentDateTime, $label, $email)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $query         = "UPDATE notes SET remainder = '$presentDateTime' where id = '$id'";
        $statement     = $this->connect->prepare($query);
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
    public function createLabelNotes($notes, $title, $color, $isArchive, $remainder, $label, $email)
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
    public function deleteLabelNote($id, $label, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
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
    public function deleteNoteLabels($id, $label, $email)
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
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

}
