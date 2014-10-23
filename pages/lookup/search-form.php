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
		</table>
		<table>
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
		</table>
		<table>
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
					<input style="width: 100%" type="text" class="date-picker" name="startDate" value="<?php echo @$_POST["startDate"]; ?>" placeholder="Start Date - DD/MM/YYYY"/>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					End Date:
				</th>
				<td colspan="2">
					<input style="width: 100%" type="text" class="date-picker" value="<?php echo @$_POST["endDate"]; ?>" name="endDate" placeholder="End Date - DD/MM/YYYY"/>
				</td>
			</tr>
	
		</table>
		<button style="width: 100%" class="button" type="submit"><span aria-hidden="true" class="icon-search"></span>Lookup</button>
	
	</form>