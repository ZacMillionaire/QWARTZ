<?php 

	// The system spits out quite a few PHP notices which the user can see
	// depending on the server configuration. This is a hacky way to stop that,
	// but should probably be disabled whenever debugging.
	error_reporting(E_ALL ^ E_NOTICE);

	require_once "database.php";
	require_once "users.php";
	require_once "data.php";
	require_once "fitnessTests.php";
	require_once "fitnessTemplates.php";
	require_once "search.php";
	require_once "player.php";
	require_once "dataLock.php";
	
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

		public function GetPlayerSystem() {

			$Players = new Players();

			return $Players;

		}

		public function GetDataLockSystem() {

			$Locks = new DataLockSystem();

			return $Locks;
		}

		public function GetSystemSettings() {

			$settings = array(
				"host" => $_SERVER["HTTP_HOST"],
				"dir" => "/INB302/QWARTZ/"
			);

			return $settings;

		}

		public function CamelToEnglish($string) {

			$newString = "";

			for ($i=0; $i < strlen($string); $i++) { 
				if($i == 0){
					$newString = strtoupper($string[$i]);
				} else {
					if(ctype_upper($string[$i])) { // lol
						$newString .= " ".$string[$i];
					} else {
						$newString .= $string[$i];
					}
				}
			}

			return $newString;

		}

	}

?>