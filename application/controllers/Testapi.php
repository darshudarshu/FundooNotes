<?php
// defined('BASEPATH') or exit('No direct script access allowed');
include "Api.php";
/*******************************************************************
 * @discription REST API using postman
 ********************************************************************/
// defined('BASEPATH') or exit('No direct script access allowed');
/**
 * class Api has curd operation methods
 */
class Testapi 
{
    /**
     * @method caller() to perform CURD operation
     * @return void
     */
    public function caller()
    {
        /**
         * @var stirng $api_object
         */
        $api_object = new Api();

        /**check if the data from POSTMAN equals to insert if true call insert() function*/
        if ($_POST["enter"] == 'insert') {
            /**calling Api class method */
            echo $api_object->insert();
        }
        /**check if the data from POSTMAN equals to fetchall if true call fetchall() function*/
        if ($_POST["enter"] == 'fetchall') {
            /**calling Api class method */
            echo $api_object->fetchAll();
        }
        /**check if the data from POSTMAN equals to fetchOne if true call fetchOne() function*/
        if ($_POST["enter"] == 'fetchone') {
            /**calling Api class method */
            $api_object->fetchOne($_POST["id"]);
        }
        /**check if the data from POSTMAN equals to update if true call update() function*/
        if ($_POST["enter"] == 'update') {
            /**calling Api class method */
            $api_object->update($_POST["id"]);
        }
        /**check if the data from POSTMAN equals to delete if true call delete() function*/
        if ($_POST["enter"] == 'delete') {
            /**calling Api class method */
            $api_object->delete($_POST["id"]);
        }

    }
}
