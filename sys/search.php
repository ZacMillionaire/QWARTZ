<?php

class Search extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();

	} // End Class Constructor

	public function GetPreviousTestEntriesByRange($page = 0, $perpage = 30) {

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
				ORDER BY `DateEntered` DESC
				LIMIT :currentPage, :nextPage";
		$params = array(
			"currentPage" => $page * $perpage,
			"nextPage" => ($page + 1) * $perpage
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		$testList = array();
		foreach ($result as $key => $value) {

			$testList[$key]["DateEntered"] = $value["DateEntered"];
			$testList[$key]["exercises"] = $value["ExerciseName"];
			$testList[$key]["fitnessTestGroupID"] = $value["fitnessTestGroupID"];
			$testList[$key]["testID"] = $value["playerTestID"];
			$testList[$key]["categories"] = $value["ExerciseCategoryName"];
			$testList[$key]["playerID"] = $value["PlayerID"];
			$testList[$key]["firstName"] = $value["player_first"];
			$testList[$key]["lastName"] = $value["player_last"];

		}

		return $testList;

	} // End GetPreviousTestList


	public function GetFilteredSearchResults($searchTerms) {

		$baseSQL = "SELECT * FROM `playertestinginfo`";
		$params = array();

		$sqlFragments = array();
		$joinFragments = array("INNER JOIN `exercises` USING(`ExerciseID`)");

		if($searchTerms["playerID"]){

			array_push($sqlFragments, "`PlayerID` = :playerID");
			array_push($joinFragments, "INNER JOIN `playerdetails` USING(`PlayerID`)");
			$params["playerID"] = $searchTerms["playerID"];

		}
		if($searchTerms["exerciseID"]){

			array_push($sqlFragments, "`ExerciseID` = :exerciseID");
			$params["exerciseID"] = $searchTerms["exerciseID"];

		}
		if($searchTerms["startDate"]){
			array_push($sqlFragments, "`DateEntered` >= :startDate");
			$params["startDate"] = date('Y-m-d 00:00:00',strtotime($searchTerms["startDate"]));
		}
		if($searchTerms["endDate"]){
			array_push($sqlFragments, "`DateEntered` <= :endDate");
			$params["endDate"] = date('Y-m-d 23:59:59',strtotime($searchTerms["endDate"]));
		}

		for ($i=0; $i < count($joinFragments); $i++) { 
			$baseSQL .= " ".$joinFragments[$i];
		}

		for ($i=0; $i < count($sqlFragments); $i++) {

			if($i == 0){
				$baseSQL .= " WHERE ";
			} elseif($i > 0 && $i != count($sqlFragments)){
				$baseSQL .= " AND ";
			}

			$baseSQL .= $sqlFragments[$i];

		}

		$sql = $baseSQL;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;
	} // End GetFilteredSearchResults


	public function GeneralSearch($postData) {

		if(!$postData["search"]){
			return null;
		}

		$sql = "SELECT
					CONCAT(`FirstName`,' ',`LastName`) AS `result`,
					`playerID` as `ID`
				FROM `playerDetails`
				WHERE CONCAT(`FirstName`,' ',`LastName`) LIKE :search";
		$params = array("search" => $postData["search"]."%");

		$playerResult = $this->DatabaseSystem->dbQuery($sql,$params);

		// $sql = "SELECT *
		// 		FROM `exercises`
		// 		WHERE `ExerciseName` LIKE :search";

		// $exerciseResult = $this->DatabaseSystem->dbQuery($sql,$params);

		$sql = "SELECT 
					`title` AS `result`,
					`templateUID` AS `ID`
				FROM `fitnesstemplates`
				WHERE `title` LIKE :search";

		$templateResult = $this->DatabaseSystem->dbQuery($sql,$params);

		if(!$playerResult && !$exerciseResult && !$templateResult) {
			return null;
		}
		return array(
			"Player" => $playerResult,
			// "Exercise" => $exerciseResult,
			"Template" => $templateResult,
		);

	}
}


?>