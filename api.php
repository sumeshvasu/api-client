<?php
/**
 * api page
 *
 * LICENSE: Property of http://bridge-india.in/
 *
 * @copyright  Copyright (c) 2008 Bridge India. (http://www.bridge-india.in/)
 * @license    http://bridge-india.in/license
 * @version	   1.0
 * file    	   api.php
 * @authtor    sumesh@bridge On 19-06-2014
 * @link       http://localhost/api-client/
 * @since	   June 2014
 */
/*
  API	: Application Programming Interface
  GET 	: Used for basic read requests to the server
  PUT	: Used to modify an existing object on the server
  POST	: Used to create a new object on the server
  DELETE: Used to remove an object on the server
 */

require_once("rest-api-class.php");

class API extends RestApiClass {

    var $function_name = '';
    var $post = array();

    function __construct() {
        return $restApiObj = new RestApiClass();
    }

    public function processApi() {
        $restApiObj = self::__construct();
        $requestArray = explode('/', $_REQUEST['rquest']);

        $this->function_name = $restApiObj->function_name_filter($requestArray[0]);
        if ((int) method_exists($this, $this->function_name) > 0) {
            $called_function = $this->function_name;
            $result = $this->$called_function($requestArray);

            if (isset($_POST)) {
                $this->post = $_POST;
            }

            $this->function_name = $restApiObj->function_name_filter($requestArray[0]);

            if ((int) method_exists($this, $this->function_name) > 0) {
                $called_function = $this->function_name;
                $result = $this->$called_function($requestArray, $this->post);


                print_r(json_encode($result));
            } else {
                $this->response('', 404);
            }
        }
    }

}

$api = new API();
$api->processApi();



/*
 * ACCESS URLs
 *
 * Login Url        : http://localhost/api-client/login/username/password
 *
 * Get Projects Url : http://localhost/api-client/get-projects/token
 *
 *
 * */


