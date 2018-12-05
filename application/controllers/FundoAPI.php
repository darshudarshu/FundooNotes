<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

/*********************************************************************
 * @discription  Controller API
 *********************************************************************/
// require 'phpmailer/index.php';

include "/var/www/html/codeigniter/application/service/FundoAPIService.php";
/**
 * @var string $query has query to update data into database (tbl_sample) table name
 */
/**
 * @var string $statement holds statement object
 */
/**
 * @var array $data to store result
 */
/**
 * @var string $name
 * @var string $email
 * @var string $number
 * @var string $pass
 */

class FundoAPI extends CI_Controller
{
    /**
     * @var string $serviceReference serviceReference
     */
    public $serviceReference = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->serviceReference = new FundoAPIService();

    }
    /**
     * @method registration() Adds data into the database
     * @return void
     */
    public function registration()
    {

        $name   = $_POST["username"];
        $email  = $_POST["email"];
        $number = $_POST["mobilenumber"];
        $pass   = $_POST["password"];
        /**
         * adding email to the chache
         */
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $this->cache->save('email', $email);
        $this->serviceReference->registration($name, $email, $number, $pass);
    }
    /**
     * @method login() login in to fundo logic
     * @return void
     */
    public function login()
    {
        $email = $_POST["email"];
        $pass  = $_POST["password"];
        /**
         * adding email to redis
         */
        $this->load->library('Redis');
        $redis = $this->redis->config();
        $redis->set('email', $email);
        $this->serviceReference->login($email, $pass);

    }

/**
 * @method forgotPassword() sending resetting password ink to registered mail
 * @return void
 */
    public function forgotPassword()
    {
        $email = $_POST["email"];
        $this->serviceReference->forgotPassword($email);

    }

/**
 * @method resetPassword() resets the pass word of corresesponding email
 * @return void
 */
    public function resetPassword()
    {
        $token = $_POST["token"];
        $pass  = $_POST["pass"];
        $this->serviceReference->resetPassword($token, $pass);

    }
/**
 * @method getEmailId() ge the forgoten email id
 * @return void
 */
    public function getEmailId()
    {
        $token = $_POST["token"];
        $this->serviceReference->getEmailId($token);

    }
/**
 * @method veryfyEmailId() verify the email and send verify link to user
 * @return void
 */
    public function veryfyEmailId()
    {
        $token = $_POST["token"];
        $this->serviceReference->veryfyEmailId($token);
    }

/**
 * @method resetPassword() resets the pass word of corresesponding email
 * @return void
 */
    public function socialSignIn()
    {
        $email = $_POST["email"];
        $name  = $_POST["name"];
        /**
         * adding user email to the redis
         */
        $this->load->library('Redis');
        $redis = $this->redis->config();
        $redis->set('email', $email);
        $this->serviceReference->socialSignIn($email, $name);

    }
}
