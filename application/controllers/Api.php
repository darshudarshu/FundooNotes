<?php
/*******************************************************************
 * @discription REST API using postman
 ********************************************************************/
// defined('BASEPATH') or exit('No direct script access allowed');
/**
 * class Api has curd operation methods
 */
class Api
{
    /**
     * @var string $connect PDO object
     */
    private $connect = '';
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
        $this->connect = new PDO("mysql:host=localhost;dbname=testing", "root", "root");
    }
    /**
     * @method insert() Adds data into the database
     * @return void
     */
    public function insert()
    {
        /**
         * @var string $var1 firstname
         * @var string $var2 lastname
         */
        $var1 = $_POST['first_name'];
        $var2 = $_POST['last_name'];
        /**checking the entered first name present nor not */
        if (isset($_POST["first_name"]) && Api::ispresent($var1) && (!preg_match('/[0-9]/', $var1)) && (!preg_match('/[0-9]/', $var2))) {
            /**
             * @var array $form_data to provide data to place holder
             */
            $form_data = array(
                ':first_name' => $_POST["first_name"],
                ':last_name'  => $_POST["last_name"],
            );
            /**
             * @var string $query has query to insert data into database (tbl_sample) table name
             */
            $query = "
   INSERT INTO tbl_sample
   (first_name, last_name) VALUES
   (:first_name, :last_name)
   ";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute($form_data)) {
                echo 'Data insterted';
            } else {
                echo 'Data is not insterted';
            }
        } else {
            echo 'First Name should not be not null , and Last Name and First Name should be character';
        }
    }
    /**
     * @method update() updates data into the database
     * @param int $id
     * @return void
     */
    public function update($id)
    {
        /**
         * @var string $query has query to select data from database (tbl_sample) table name
         */
        $query = "SELECT first_name, last_name FROM tbl_sample WHERE id = '" . $id . "'";
        /**
         * @var string $statement holds statement object
         */
        $statement = $this->connect->prepare($query);
        $statement->execute();
        /**
         * @var array $arr array of data from database
         */
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        /**
         * @var string $var1 firstname
         * @var string $var2 lastname
         */
        $var1 = $_POST['first_name'];
        $var2 = $_POST['last_name'];
        if ($arr['first_name'] != null) {
            if ((!preg_match('/[0-9]/', $var1)) && (!preg_match('/[0-9]/', $var2))) {
                /**
                 * @var array $form_data to provide data to place holder
                 */
                $form_data = array(
                    ':first_name' => $_POST['first_name'],
                    ':last_name'  => $_POST['last_name'],
                    ':id'         => $_POST['id'],
                );
                /**
                 * @var string $query has query to update data into database (tbl_sample) table name
                 */
                $query = "
       UPDATE tbl_sample
       SET first_name = :first_name, last_name = :last_name
       WHERE id = :id
       ";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute($form_data)) {
                    echo 'Data updated';
                } else {
                    echo 'Data not updated';
                }
            } else {
                echo 'First Name should not be null, and Last Name and First Name should be character';
            }
        } else {
            echo 'NO such ID found';
        }
    }
    /**
     * @method fetchOne() display the row data of passed paramter
     * @param int id
     * @return void
     */
    public function fetchOne($id)
    {
        /**
         * @var string $query has query to select data from database (tbl_sample) table name
         */
        $query     = "SELECT first_name, last_name FROM tbl_sample WHERE id = '" . $id . "'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        /**
         * @var array $arr array of data from database
         */
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr['first_name'] != null) {
            /**
             * @var string $query has query to select data from database (tbl_sample) table name
             */
            $query = "SELECT * FROM tbl_sample WHERE id='" . $id . "'";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                foreach ($statement->fetchAll() as $row) {
                    /**
                     * @var array $data to store result
                     */
                    $data['first_name'] = $row['first_name'];
                    $data['last_name']  = $row['last_name'];
                }
                echo json_encode($data);
            }
        } else {
            echo 'No such data found';
        }
    }
    /**
     * @method fetchAll() display all the data from the database pf respective table
     * @return void
     */
    public function fetchAll()
    {
        /**
         * @var string $query has query to select data from database (tbl_sample) table name
         */
        $query = "SELECT * FROM tbl_sample ORDER BY id";
        /**
         * @var string $statement holds statement object
         */
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                /**
                 * @var array $data to store result
                 */
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            echo 'No such data found';
        }
    }
    /**
     * @method delete() delete the given id row from database
     * @param int id
     * @return void
     */
    public function delete($id)
    {
        /**
         * @var string $query has query to select data from database (tbl_sample) table name
         */
        $query = "SELECT first_name, last_name FROM tbl_sample WHERE id = '" . $id . "'";
        /**
         * @var string $statement holds statement object
         */
        $statement = $this->connect->prepare($query);
        $statement->execute();
        /**
         * @var array $arr array of data from database
         */
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr['first_name'] != null) {
            /**
             * @var string $query has query to select data from database (tbl_sample) table name
             */
            $query     = "DELETE FROM tbl_sample WHERE id = '" . $id . "'";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                echo 'Data deleted';
            }
        } else {
            echo 'No such data found';
        }
    }
    /**
     * @method ispresent() cheks wheather the given first name present or not
     * @param string first_name
     * @return bool
     */
    public function ispresent($name)
    {
        /**
         * @var string $query has query to select data from database (tbl_sample) table name
         */
        $query = "SELECT * FROM tbl_sample ORDER BY id";
        /**
         * @var string $statement holds statement object
         */
        $statement = $this->connect->prepare($query);
        $statement->execute();
        /**
         * @var array $arr array of data from database
         */
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if ($titleData['first_name'] == $name) {
                return false;
            }
        }
        return true;
    }
}
