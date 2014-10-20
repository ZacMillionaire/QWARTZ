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
					`PlayerID`,
					`playertestinginfo`.`lastEditOwner`,
					`playertestinginfo`.`lastEditDateTime`
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

	public function GetRepTable(){

		$sql = "SELECT * FROM `settings` WHERE `settingID` = 2;";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);
		$repString = $result[0]["value"];

		$lookupTable = array();

		foreach(explode(",", $repString) as $key => $value) {
			$exploded = explode(":", $value);
			$lookupTable[$exploded[0]] = $exploded[1];
		}

		return $lookupTable;

	}

	public function UpdateRepTable($postData){

		$repString = "";

		foreach ($postData["reps"] as $key => $value) {
			$repString .= "$key:$value";
			if(count($postData["reps"]) != $key){
				$repString .= ",";
			}
		}

		$sql = "UPDATE `settings`
				SET `value` = :repString
				WHERE `settingID` =2;";
		$params = array(
			"repString" => $repString
		);

		$result = $this->DatabaseSystem->dbInsert($sql,$params);

	}

	public function GetReadOnlyDuration() {

		$sql = "SELECT * FROM `settings` WHERE `settingID` = 1;";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0]["value"];

	}

	public function UpdateReadOnlyDuration($postData) {

		$sql = "UPDATE `settings`
				SET `value` = :duration
				WHERE `settingID` = 1;";
		$params = array(
			"duration" => $postData["duration"]
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

	}

	public function AddHistoryItem($userID,$actionString,$actionURL) {

		$sql = "INSERT INTO `history`
				(
					`actorID`,
					`action`,
					`actionURL`,
					`datePerformed`
				)
				VALUES
				(
					:actorID,
					:action,
					:actionURL,
					NOW()
				);";
		$params = array(
			"actorID" => $userID,
			"action" => $actionString,
			"actionURL" => $actionURL
		);

		$insert = $this->DatabaseSystem->dbInsert($sql,$params);

		return $insert;

	}

	public function GetHistoryTable($maxResults = 10) {

		$sql = "SELECT
					`history`.*,
					CONCAT(
						`profiles`.`firstName`,
						' ',
						`profiles`.`lastName`
					) AS `actor`
				FROM `history`
				INNER JOIN `users` ON `actorID` = `userID`
				INNER JOIN `profiles` USING(`userID`)
				ORDER BY `datePerformed` DESC
				LIMIT 0,:maxResults;";
		$params = array("maxResults"=>$maxResults);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	}

	public function GetExerciseCount($startDate = null,$endDate = null) {

		$start = ($startDate) ? $startDate : strtotime("first day of this month");
		$end = ($endDate) ? $endDate : strtotime("last day of this month");

		$sql = "SELECT
					`exercises`.`ExerciseName`,
					COUNT(ExerciseID) AS `ExerciseCount`
				FROM `playertestinginfo`
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE 
					`dateEntered` >= :startDate AND
					`dateEntered` <= :endDate
				GROUP BY `ExerciseID`;";
		$params = array(
			"startDate" => date('Y-m-d 00:00:00',$start),
			"endDate" => date('Y-m-d 23:59:59',$end)
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	}

	public function GetMonthlyExerciseAggregate($startDate = null,$endDate = null) {

		$start = ($startDate) ? $startDate : strtotime("first day of this month");
		$end = ($endDate) ? $endDate : strtotime("last day of this month");

		$sql = "SELECT
					DATE_FORMAT(`dateEntered`,'%d-%m-%Y') AS `dateEntered`,
					SUM(`reps`) AS `totalReps`,
					SUM(`weight`) AS `totalWeight`,
					AVG(`reps`) AS `avgReps`,
					AVG(`weight`) AS `avgWeight`,
					COUNT(`fitnessTestGroupID`) AS `participants`,
					COUNT(DISTINCT `exerciseID`) AS `uniqueExerciseCount`
					FROM `playertestinginfo`
					WHERE 
						`dateEntered` >= :startDate AND
						`dateEntered` <= :endDate
					GROUP BY DAY(`dateEntered`)";
		$params = array(
			"startDate" => date('Y-m-d 00:00:00',$start),
			"endDate" => date('Y-m-d 23:59:59',$end)
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	}

	public function GetPlayerLeaderBoard($startDate = null,$endDate = null) {

		$start = ($startDate) ? $startDate : strtotime("first day of this month");
		$end = ($endDate) ? $endDate : strtotime("last day of this month");

		$sql = "SELECT
					CONCAT(
						`playerdetails`.`FirstName`,
						' ',
						`playerdetails`.`LastName`
					) AS `playerName`,
					COUNT(`PlayerID`) AS `playerTestCount`,
					SUM(`playertestinginfo`.`weight`) AS `totalWeightLifted`,
					COUNT(DISTINCT `ExerciseID`) AS `uniqueExerciseCount`
				FROM `playertestinginfo`
				INNER JOIN `playerdetails` USING(`playerID`)
				WHERE 
					`dateEntered` >= :startDate AND
					`dateEntered` <= :endDate
				GROUP BY `PlayerID`
				ORDER BY `playerTestCount` DESC";
		$params = array(
			"startDate" => date('Y-m-d 00:00:00',$start),
			"endDate" => date('Y-m-d 23:59:59',$end)
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	}

}

?>