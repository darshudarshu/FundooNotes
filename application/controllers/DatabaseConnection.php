<?php
include "/var/www/html/codeigniter/application/static/Constant.php";
class DatabaseConnection
{
    /**
     * @method Connection establish DB connection
     * @return PDO object
     */
    public function Connection()
    {
        $obj = new Constant();
        return new PDO("$obj->database:host=$obj->host;dbname=$obj->databaseName", "$obj->user", "$obj->password");
       
    }
}
