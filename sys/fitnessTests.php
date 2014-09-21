<?php 

class FitnessTests extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();

	} // End Class Constructor

	public function GetPreviousTestList() {

		$sql = "SELECT `fitnessTestGroupID`,`DateEntered`
				FROM `playertestinginfo`
				GROUP BY `fitnessTestGroupID`
				ORDER BY `DateEntered` DESC";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

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