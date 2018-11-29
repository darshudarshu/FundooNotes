<?php
/*******************************************************************
 * @discription API for Notes
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
include "DatabaseConnection.php";
require 'JWT.php';

/**
 * class Api notes contoller methods
 */

class NotesController
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
 * @method createNotes() insert data into the database
 * @return void
 */
    public function createNotes()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);

        $reff = new JWT();
        if ($reff->verify($token[1])) {
            $title              = $_POST["title"];
            $notes              = $_POST["notes"];
            $email              = $_POST["email"];
            $color              = $_POST["color"];
            $isArchive          = $_POST["isArchive"];
            $label              = $_POST["label"];
            $isHaveCollabarator = $_POST["isHaveCollabarator"];
            $remainder          = $_POST["remainder"];

            /**
             * @var string $query has query to Insert data into database (notes) table name
             */
            if ($isHaveCollabarator == "true") {
                $query     = "INSERT INTO notes (email,title,notes,remainder,isArchive,color,label) VALUES('$email','$title','$notes','$remainder','$isArchive','$color','$label')";
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    /**
                     * @var string $query has query to update the note id collabarotor
                     */
                    $query     = "UPDATE collabarator SET noteId = ( SELECT MAX(id) FROM notes WHERE email ='$email') WHERE noteId = 1111 ";
                    $statement = $this->connect->prepare($query);
                    $darshu    = $statement->execute();
                    $reff      = new NotesController();
                    $reff->userNotes();
                } else {
                    $data = array(
                        "error" => "202",
                    );

                    print json_encode($data);
                }

            } else {
                /**
                 * @var string $query has query to Insert data into database (notes) table name
                 */
                $query = "INSERT INTO notes (email,title,notes,remainder,isArchive,color,label) VALUES('$email','$title','$notes','$remainder','$isArchive','$color','$label')";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    $reff = new NotesController();
                    $reff->userNotes();
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
 * @method userNotes() fetch data from the database
 * @return void
 */
    public function userNotes()
    {
        /**
         * @var string $ref holds DatabaseConnection class object
         */
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $email         = $_POST["email"];
        /**
         * @var string $query has query to select the all the notes
         */
        $query = "SELECT * FROM notes where  isArchive = 'no' and isDeleted='no' and (email = '$email' or id in ( SELECT noteId from collabarator WHERE email='$email') )  order by id desc ";

        /**
         * @var string $statement holds statement object
         */
        $statement = $this->connect->prepare($query);
        $temp      = $statement->execute();
        /**
         * @var array $arr to store result
         */
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        /**
         * returns json array response
         */
        print json_encode($arr);
    }
/**
 * @method changeColor() to change the note color
 * @return void
 */
    public function changeColor()
    {

        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $color         = $_POST["color"];
        /**
         * @var string $query has query to set the color to user notes
         */
        $query     = "UPDATE notes SET color = '$color' where id = '$id'";
        $statement = $this->connect->prepare($query);
        $statement->execute();

    }
/**
 * @method changeDateTime() function to update the remainder date and time
 * @return void
 */
    public function changeDateTime()
    {

        $ref             = new DatabaseConnection();
        $this->connect   = $ref->Connection();
        $id              = $_POST["id"];
        $presentDateTime = $_POST["presentDateTime"];
        /**
         * @var string $query has query to update the remainder
         */
        $query     = "UPDATE notes SET remainder = '$presentDateTime' where id = '$id'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
    }
/**
 * @method deleteNote() delete the note
 * @return void
 */
    public function deleteNote()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $email         = $_POST["email"];
        /**
         * @var string $query has query to delete the note
         */
        $query     = "UPDATE notes SET isDeleted = 'yes' where id = '$id'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            /**
             * @var string $query has query to select all the notes from notes tabel
             */
            $query = "SELECT * FROM notes where  isArchive = 'no' and isDeleted='no' and (email = '$email' or id in ( SELECT noteId from collabarator WHERE email='$email') )  order by id desc ";
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
 * @method editNotes() to save  edited data to notes
 * @return void
 */
    public function editNotes()
    {
        $title         = $_POST["title"];
        $notes         = $_POST["notes"];
        $id            = $_POST["id"];
        $color         = $_POST["color"];
        $email         = $_POST["email"];
        $remainder     = $_POST["remainder"];
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        /**
         * @var string $query has query to update the data into notes table
         */
        $query     = "UPDATE notes SET remainder = '$remainder' , color ='$color' , title='$title' , notes='$notes' where id = '$id' ";
        $statement = $this->connect->prepare($query);
        $statement->execute();

    }
/**
 * @method addLabel() add labels to the user
 * @return void
 */
    public function addLabel()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $label         = $_POST["label"];
        $email         = $_POST["email"];
        $reff          = new NotesController();
        $check         = $reff->checkLabel($label, $email);
        if ($email != '' && $check) {
            /**
             * @var string $query has query to Insert data into database (label) table name
             */
            $query     = "INSERT INTO label (name,email) VALUES('$label','$email')";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new NotesController();
                $reff->saveLabelss($email);

            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 *  returns json array response
                 */
                print json_encode($data);
            }} else {
            $reff = new NotesController();
            $reff->saveLabelss($email);

        }

    }
/**
 * @method saveLabelss() fetch all labels
 * @return void
 */
    public function saveLabelss($email)
    {

        /**
         * @var string $query has query to select label data from database (label) table name
         */
        $query = "SELECT * FROM label where email = '$email' order by id desc";
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
    }
/**
 * @method saveLabels() save the entered labels
 * @return void
 */
    public function saveLabels()
    {
        $email = $_POST["email"];

        /**
         * @var string $query has query to select all labels
         */
        $query = "SELECT * FROM label where email = '$email' order by id desc";
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

    }
/**
 * @method createNotes() insert data into the database
 * @return boolean
 * @param label
 * @param email
 */
    public function checkLabel($label, $email)
    {
        /**
         * @var string $query has query to select all labels
         */
        $query     = "SELECT * FROM label WHERE email='$email' ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if ($titleData['name'] == $label) {
                return false;
            }
        }
        return true;
    }
/**
 * @method changeLabel() update the old label
 * @return void
 */
    public function changeLabel()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $name          = $_POST["name"];
        $id            = $_POST["id"];
        $email         = $_POST["email"];
        /**
         * @var string $query has query to update new label to old
         */
        $query     = "UPDATE label SET name = '$name' where id = '$id'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $reff = new NotesController();
            $reff->saveLabelss($email);

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
 * @method deleteLabel() delete the label
 * @return void
 */
    public function deleteLabel()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $email         = $_POST["email"];
        /**
         * @var string $query has query to select all label
         */
        $query     = "SELECT * FROM label WHERE id = '$id' and email='$email'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr  = $statement->fetch(PDO::FETCH_ASSOC);
        $name = $arr['name'];
        /**
         * @var string $query has query to set the label
         */
        $query     = "UPDATE notes SET label = null where label = '$name'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        /**
         * @var string $query has query to delete the label
         */
        $query     = "DELETE FROM label WHERE id = '$id'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $reff = new NotesController();
            $reff->saveLabelss($email);

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
 * @method noteLabel() add label
 * @return void
 */
    public function noteLabel()
    {

        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $label         = $_POST["label"];
        /**
         * @var string $query has query to add label to the notes
         */
        $query     = "UPDATE notes SET label = '$label' where id = '$id'";
        $statement = $this->connect->prepare($query);
        $statement->execute();

    }
/**
 * @method deleteNoteLabel() delete the label note
 * @return void
 */
    public function deleteNoteLabel()
    {

        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $label         = $_POST["label"];
        /**
         * @var string $query has query to update the label to null
         */
        $query     = "UPDATE notes SET label = null where id = '$id'";
        $statement = $this->connect->prepare($query);
        $statement->execute();

    }
/**
 * @method dragDrop() drag and drop the card
 * @return void
 */
    public function dragDrop()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $diff      = $_POST["diff"];
            $currId    = $_POST["currId"];
            $direction = $_POST["direction"];
            $email     = $_POST["email"];
            for ($i = 0; $i < $diff; $i++) {
                if ($direction == "negative") {
                    /**
                     * @var string $query has query to select the next max note id of the notes
                     */
                    $query = "SELECT MAX(id) id FROM notes where id < '$currId' and email='$email'";
                } else {
                    /**
                     * @var string $query has query to select the next min note id of the notes
                     */
                    $query = "SELECT MIN(id) id FROM notes where id > '$currId'  and email='$email'";
                }
                $statement = $this->connect->prepare($query);
                $statement->execute();
                $swapId = $statement->fetch(PDO::FETCH_ASSOC);
                /**
                 * @var swapId to store the next id
                 */
                $swapId = $swapId['id'];
                /**
                 * @var string $query has query to swap the tow rows
                 */
                $query = "UPDATE notes a INNER JOIN notes b on a.id <> b.id set a.email = b.email,a.title = b.title,a.notes = b.notes,a.remainder =b.remainder, a.color=b.color,a.isArchive=b.isArchive , a.isDeleted = b.isDeleted,a.label = b.label
                    WHERE a.id in ('$swapId','$currId') and b.id in ('$swapId','$currId')";
                $statement = $this->connect->prepare($query);
                $temp      = $statement->execute();
                /**
                 * storing in the next id
                 */
                $currId = $swapId;
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

}
