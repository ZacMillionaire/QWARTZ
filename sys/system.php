<?php 

	require_once "database.php";
	require_once "users.php";

	class System {

		private static $databaseDetails = array(
			"host" => "localhost",
			"database" => "qldredsdb",
			"user" => "root",
			"password" => ""
		);

		function __construct() {

			// self::$User = new Users();

		}

		public function GetDatabaseSystem(){

			$Database = new Database(
				self::$databaseDetails["host"],
				self::$databaseDetails["database"],
				self::$databaseDetails["user"],
				self::$databaseDetails["password"]
			);

			return $Database;

		}

		public function GetUserSystem() {

			$User = new Users();

			return new Users();
		}

		public function GetSystemSettings() {

			$settings = array(
				"host" => $_SERVER["HTTP_HOST"],
				"dir" => "/INB302/QWARTZ"
			);

			return $settings;

		}

	}

?>