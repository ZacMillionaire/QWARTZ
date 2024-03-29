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

	public function GetPlayerDetailsByID($playerID) {

		if(trim($playerID) == ""){
			return false;
		}

		$sql = "SELECT * FROM `playerdetails` WHERE `PlayerID` = :playerID";
		$params = array(
			"playerID" => $playerID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	}

	public function GetPlayerTestData($playerID) {

		$sql = "SELECT 
					`playerTestID`,
					`fitnessTestGroupID`,
					`DateEntered`,
					`ExerciseName`,
		 			`ExerciseCategoryName`,
					`playerdetails`.`FirstName` AS `player_first`,
					`playerdetails`.`LastName` AS `player_last`,
					`PlayerID`
				FROM `playertestinginfo`
				INNER JOIN `playerdetails` USING(`PlayerID`)
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `PlayerID` = :playerID;";
		$params = array(
			"playerID" => $playerID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	}

	public function GetRecentPlayerTestData($exerciseID, $playerID) {

		$sql = "SELECT * FROM `playertestinginfo` WHERE `PlayerID` = :playerID AND `ExerciseID` = :exerciseID;";
		$params = array(
			"playerID" => $playerID,
			"exerciseID" => $exerciseID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	}

	public function GetPlayerTemplates($playerID) {

		$sql = "SELECT * FROM `fitnesstemplates` WHERE `playerID` = :playerID;";
		$params = array(
			"playerID" => $playerID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	}

}

?>