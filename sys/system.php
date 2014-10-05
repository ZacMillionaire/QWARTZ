<?php 

	require_once "database.php";
	require_once "users.php";
	require_once "data.php";
	require_once "fitnessTests.php";
	require_once "fitnessTemplates.php";
	require_once "search.php";
	
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

			return $User;
		}

		public function GetFitnessTestSystem() {

			$FitnessTest = new FitnessTests();

			return $FitnessTest;

		}
		public function GetFitnessTemplateSystem() {

			$FitnessTemplates = new FitnessTemplates();

			return $FitnessTemplates;

		}

		public function GetDataCollectionSystem() {

			$DataCollection = new DataCollection();

			return $DataCollection;

		}

		public function GetSearchSystem() {

			$Search = new Search();

			return $Search;

		}

		public function GetSystemSettings() {

			$settings = array(
				"host" => $_SERVER["HTTP_HOST"],
				"dir" => "/INB302/QWARTZ/"
			);

			return $settings;

		}

	}

?>