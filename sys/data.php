<?php 


class DataCollection extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();

	} // End Class Constructor

	public function GetExerciseList() {

		$sql = "SELECT * FROM `exercises`";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	} // End GetExerciseList


	public function GetPlayerList() {

		$sql = "SELECT * FROM `playerdetails`";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	}

	public function SearchPlayerList($str) {

		if(trim($str) == ""){
			return false;
		}
		// PDO has it's flaws, even though both firstNameString and lastNameString are the same value, you can't use
		// 1 binding in 2 places
		$sql = "SELECT * FROM `playerdetails` WHERE `FirstName` LIKE :firstNameString OR `LastName` LIKE :lastNameString";
		$params = array(
			"firstNameString" => $str."%",
			"lastNameString" => $str."%"
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	}

}

?>