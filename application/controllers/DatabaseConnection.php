<?php
class DatabaseConnection
{
    /**
     * @method Connection establish DB connection
     * @return PDO object
     */

    public function Connection()
    {
        return new PDO("mysql:host=localhost;dbname=Fundoo", "root", "root");
    }
}
