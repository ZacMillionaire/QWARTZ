<?php 

class FitnessTests extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();

	} // End Class Constructor

	public function GetPreviousTestList($start = null,$end = null) {

		$dateStart = (isset($start)) ? $start : strtotime("-1 week",time());
		$dateEnd = (isset($end)) ? $end : time();

		$sql = "SELECT `fitnessTestGroupID`,`DateEntered`, `ExerciseName`,`ExerciseCategoryName`,`PlayerID`
				FROM `playertestinginfo`
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `DateEntered` >= :dateStart AND
				`DateEntered` <= :dateEnd
				ORDER BY `DateEntered` DESC";
		$params = array(
			"dateStart" => date('Y-m-d 00:00:00',$dateStart),
			"dateEnd" => date('Y-m-d 23:59:59',$dateEnd)
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$testList = array();
		foreach ($result as $key => $value) {

			if(isset($testList[$value["fitnessTestGroupID"]])){

				if(!in_array($value["ExerciseName"], $testList[$value["fitnessTestGroupID"]]["exercises"])) {
					$testList[$value["fitnessTestGroupID"]]["exercises"][] = $value["ExerciseName"];				
				}
				if(!in_array($value["ExerciseCategoryName"], $testList[$value["fitnessTestGroupID"]]["categories"])) {
					$testList[$value["fitnessTestGroupID"]]["categories"][] = $value["ExerciseCategoryName"];
				}
				if(!in_array($value["PlayerID"], $testList[$value["fitnessTestGroupID"]]["players"])) {
					$testList[$value["fitnessTestGroupID"]]["players"][] = $value["PlayerID"];
				}

			} else {

				$testList[$value["fitnessTestGroupID"]]["DateEntered"] = $value["DateEntered"];
				$testList[$value["fitnessTestGroupID"]]["exercises"][] = $value["ExerciseName"];
				$testList[$value["fitnessTestGroupID"]]["categories"][] = $value["ExerciseCategoryName"];
				$testList[$value["fitnessTestGroupID"]]["players"][] = $value["PlayerID"];

			}

		}

		return $testList;

	} // End GetPreviousTestList


	public function GetPreviousFitnessTestData($testID){

		$sql = "SELECT *,`playertestinginfo`.`Weight` AS `testWeight`
				FROM `playertestinginfo`
				INNER JOIN `playerdetails` USING(`PlayerID`)
				INNER JOIN `exercises` USING(`ExerciseID`)
				WHERE `fitnessTestGroupID` = :testID
				ORDER BY `ExerciseCategoryName`";
		$params = array(
			"testID" => $testID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$sortedArray = array();
		$fitnessData = array(
			"testDate" => $result[0]["DateEntered"]
		);

		// I don't actually know how the following works. My fingers moved of their
		// own accord, code flowing, results showing.
		// Holla.
		foreach ($result as $key => $value) {
			if(in_array($value["ExerciseCategoryName"], $result[$key])) {
				$sortedArray[$value["ExerciseCategoryName"]][] = $result[$key];
			}
		}

		$fitnessData["data"] = $sortedArray;

		return $fitnessData;

	} // End GetPreviousFitnessTestData
}

?>