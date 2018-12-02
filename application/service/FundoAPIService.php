<?php
header('Access-Control-Allow-Origin: *');

/*********************************************************************
 * @discription  Controller API
 *********************************************************************/
// require 'phpmailer/index.php';
require 'JWT.php';
include "/var/www/html/codeigniter/application/RabbitMQ/sender.php";
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
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        $this->database_connection();
    }
    /**
     * @method database_connection() creates PDO object
     */
    public function database_connection()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=Fundoo", "root", "root");
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
                $ref = new SendMail();
                // define("PROJECT_HOME", "http://localhost:4200/verify");
                $token = md5($email);
                $sub   = 'verify email id';
                $body  = " hello click this link to verify your email click here " . "http://localhost:4200/verify" . "?token=" . $token .
                    "  Regards DARSHU ";
                $ref->sendEmail($email, $sub, $body);
                $query     = "UPDATE registration SET reset_key = '$token' where email = '$email'";
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    $data = array(
                        "message" => "200",
                    );
                    print json_encode($data);

                } else {
                    $data = array(
                        "message" => "204",
                    );
                    print json_encode($data);
                }
            } else {
                $data = array(
                    "message" => "304",
                );
                print json_encode($data);
            }
        } else if ($flag == 1) {
            $data = array(
                "message" => "201",
            );
            print json_encode($data);
        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);
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
        } else if ($flag == 2) {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);
        } else if ($flag == 3) {
            $token = FundoAPIService::jwtToken($email);
            $data  = array(
                "token"   => $token,
                "message" => "200",
            );
            print json_encode($data);
        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);
        }
    }
/**
 * @method login() login in to fundo logic
 * @return void
 */
    public function socialSignIn($email)
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

            $query     = "INSERT INTO registration(username,email,active) VALUES('$email','$email','active')";
            $statement = $this->connect->prepare($query);
            $statement->execute();
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
            $sub  = 'password recovery mail';
            $body = " hello
            Click this link to recover your password click here " . "http://localhost:4200/reset" . "?token=" . $token .
                " Regards DARSHU";
            $response = $ref->sendEmail($email, $sub, $body);
            if ($response == "sent") {
                $data = array(
                    "message" => "200",
                );
                print json_encode($data);

            } else {
                $data = array(
                    "message" => "400",
                );
                print json_encode($data);

            }

        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);

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
        } else {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);
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
        $statement->execute();
        $query     = "UPDATE registration SET reset_key = null where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);

        } else {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);

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
