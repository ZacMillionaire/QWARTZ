<?php

// print_r($_POST);

include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$playerData = $Data->GetPlayerDetailsByID($_POST["playerID"]);

$templateArray = array();

$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

// print_r($exercises);

$templateArray["playerID"] = $_POST["playerID"];
$templateArray["sessions"] = $_POST["sessions"];
$templateArray["extraNotes"] = $_POST["extraNotes"];

foreach ($_POST as $key => $value) {

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

//print_r($templateArray);

// This is fucking terrifying

?>

<table>
	<tr class="header-columns">
		<th>Player name</th>
		<th colspan="6"><?php echo $playerData["FirstName"]." ".$playerData["LastName"]; ?></th>
	<?php
		for($i = 0; $i < $templateArray["sessions"] + 1; $i++){
	?>
		<th colspan="3"><?php echo "S".($i+1); ?></th>
	<?php
		} // end for(i in templateArray[sessions])
	?>
	</tr>
	<tr class="sub-columns">
		<th>Exercise</th>
		<th >Notes</th>
		<th>Rest (mins)</th>
		<th>Sets</th>
		<th>Reps</th>
		<th>% 1RM</th>
		<th>1 RM</th>
	<?php
		for($i = 0; $i < $templateArray["sessions"] + 1; $i++){
	?>
		<th>Est</th>
		<th>Target</th>
		<th>Reps</th>
	<?php
		} // end for(i in templateArray[sessions])
	?>
	</tr>
<?php
	
	// prepare for superset detection
	$superSetClass = false;

	foreach ($templateArray as $key => $value) {
		if(is_array($value)) {

			foreach ($exercises as $ekey => $evalue) {
				if($exercises[$ekey]["ExerciseID"] == $value["exercise"]) {
					$exerciseName = $exercises[$ekey]["ExerciseName"];
				}
			}

			// This is the tricky part, if this loop has a value of superset,
			// and superSetClass has not yet been altered, enable the superset class
			// this will persist as set until the end of the loop where there is a post check to see
			// if superset is -not- set, and $superSetClass -is- true
			if(isset($value["superset"]) && !$superSetClass) {
				$superSetClass = "superSet";
			}

			for($j = 0; $j < $value["sets"]; $j++){

?>	
	<tr class="exercise-row <?php echo $superSetClass; ?>">
		<?php
			// rowspan=val won't work here due to the way the table is generated.
			// See if you can't bluff with some styling with border-collapse trickery,
			// I believe in you Tom!
			if($j == 0) { 
		?>
		<td rowspan="<?php echo $value["sets"]; ?>"><?php echo $exerciseName; ?></td>
		<td rowspan="<?php echo $value["sets"]; ?>"><?php echo $value["exerciseNotes"]; ?></td>
		<td rowspan="<?php echo $value["sets"]; ?>"><?php echo $value["restTime"]; ?></td>
		<?php
			}
		?>
		<td><?php echo $j+1; ?></td>
		<td><?php echo $value["reps"]; ?></td>
		<td><?php echo ($value["oneRMPercent"] == null) ? "&nbsp;" : $value["oneRMPercent"]; ?></td>
		<td><?php echo $value["oneRM"]; ?></td>
	<?php

		for($k = 0; $k < $templateArray["sessions"] + 1; $k++){

	?>
		<td><?php echo ($value["sessionEstimated"] == null) ? "&nbsp;" : $value["sessionEstimated"]; ?></td>
		<td><?php echo ($value["sessionTarget"] == null) ? "&nbsp;" : $value["sessionTarget"]; ?></td>
		<td><?php echo ($value["sessionReps"] == null) ? "&nbsp;" : $value["sessionReps"]; ?></td>
	<?php

		} // end for(k in templateArray[sessions])

	?>

	</tr>
<?php
			} // end for(j in value[sets])

			// post check to see if superset is -not- set, and $superSetClass -is- true
			// unsets the class for the next loop if so. or not so. I'm confused.
			if(!isset($value["superset"]) && $superSetClass) {
				$superSetClass = false;
			}

		} // end if(is_array($value))
	} // end foreach($templateArray value)
?>
</table>

<?php
/*
print_r($templateArray);

print_r($_POST);
*/
?>