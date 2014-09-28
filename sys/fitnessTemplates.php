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


	public function GetSavedTemplatesByID($templateID){

		$sql = "SELECT *
				FROM `fitnesstemplates`
				WHERE `templateID` = :templateID;";
		$params = array(
			"templateID"=>$templateID
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
				}
				// echo "\n";
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
		$tableBody = "";

		// prepare for superset detection
		$supressNextCell = false;

		foreach ($templateDataString as $key => $value) {

			if(is_array($value)) {

				foreach ($exerciseData as $ekey => $evalue) {
					if($exerciseData[$ekey]["ExerciseID"] == $value["exercise"]) {
						$exerciseName = $exerciseData[$ekey]["ExerciseName"];
					} // end if(exercise key = value key)
				} // end for(exercise data in exerciseData)

				// Check to see if this exercise is marked as a superset
				// If it is, we need to supress the generation of the same row following it
				if(isset($value["superset"])) {
					$supressNextCell = true;
				}

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

						if(!$supressNextCell){

							$tableBody .= "<td rowspan=\"".$tableCellRows."\">".$restTime."</td>";

						} else {

							// TODO: Come back to this section as supersets should be able to span n exercises
							if(isset($value["superset"])){

								$tableBody .= "<td rowspan=\"".($tableCellRows*2)."\">".$restTime."</td>";
								$supressNextCell = true;

							} // end if($value[superset])
						} // end if(!$supressNextCell)
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

				// post check to see if superset is -not- set, and $superSetClass -is- true
				if(!isset($value["superset"]) && $supressNextCell) {
					$supressNextCell = false;
				}

			} // end if(is_array($value))
		} // end foreach($templateDataString value)

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
	}

}

?>