<?php
class Calculator
{

    public function add($a, $b)
    {
        return $a + $b;
    }
    public function isPresentRegistered($email, $pass)
    {
        if ($email != '') {
            return 2;
        } else {
            return 3;
        }

    }
    
}
