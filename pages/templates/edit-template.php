<?php

$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$FitnessTemplateSystem = $System->GetFitnessTemplateSystem();

$baseTemplateData = $FitnessTemplateSystem->GetSavedTemplatesByID($_GET['id']);

$templateDataString = $FitnessTemplateSystem->DecodeTemplateDataString($baseTemplateData["templateDataString"]);


$players = $System->GetDataCollectionSystem()->GetPlayerList();
$exercises = $System->GetDataCollectionSystem()->GetExerciseList();


?>

<form id="new-fitness-template" action="sys/exec/update-template.php" method="POST">
	<input type="hidden" value="<?php echo $_GET["id"]; ?>" name="templateUID" />
	<div id="new-test-sticky">

		<button id="add-exercise" class="button-small grey">
			Add Exercise
		</button>

		<button id="submit-template-button" class="button right" type="submit">
			Update Template
		</button>

	</div>

	<div id="table-container">
		<table>
			<tr>
				<th class="table-title" colspan="3">Template Title</th>
			</tr>
			<tr>
				<td colspan="3">
					<input
						type="text"
						name="templateName"
						id="template-title-input"
						placeholder="Template Name"
						value="<?php echo $templateDataString["templateName"]; ?>"
	 					style="width: 100%"
						required
					/>
				</td>
			</tr>
			<tr>
				<th class="table-title" colspan="3">
 					Player
				</th>
			</tr>
			<tr>
				<td colspan="3">
 					<select
	 					style="width: 100%"
	 					name="playerID"
	 					id="player-name-selection"
	 					required
	 				>
						<option value=""> --- Select Player --- </option>
						<?php
						
							foreach ($players as $key => $value) {

								if($templateDataString["playerID"] == $value["PlayerID"]){
									printf(
										"<option value=\"%s\" selected>%s</option>",
										$value["PlayerID"],
										$value["FirstName"]." ".$value["LastName"]
									);
								} else {
									printf(
										"<option value=\"%s\">%s</option>",
										$value["PlayerID"],
										$value["FirstName"]." ".$value["LastName"]
									);
								}

							}

						?>
					</select>
				</td>
			</tr>
			<tr>
				<th class="table-title" colspan="3">Sessions [?]</th>
			</tr>
			<tr>
				<td colspan="3">
					<input
						style="width: 100%"
						type="text"
						name="sessions"
						value="<?php echo $templateDataString["sessions"]; ?>"
						id="sessions-input"
						placeholder="Sessions"
					/>
				</td>
			</tr>
		</table>
		<br/>
<!-- REPEATING AREA START -->

<?php
	foreach ($templateDataString as $key => $value) {
		if(is_array($value)) {

		$exercise = $value["exercise"];
		$superSetSize = $value["superSetSize"];
		$superset = (isset($value["superset"])) ? "checked" : "";
		$restTime = $value["restTime"];
		$sets = $value["sets"];
		$reps = $value["reps"];
		$oneRM = $value["oneRM"];
		$oneRMPercent = $value["oneRMPercent"];
		$sessionEstimated = $value["sessionEstimated"];
		$sessionTarget = $value["sessionTarget"];
		$sessionReps = $value["sessionReps"];
		$exerciseNotes = $value["exerciseNotes"];

?>
		<table id="exercise-table">
			<tr>
				<th class="table-title" colspan="1">
 					Exercise
 										<input
						type="checkbox"
						id="mark-superset"
						name="superset[<?php echo $key; ?>]"
						data-input-index="0"
						data-category-set="<?php echo $key; ?>"
						<?php echo $superset; ?>
					/>
				</th>
				<td colspan="2">
					<!--

					when changed get last test data from `playertestinginfo` where playerID and
					exerciseID match.

					make this input disabled until the player has been selected.

					if data exists, populate the Reps and 1RM fields with the corresponding data,
					the %1RM is to indicate the percent of their 1RM that the trainer wants them to
					do for each rep in the set (The %1RM column specifies what percent of the 1 rep
					maximum (taken from the first page) they want that player to perform for each
					repetition. This is specified by the user.)


					-->
					<select
						style="width: 100%"
						name="exercise[<?php echo $key; ?>]"
						id="exercise-dropdown"
						data-category-set="<?php echo $key; ?>"
						required
					>
						<option value=""> --- Select Exercise --- </option>
						<?php
						
							foreach ($exercises as $ekey => $evalue) {

								if($exercise == $evalue["ExerciseID"]){
									printf(
										"<option value=\"%s\" selected>%s</option>",
										$evalue["ExerciseID"],
										$evalue["ExerciseName"]
									);
								} else {
									printf(
										"<option value=\"%s\">%s</option>",
										$evalue["ExerciseID"],
										$evalue["ExerciseName"]
									);
								}

							}

						?>
					</select>
				</td>
			</tr>
			<tr>
				<th colspan="3">

					Exercise is superset [?] (this could look better)
				</th>
			</tr>
			<tr>
				<th class="table-title" colspan="1">
					Rest (mins)
				</th>
				<td colspan="2">
					<input
						style="width: 100%"
						type="text"
						value="<?php echo $restTime; ?>"
						id="rest-time-input"
						name="restTime[<?php echo $key; ?>]"
						placeholder="Rest (mins)"
						data-category-set="<?php echo $key; ?>"
						required
					/>
				</td>
			</tr>
			<tr>
				<!--

				[?] tooltip stuff to explain what they do

				-->
				<th class="table-title" colspan="1">Sets [?]</th>
				<td colspan="2">
					<input
						style="width: 100%"
						type="text"
						name="sets[<?php echo $key; ?>]"
						value="<?php echo $sets; ?>"
						id="sets-input"
						placeholder="Sets"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
			</tr>
			<tr>
				<th class="table-title" colspan="3">Set Data</th>
			</tr>
			<tr>
				<th>Reps</th>
				<th>1 RM</th>
				<th>%1RM</th>
			</tr>
			<tr>
				<td>
					<input
						style="width: 100%"
						type="number"
						min="1"
						max="10"
						step="1"
						value="<?php echo $reps; ?>"
						name="reps[<?php echo $key; ?>]"
						id="reps-input"
						placeholder="reps"
						data-category-set="<?php echo $key; ?>"
						required
					/>
				</td>
				<td>
					<input
						style="width: 100%"
						type="text"
						name="oneRM[<?php echo $key; ?>]"
						id="oneRM-input"
						placeholder="1RM"
						value="<?php echo $oneRM; ?>"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
				<td>
					<input
						style="width: 100%"
						type="text"
						name="oneRMPercent[<?php echo $key; ?>]"
						id="oneRMPercent-input"
						placeholder="%1RM"
						value="<?php echo $oneRMPercent; ?>"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
			</tr>
			<tr>
				<th class="table-title" colspan="3">Session Data</th>
			</tr>
			<tr>
				<th>Estimated</th>
				<th>Target</th>
				<th>Reps</th>
			</tr>
			<tr>
				<td>
					<input
						style="width: 100%"
						type="text"
						name="sessionEstimated[<?php echo $key; ?>]"
						id="estimated-session-input"
						placeholder="Est"
						value="<?php echo $sessionEstimated; ?>"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
				<td>
					<input
						style="width: 100%"
						type="text"
						name="sessionTarget[<?php echo $key; ?>]"
						id="target-session-input"
						placeholder="target"
						value="<?php echo $sessionTarget; ?>"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
				<td>
					<input
						style="width: 100%"
						type="text"
						name="sessionReps[<?php echo $key; ?>]"
						id="reps-session-input"
						placeholder="Reps"
						value="<?php echo $sessionReps; ?>"
						data-category-set="<?php echo $key; ?>"
					/>
				</td>
			</tr>
			<tr>
				<th class="table-title" colspan="3">
					Notes
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<textarea
						style="width:100%"
						type="text"
						id="notes-input"
						name="exerciseNotes[<?php echo $key; ?>]"
						data-category-set="<?php echo $key; ?>"
						><?php echo $exerciseNotes; ?></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					need to add padding around these exercise tables, they're too hard to distinguish apart currently
				</td>
			</tr>
		</table>
<!-- REPEATING AREA END -->
		<br/>
<?php
	}
}
?>
		<table>
			<tr>
				<th class="table-title" colspan="3">
					Extras
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<textarea
						style="width:100%"
						id="extra-notes"
						name="extraNotes"
						><?php echo $templateDataString["extraNotes"]; ?></textarea>
				</td>
			</tr>
		</table>
	</div>
</form>

<script src="js/fitnessTemplates.js"></script>