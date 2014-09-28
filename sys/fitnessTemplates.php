<?php 

class FitnessTemplates extends System {

	function __construct() {

		$this->DatabaseSystem = parent::GetDatabaseSystem();
		$this->SystemSettings = parent::GetSystemSettings();
		$this->DataCollection = parent::GetDataCollectionSystem();

	} // End Class Constructor


	public function GetSavedTemplatesList(){

		$sql = "SELECT *
				FROM `fitnesstemplates`
				ORDER BY `dateAdded` DESC";
		$params = null;

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result;

	} // End GetSavedTemplatesList


	public function GetSavedTemplatesByID($templateUID){

		$sql = "SELECT *
				FROM `fitnesstemplates`
				WHERE `templateUID` = :templateUID;";
		$params = array(
			"templateUID"=>$templateUID
		);

		$result = $this->DatabaseSystem->dbQuery($sql,$params);

		return $result[0];

	} // End GetSavedTemplatesByID

	public function DecodeTemplateDataString($templateDataString) {

		$templateArray = array();
		$decodedTemplateData = json_decode($templateDataString,true);

		$playerData = $this->DataCollection->GetPlayerDetailsByID($decodedTemplateData["playerID"]);
		$exercises = $this->DataCollection->GetExerciseList();

		$templateArray["playerID"] = $decodedTemplateData["playerID"];
		$templateArray["sessions"] = $decodedTemplateData["sessions"];
		$templateArray["extraNotes"] = $decodedTemplateData["extraNotes"];
		$templateArray["templateName"] = $decodedTemplateData["templateName"];

		foreach ($decodedTemplateData as $key => $value) {

			if(is_array($value)){
				// echo "[$key]";
				// echo "\n";
				foreach ($value as $skey => $svalue) {
					// echo $skey;	
					// echo " > ";
					// echo $svalue;	
					// echo "\n";
					$templateArray[$skey][$key] = $svalue;
					$templateArray[$skey]["superSetSize"] = 0;
				}
				// echo "\n";
			}
		}

		// pre-processing for superset detection
		$superSetFlag = false;
		$firstSuperSetKey = null;

		foreach ($templateArray as $key => $value) {
			if(is_array($value)){

				// if this exercise has a superset value, and the flag hasn't been set,
				// flip the flag, then store the first key of the superset
				if(isset($value["superset"]) && !$superSetFlag){
					$superSetFlag = true;
					$firstSuperSetKey = $key;
				} 

				// if the current exercise has the flag set, get it's set count, and add it to the superSetSize
				// value of the first exercise of the set
				if(isset($value["superset"])){
					$templateArray[$firstSuperSetKey]["superSetSize"] += $templateArray[$key]["sets"];
				} elseif(!isset($value["superset"]) && $superSetFlag) {

					// if the current exercise isn't part of a superset, but the flag has been set,
					// toggle and set the key to null for the next pass
					$templateArray[$firstSuperSetKey]["superSetSize"] += $templateArray[$key]["sets"];
					
					$superSetFlag = false;
					$firstSuperSetKey = null;
				}

			}
		}

		return $templateArray;

	} // End DecodeTemplateDataString

	public function GenerateTableFromData($templateDataString,$playerData,$exerciseData){

		$numberOfColumnsForExercise = 7;
		$numberOfColumnsInSet = 3;

		$fullWidthColSpan = $numberOfColumnsForExercise + ($numberOfColumnsInSet * $templateDataString["sessions"]);

		/*
		Table header start
		*/
		$tableHeader = "<table>";
		$tableHeader .= "<tr class=\"header-columns\">";
		$tableHeader .= "<th>Player name</th>";
		$tableHeader .= "<th colspan=\"6\">$playerData[FirstName] $playerData[LastName]</th>";

		for($i = 0; $i < $templateDataString["sessions"]; $i++){
			$tableHeader .= "<th colspan=\"3\">S".($i+1)."</th>";
		} // end for(i in templateDataString[sessions])

		$tableHeader .= "</tr>";
		$tableHeader .= "<tr class=\"sub-columns\">";
		$tableHeader .= "<th>Exercise</th>";
		$tableHeader .= "<th>Notes</th>";
		$tableHeader .= "<th>Rest (mins)</th>";
		$tableHeader .= "<th>Sets</th>";
		$tableHeader .= "<th>Reps</th>";
		$tableHeader .= "<th>% 1RM</th>";
		$tableHeader .= "<th>1 RM</th>";

		for($i = 0; $i < $templateDataString["sessions"]; $i++){
			$tableHeader .= "<th>Est</th>";
			$tableHeader .= "<th>Target</th>";
			$tableHeader .= "<th>Reps</th>";
		} // end for(i in templateDataString[sessions])

		$tableHeader .= "</tr>";
		/*
		Table header end
		*/
		
		/*
		Table body start
		*/
		$tableBody = self::GenerateTableBody($templateDataString,$playerData,$exerciseData);
		/*
		Table body end
		*/

		/*
		Table footer start
		*/
		$tableFooter = "<tr>";
		$tableFooter .= "<th colspan=\"".$fullWidthColSpan."\">Extra Notes</th>";
		$tableFooter .= "</tr>";
		$tableFooter .= "<tr>";
		$tableFooter .= "<td colspan=\"".$fullWidthColSpan."\">".$templateDataString["extraNotes"]."</td>";
		$tableFooter .= "</tr>";
		$tableFooter .= "</table>";
		/*
		Table footer end
		*/

		$outputTable = $tableHeader.$tableBody.$tableFooter;
		return $outputTable;

	} // End GenerateTableFromData

	private function GenerateTableBody($templateDataString,$playerData,$exerciseData){

		// prepare for superset detection
		$supressNextCell = false;

		$tableBody = "";

		foreach ($templateDataString as $key => $value) {

			if(is_array($value)) {

				foreach ($exerciseData as $ekey => $evalue) {
					if($exerciseData[$ekey]["ExerciseID"] == $value["exercise"]) {
						$exerciseName = $exerciseData[$ekey]["ExerciseName"];
					} // end if(exercise key = value key)
				} // end for(exercise data in exerciseData)

				// set variables for this row
				$tableCellRows = $value["sets"];
				$exerciseNotes = $value["exerciseNotes"];
				$restTime = $value["restTime"];
				$numberOfReps = $value["reps"];
				$oneRMPercent = ($value["oneRMPercent"] == null) ? "&nbsp;" : $value["oneRMPercent"];
				$oneRM = $value["oneRM"];


				for($j = 0; $j < $value["sets"]; $j++){

					// start the exercise row
					$tableBody .= "<tr class=\"exercise-row\">";


					if($j == 0) { 

						$tableBody .= "<td rowspan=\"".$tableCellRows."\">".$exerciseName."</td>";
						$tableBody .= "<td rowspan=\"".$tableCellRows."\">".$exerciseNotes."</td>";

						// This is some blackmagic shit I have no idea how it works
						// I don't know if this is a testiment to my ability to type code
						// without thinking and it works, or that I'm just really lucky
						// 60% of the time, all of the time
						if($value["superSetSize"] != 0){
							$supressNextCell = true;
							$tableBody .= "<td rowspan=\"".$value["superSetSize"]."\">".$restTime."</td>";						
						} else {
							if(!$supressNextCell){
								$tableBody .= "<td rowspan=\"".$value["sets"]."\">".$restTime."</td>";		
							} elseif(!isset($value["superset"])) {
								$supressNextCell = false;
							}
						}

					} // end if($j == 0)

					$setNumber = $j+1;

					// generate table cells and fill with data
					$tableBody .= "<td>".$setNumber."</td>";
					$tableBody .= "<td>".$numberOfReps."</td>";
					$tableBody .= "<td>".$oneRMPercent."</td>";
					$tableBody .= "<td>".$oneRM."</td>";

					for($k = 0; $k < $templateDataString["sessions"]; $k++){

						// set variables for this row
						$sessionEstimated = ($value["sessionEstimated"] == null) ? "&nbsp;" : $value["sessionEstimated"];
						$sessionTarget = ($value["sessionTarget"] == null) ? "&nbsp;" : $value["sessionTarget"];
						$sessionReps = ($value["sessionReps"] == null) ? "&nbsp;" : $value["sessionReps"];

						// generate table cells and fill with data
						$tableBody .= "<td>".$sessionEstimated."</td>";
						$tableBody .= "<td>".$sessionTarget."</td>";
						$tableBody .= "<td>".$sessionReps."</td>";

					} // end for(k in templateDataString[sessions])

					// close off this row
					$tableBody .= "</tr>";

				} // end for(j in value[sets])
			} // end if(is_array($value))
		} // end foreach($templateDataString value)

		return $tableBody;

	} // End GenerateTableBody

}

?>