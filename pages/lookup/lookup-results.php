<?php

$Data = $System->GetDataCollectionSystem();
$Search = $System->GetSearchSystem();

$players = $System->GetDataCollectionSystem()->GetPlayerList();
$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

?>

<div id="table-container">
	<form action="lookup.php?a=lookup" method="POST">
		<table>
			<tr>
				<th class="table-title" colspan="4">
 					Player
				</th>
			</tr>
			<tr>
				<td colspan="4">
 					<select
	 					style="width: 100%"
	 					name="playerID"
	 					id="player-name-selection"
	 				>
						<option value=""> --- Select Player --- </option>
						<?php
						
							foreach ($players as $key => $value) {

								if($_POST["playerID"] == $value["PlayerID"]){
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
				<th class="table-title" colspan="4">
 					Exercise Group
				</th>
			</tr>
			<tr>
				<td colspan="4">
 					<select
	 					style="width: 100%"
	 					name="exerciseID"
	 					id="exercise-selection"
	 				>
						<option value=""> --- Select Exercise --- </option>
						<?php
						
							foreach ($exercises as $ekey => $evalue) {

								if($_POST["exerciseID"] == $evalue["ExerciseID"]){
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
				<th class="table-title" colspan="4">
 					Date Range
				</th>
			</tr>
			<tr>
				<th colspan="2">
					Start Date:
				</th>
				<td colspan="2">
					<input style="width: 100%" type="date" class="date-picker" name="startDate" value="<?php echo @$_POST["startDate"]; ?>" placeholder="Start Date"/>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					End Date:
				</th>
				<td colspan="2">
					<input style="width: 100%" type="date" class="date-picker" value="<?php echo @$_POST["endDate"]; ?>" name="endDate" placeholder="End Date"/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<button style="width: 100%" type="submit">Lookup</button>
				</td>
			</tr>
		</table>	
	</form>
</div>
<div id="search-results">
	<h1>Search Results</h3>
	some results as a table
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
	$(".date-picker").datepicker();
});
</script>