<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");

class Email
{
    public function multi($a, $b)
    {
        return $a * $b;
    }
    public function sub($a, $b)
    {
        return $a - $b;
    }
}
