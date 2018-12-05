<?php
require_once "/var/www/html/codeigniter/application/controllers/FundoAPI.php";
include "/var/www/html/codeigniter/application/tests/controllers/TeastCaseConstants.php";
class FundoAPI_test extends TestCase
{
    /**
     * variable to the constants
     */
    public $constantClassObj = null;
    public function __construct()
    {
        $this->constantClassObj = new TeastCaseConstants();
    }
/**
 * @method testLogin
 * @description test case for the user login
 */

    public function testLogin()
    {

        $file                 = $this->constantClassObj->loginTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);

        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['email']    = $value['testEmail'];
            $_POST['password'] = $value['password'];
            $ref               = new FundoAPI();
            $result            = $ref->login();
            $res               = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testRegistration
 * @description test case for the registration
 */

    public function testRegistration()
    {
        $file                 = $this->constantClassObj->registrationTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['email']        = $value['email'];
            $_POST['password']     = $value['password'];
            $_POST['username']     = $value['username'];
            $_POST['mobilenumber'] = $value['mobilenumber'];
            $ref                   = new FundoAPI();
            $result                = $ref->registration();
            $res                   = $this->assertEquals($value['expected'], $result);

        }

    }
/**
 * @method testForgotPassword
 * @description test case for the forgot password
 */
    public function testForgotPassword()
    {
        $file                 = $this->constantClassObj->forgotTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['email'] = $value['email'];
            $ref            = new FundoAPI();
            $result         = $ref->forgotPassword();
            $res            = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testGetEmailId
 * @description test case for the get email
 */
    public function testGetEmailId()
    {
        $file                 = $this->constantClassObj->getemailTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['token'] = $value['token'];
            $ref            = new FundoAPI();
            $result         = $ref->getEmailId();
            $res            = $this->assertEquals($value['expected'], $result);
        }
    }
/**
 * @method testVeryfyEmailId
 * @description test case for veryfy the file
 */
    public function testVeryfyEmailId()
    {
        $file                 = $this->constantClassObj->getemailTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['token'] = $value['token'];
            $ref            = new FundoAPI();
            $result         = $ref->veryfyEmailId();
            $res            = $this->assertEquals("200", $result);
        }
    }
/**
 * @method testReset
 * @description test case for reset 
 */
    public function testReset()
    {
        $file                 = $this->constantClassObj->getemailTestcaseFileName;
        $data                 = file_get_contents($file, true);
        $testCaseExampleArray = json_decode($data, true);
        foreach ($testCaseExampleArray as $key => $value) {
            $_POST['token'] = $value['token'];
            $_POST["pass"] = "342342234";
            $ref            = new FundoAPI();
            $result         = $ref->resetPassword();
            $res            = $this->assertEquals("304", $result);
        }
    }
}
