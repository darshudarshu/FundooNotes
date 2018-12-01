<?php
/*******************************************************************
 * @discription API for Collabarator
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
include "/var/www/html/codeigniter/application/service/DatabaseConnection.php";
require '/var/www/html/codeigniter/application/service/JWT.php';

/**
 * class Api Collabarator notes contoller methods
 */

class CollabaratorService
{
/**
 * @var string $connect PDO object
 */
/**
 * @var string $id id
 * @var string $email email
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
 * @method fetchCollabarator() fetch all collabarator
 * @param id
 * @param email
 * @return void
 */
    public function fetchCollabarator($id, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select all the collabarator
             */
            $query = "SELECT * FROM collabarator WHERE owner='$email' and noteId='$id'  order by id desc";
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
 * @method addCollabarator() to add the collabarator
 * @return void
 */
    public function addCollabarator($id, $email, $collabratorEmail)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);

        $reff = new JWT();
        if ($reff->verify($token[1])) {
            $reff = new CollabaratorService();
            if ($reff->checkCollabarator($id, $collabratorEmail, $email)) {
                /**
                 * @var string $query has query to add collabarator to database
                 */
                $query     = "INSERT INTO collabarator (email,noteId,owner) VALUES('$collabratorEmail','$id','$email')";
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    $reff = new CollabaratorService();
                    $reff->fetchCollabarator($id, $email);
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
                    "status" => "300",
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
 * @method checkCollabarator() check for duplicate collabarator
 * @param id
 * @param email
 * @param collabratorEmail
 * @return void
 */
    public function checkCollabarator($id, $collabratorEmail, $email)
    {
        $reff = new CollabaratorService();
        if ($reff->checkEmail($id, $collabratorEmail)) {
            $query     = "SELECT * FROM registration ORDER BY id";
            $statement = $this->connect->prepare($query);
            $statement->execute();
            $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($arr as $regData) {
                if ($regData['email'] == $collabratorEmail && $collabratorEmail != $email) {
                    return true;
                }
            }
            return false;

        }

    }
/**
 * @method checkEmail() to check email and collabarator email
 * @param id
 * @param collabratorEmail
 * @return boolean
 */
    public function checkEmail($id, $collabratorEmail)
    {
        $query     = "SELECT * FROM collabarator ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $regData) {
            if ($regData['email'] == $collabratorEmail && $regData['noteId'] == $id) {
                return false;
            }
        }
        return true;
    }
/**
 * @method fetchCollabarator() fetch all collabarator
 * @return void
 */
    public function fetchCollabarators($id, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select all collabarator
             */
            $query = "SELECT * FROM collabarator WHERE owner='$email' and noteId='$id'  order by id desc";
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
 * @method deleteCollabaratorData() delete the collabarator
 * @return void
 */
    public function deleteCollabaratorData($collId, $noteId, $currentEmail, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to delete the collabarator
             */
            $query = "DELETE FROM collabarator WHERE id = '$collId' and email = '$currentEmail' and noteId='$noteId'";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new CollabaratorService();
                $reff->fetchCollabarator($noteId, $email);
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
 * @method fetchOwner() fetch the owner of the note
 * @return void
 */
    public function fetchOwner($id)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to fetch the owner of the notes
             */
            $query = "SELECT owner FROM collabarator WHERE noteId='$id'";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr  = $statement->fetch(PDO::FETCH_ASSOC);
                $data = array(
                    "owner" => $arr,
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
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
 * @method collabaratorsOfNotes() fetch all collabarator
 * @return void
 */
    public function collabaratorsOfNotes($email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select all collabarators
             */
            $query = "SELECT * FROM collabarator WHERE owner in ('$email')  or noteId in ( select noteId FROM collabarator where email='$email' )";
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
 * @method deleteMainCollabaratorData() delete the main collabarators
 * @return void
 */
    public function deleteMainCollabaratorData($noteId, $email, $currentEmail)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to delete the main card collabarators
             */
            $query = "DELETE FROM collabarator WHERE  email='$currentEmail' and noteId = '$noteId' and owner = '$email'";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new CollabaratorService();
                $reff->fetchCollabarator($noteId, $email);

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
 * @method deleteAllMainCollabaratorData() delete all collabarator
 * @return void
 */
    public function deleteAllMainCollabaratorData($noteId, $email)
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to delete the noteid collabarator
             */
            $query = "DELETE FROM collabarator WHERE  noteId = '$noteId' and owner = '$email'";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $reff = new CollabaratorService();
                $reff->fetchCollabarator($noteId, $email);

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
}
