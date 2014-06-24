<?php
class Database
{
	const DB_SERVER 	= "localhost";
	const DB_USER 		= "root";
	const DB_PASSWORD 	= "";
	const DB 			= "pmt-rest";
	const TABLE_PREFIX	= 'pmt_';

	function __construct()
	{
		$this->dbConnect();
	}

	function dbConnect()
	{
		$link 	= mysql_connect( self::DB_SERVER, self::DB_USER, self::DB_PASSWORD );

		if( !$link )
		{
			echo 'DataBase Connection Error!!!';
		}
		else
		{
			mysql_select_db( self::DB );
		}
	}

	function login( $username, $password )
	{

		$hash_password 	= md5( trim( ( 'PmT-Bridge'.$password ) ) );
		$returnArray 	= array();

		$query 	= 'SELECT * FROM '.self::TABLE_PREFIX.'users WHERE login="'.$username.'" AND password="'.$hash_password.'" LIMIT 0,1';
		$result = $this->commonDatabaseAction( $query );

		if( mysql_num_rows( $result ) > 0 )
		{
			$token = 0;

			while( $row = mysql_fetch_assoc( $result ) )
			{
				$tokenQuery 	= 'SELECT * FROM '.self::TABLE_PREFIX.'client_token WHERE user_id="'.$row['id'].'" LIMIT 0,1';
				$tokenResult 	= $this->commonDatabaseAction( $tokenQuery );

				if( mysql_num_rows( $tokenResult ) == 0 )
				{
					$newToken = $this->generateUniqueId( $row['id'] );

					$tokenInsertQuery = 'INSERT INTO '.self::TABLE_PREFIX.'client_token ( user_id, token ) VALUES ("'.$row['id'].'","'.$newToken.'")';
					$this->commonDatabaseAction( $tokenInsertQuery );

					$returnArray['message']		= 'Login Success';
					$returnArray['token'] 		= $newToken;
					$returnArray['name'] 		= $row['name'];
					$returnArray['user_type'] 	= $row['status_name'];

					return $returnArray;

				}
				else
				{
					while( $tokenRow = mysql_fetch_assoc( $tokenResult ) )
					{
						$returnArray['message']		= 'Login Success';
						$returnArray['token'] 		= $tokenRow['token'];
						$returnArray['name'] 		= $row['name'];
						$returnArray['user_type'] 	= $row['status_name'];
					}

					return $returnArray;
				}
			}


		}
		else
		{
			$returnArray['message'] = 'Login Failed';
			return $returnArray;
		}

	}

	function commonDatabaseAction($sql)
	{
		$result = mysql_query($sql);
		return $result;
	}

	function generateUniqueId( $userId )
	{
		return md5(uniqid( $userId , true) ) ;
	}

	function get_projects( $token )
	{
		$token_query = 'SELECT * FROM '.self::TABLE_PREFIX.'client_token WHERE token="'.$token.'"';
		$tokenResult 	= $this->commonDatabaseAction( $tokenQuery );
	}


























}