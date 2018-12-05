<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

/*********************************************************************
 * @discription  Controller API
 *********************************************************************/
require 'JWT.php';
include "/var/www/html/codeigniter/application/RabbitMQ/sender.php";
// include "/var/www/html/codeigniter/application/static/Constant.php";
include "DatabaseConnection.php";
include "/var/www/html/codeigniter/application/static/LinkConstants.php";

/**
 * @var string $query has query to update data into database (tbl_sample) table name
 */
/**
 * @var string $statement holds statement object
 */
/**
 * @var array $data to store result
 */
class FundoAPIService
{
    /**
     * @var string $connect PDO object
     */
    private $connect       = '';
    public static $emailid = "";
    public $constants      = "";
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        // $obj              = new Constant();
        // $this->connect    = new PDO("$obj->database:host=$obj->host;dbname=$obj->databaseName", "$obj->user", "$obj->password");
        $ref             = new DatabaseConnection();
        $this->connect   = $ref->Connection();
        // $this->constants = new Constant();
        $this->constants = new LinkConstants();
    }

/**
 * @var string $name
 * @var string $email
 * @var string $number
 * @var string $pass
 */
    /**
     * @method registration() Adds data into the database
     * @return void
     */
    public function registration($name, $email, $number, $pass)
    {
        /**checking the entered first name present nor not */
        $flag = FundoAPIService::isEmailNumberPresent($email, $number);
        if ($flag == 0) {
            $query = "
            INSERT INTO registration
            (username,email,mobilenumber,password) VALUES
            ('$name','$email',$number,'$pass')
            ";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $ref   = new SendMail();
                $token = md5($email);
                $sub   = 'verify email id';
                $body  = $this->constants->verificationLinkMasssage . $this->constants->verificationLink . $token;
                $ref->sendEmail($email, $sub, $body);
                $query     = "UPDATE registration SET reset_key = '$token' where email = '$email'";
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    $data = array(
                        "message" => "200",
                    );
                    print json_encode($data);
                    return "200";
                } else {
                    $data = array(
                        "message" => "204",
                    );
                    print json_encode($data);
                    return "204";

                }
            } else {
                $data = array(
                    "message" => "304",
                );
                print json_encode($data);
                return "304";

            }
        } else if ($flag == 1) {
            $data = array(
                "message" => "201",
            );
            print json_encode($data);
            return "201";

        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);
            return "203";

        }
    }
/**
 * @method isEmailNumberPresent() check email number duplicate
 * @return void
 */
    public function isEmailNumberPresent($email, $number)
    {
        $query     = "SELECT * FROM registration ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if (($titleData['email'] == $email) || ($titleData['mobilenumber'] == $number)) {
                if ($titleData['email'] == $email) {
                    //user email found duplicate
                    return 1;
                } else if ($titleData['mobilenumber'] == $number) {
                    // user phone found duplicate
                    return 2;
                }
            }
        }
        //no duplicate not found
        return 0;
    }
/**
 * @method login() login in to fundo logic
 * @return void
 */
    public function login($email, $pass)
    {
        $flag = FundoAPIService::isPresentRegistered($email, $pass);
        if ($flag == 1) {
            $data = array(
                "message" => "400",
            );
            print json_encode($data);
            return "400";
        } else if ($flag == 2) {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);
            return "401";

        } else if ($flag == 3) {
            $token = FundoAPIService::jwtToken($email);
            $data  = array(
                "token"   => $token,
                "message" => "200",
            );
            print json_encode($data);
            return "200";

        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);
            return "404";

        }
    }
/**
 * @method login() login in to fundo logic
 * @return void
 */
    public function socialSignIn($email, $name)
    {
        $flag = FundoAPIService::isPresentRegisteredLogged($email);
        if ($flag == 1) {
            $token = FundoAPIService::jwtToken($email);
            $data  = array(
                "token"   => $token,
                "message" => "200",
            );
            print json_encode($data);

        } else {
            if ($email != null) {
                $query     = "INSERT INTO registration (username,email,active) VALUES ('$name','$email','active')";
                $statement = $this->connect->prepare($query);
                $true      = $statement->execute();
            }
            $token = FundoAPIService::jwtToken($email);
            $data  = array(
                "token"   => $token,
                "message" => "400",
            );
            print json_encode($data);

        }
    }
/**
 * @method isPresentRegistered() check email and pass match
 * @return void
 */
    public function isPresentRegisteredLogged($email)
    {
        $query     = "SELECT * FROM registration ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if ($titleData['email'] == $email) {
                return 1;
            }
        }
        return 0;
    }
/**
 * @method isPresentRegistered() check email and pass match
 * @return void
 */
    public function isPresentRegistered($email, $pass)
    {
        $query     = "SELECT * FROM registration ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if (($titleData['email'] == $email) || ($titleData['password'] == $pass) || ($titleData['active'] == 'active')) {
                if (($titleData['email'] == $email) && ($titleData['password'] != $pass)) {
                    return 1;
                } else if (($titleData['email'] != $email) && ($titleData['password'] == $pass)) {
                    return 2;
                } else if (($titleData['email'] == $email) && ($titleData['password'] == $pass) && ($titleData['active'] == 'active')) {
                    return 3;
                }
            }
        }
        return 0;
    }
/**
 * @method forgotPassword() sending resetting password ink to registered mail
 * @return void
 */
    public function forgotPassword($email)
    {
        if (FundoAPIService::checkEmail($email)) {
            $ref       = new SendMail();
            $token     = md5($email);
            $query     = "UPDATE registration SET reset_key = '$token' where email = '$email'";
            $statement = $this->connect->prepare($query);
            $statement->execute();
            $sub      = 'password recovery mail';
            $body     = $this->constants->resetLinkMasssage . $this->constants->resetLink . $token;
            $response = $ref->sendEmail($email, $sub, $body);
            if ($response == "sent") {
                $data = array(
                    "message" => "200",
                );
                print json_encode($data);
                return "200";

            } else {
                $data = array(
                    "message" => "400",
                );
                print json_encode($data);
                return "400";

            }

        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);
            return "404";
        }
    }
/**
 * @method checkEmail() check email is present
 * @return void
 */
    public function checkEmail($email)
    {
        $query     = "SELECT * FROM registration ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if ($titleData['email'] == $email && $titleData['active'] == 'active') {
                return true;
            }
        }
        return false;
    }
/**
 * @method resetPassword() resets the pass word of corresesponding email
 * @return void
 */
    public function resetPassword($token, $pass)
    {
        $query     = "UPDATE registration SET reset_key = '$token' where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $query     = "UPDATE registration SET password = '$pass' where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $query     = "SELECT reset_key FROM registration where  password = '$pass'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr['reset_key'] == null) {
            $data = array(
                "message" => "304",
            );
            print json_encode($data);
            return "304";
        } else {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);
            return "200";
            $query     = "UPDATE registration SET reset_key = null where reset_key='$token'";
            $statement = $this->connect->prepare($query);
            $statement->execute();
        }
    }
/**
 * @method getEmailId() ge the forgoten email id
 * @return void
 */
    public function getEmailId($token)
    {
        $query     = "SELECT email FROM registration where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr) {
            $data = array(
                'key'     => $arr['email'],
                'session' => 'active',
            );
            print json_encode($data);
        } else {
            $data = array(
                'key'     => "\n",
                'session' => 'reset link has been expired',
            );
            print json_encode($data);
            return "reset link has been expired";
        }

    }
/**
 * @method veryfyEmailId() verify the email and send verify link to user
 * @return void
 */
    public function veryfyEmailId($token)
    {
        $query     = " UPDATE registration SET active = 'active' where reset_key ='$token' ";
        $statement = $this->connect->prepare($query);
        $true      = $statement->execute();
        $query     = "UPDATE registration SET reset_key = null where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);
            return "200";
        } else {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);
            return "401";

        }
    }
    public function jwtToken($email)
    {

        // $payload   = ['iat' => time(), 'iss' => 'localhost', 'userid' => $email];
        $secretKey = "darshu12345";
        $token     = JWT::encode($email, $secretKey);
        return $token;
    }

}
