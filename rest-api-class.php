<?php
require_once("database/database.php");
class RestApiClass
{
	var $function_name	= '';
	var	$username		= '';
	var	$password		= '';

	public function __construct()
	{
		return $dbObj = new Database(); /* DataBase Connection */

	}
	public function login( $request_array )
	{
		$this->function_name	= $request_array[0];
		$this->username			= $request_array[1];
		$this->password			= $request_array[2];

		if( __FUNCTION__ == $this->function_name_filter( $this->function_name ) )
		{
			$dbObj 				= self::__construct();
			$called_function 	= $this->function_name;

			return $dbObj->$called_function( $this->username, $this->password );

		}

	}

	public function response()
	{
		echo 'Error 404 : Page not found';
	}

	public function get_projects( $request_array )
	{
		$this->token			= $request_array[1];

		if( __FUNCTION__ == $this->function_name_filter( $request_array[0] ) )
		{
			$dbObj = self::__construct();
			echo 'reached!!!!';

		}
	}

	public function function_name_filter( $request_function_name )
	{
		return str_replace('-', '_', strtolower( trim( $request_function_name ) ) ) ;
	}
}