<?php
require_once "/var/www/html/codeigniter/application/controllers/FundoAPI.php";
include "/var/www/html/codeigniter/application/tests/controllers/TeastCaseConstants.php";
// include "/var/www/html/codeigniter/application/tests/controllers/LoginTestCase.json";
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

    public function testLoginFirstCase()
    {

        $url                  = $this->constantClassObj->loginTestcaseUrl;
        $file                 = $this->constantClassObj->loginTestcaseFileName;
        $data                 = file_get_contents("/var/www/html/codeigniter/application/tests/controllers/LoginTestCase.json" . $file);
        $testCaseExampleArray = json_decode($data, true);

        foreach ($testCaseExampleArray as $key => $value) {

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $value['testEmail'] & $value['password']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($result);
            $this->assertEquals($value['expected'], $res->message);

        }

        // $ch  = curl_init($url);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "email=darshan@gmail.com&password=2222222222");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // $res = json_decode($result);
        // $this->assertEquals('404', $res->message);
    }
    // public function testLoginSecondCase()
    // {
    //     $url = "http://localhost/codeigniter/login";
    //     $ch  = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, "email=darshangangadhar@gmail.com&password=111111");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     $res = json_decode($result);
    //     $this->assertEquals('200', $res->message);
    // }
    // public function testLoginThirdCase()
    // {
    //     $url = "http://localhost/codeigniter/login";
    //     $ch  = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, "email=darshangangadhar@gmail.com&password=121111");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     $res = json_decode($result);
    //     $this->assertEquals('400', $res->message);
    // }
    // public function testLoginFourthCase()
    // {
    //     $url = "http://localhost/codeigniter/login";
    //     $ch  = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, "email=darshangangadharr@gmail.com&password=121111");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     $res = json_decode($result);
    //     $this->assertEquals('401', $res->message);
    // }
    // public function testRegistrationFirstCase()
    // {
    //     $url = "http://localhost/codeigniter/registration";
    //     $ch  = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, "username=darshan & email=darshangangadhar@gmail.com & mobilenumber=1111111111 & password=121111");
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     $res = json_decode($result);
    //     $this->assertEquals('201', $res->message);
    // }
}
