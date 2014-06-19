<?php
require_once("database/database.php");
class RestApiClass
{
	public function __construct()
	{
		return $dbObj = new Database(); /* DataBase Connection */
	}
	public function login( $requestArray )
	{
		$functionName 	= $requestArray[0];
		$username		= $requestArray[1];
		$password		= $requestArray[2];

		if( __FUNCTION__ == $functionName )
		{
			$dbObj = self::__construct();
			return $dbObj->$functionName( $username, $password );

		}

	}

	public function response()
	{
		echo 'Error 404 : Page not found';
	}
}