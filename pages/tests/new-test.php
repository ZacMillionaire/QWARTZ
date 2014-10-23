<h2>Creating New Test</h2>

<form action="sys/exec/submit_test_results.php" method="POST">
	<div id="new-test-sticky">

		<input type="text" id="date-picker" name="testDate" placeholder="Testing Date" required/>

		<button id="add-row" class="button-small grey">
			<span aria-hidden="true" class="icon-plus"></span>Add Player
		</button>

		<button id="add-category" class="button-small grey">
			<span aria-hidden="true" class="icon-plus"></span>Add Category
		</button>

		<button	id="submit-data"  class="button right" type="submit">
			<span aria-hidden="true" class="icon-checkmark"></span>Save Test
		</button>

	</div>

	<div id="table-container">
		<table>
			<tr>
				<th class="table-title" colspan="6">
					<input
						style="width:100%"
						type="text"
						id="category-input"
						name="categoryName[default]"
						placeholder="Category Name"
						data-category-set="default"
						pattern="[a-zA-Z\s-/]*"
						required
					/>
				</th>
			</tr>
			<tr>
				<th>Player</th>
				<th>Exercise</th>
				<th>Weight</th>
				<th>Reps</th>
				<th>Est 1RM</th>
				<th></th>
			</tr>
		<?php

			$players = $System->GetDataCollectionSystem()->GetPlayerList();
			$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

			foreach ($players as $gkey => $gvalue) {

		?>
			<tr data-input-index="<?php echo $gkey; ?>">
				<td style="width: 25%;">
					<select
						style="width:100%"
						name="players[default][]"
						data-category-set="default"
						id="player-name-entry"
					>
						<option value=""> --- Select Player --- </option>
						<?php
						
							foreach ($players as $key => $value) {

								if($key == $gkey){
									printf(
										"<option value=\"%s\" selected=\"selected\">%s</option>",
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
				<td style="width: 30%;">
					<select
						style="width:100%"
						name="exercise[default][]"
						id="exercise-dropdown"
						data-category-set="default"
					>
						<option value=""> --- Select Exercise --- </option>
						<?php
						
							foreach ($exercises as $ekey => $evalue) {

								printf(
									"<option value=\"%s\">%s</option>",
									$evalue["ExerciseID"],
									$evalue["ExerciseName"]
								);

							}

						?>
					</select>
				</td>
				<td>
					<input
						style="width:100%"
						type="number"
						name="weight[default][]"
						value="0"
						id="weight-input"
						placeholder="Weight"
						data-category-set="default"
					/>
				</td>
				<td>
					<input
						style="width:100%"
						type="number"
						value="1"
						min="1"
						max="10"
						step="1"
						name="reps[default][]"
						id="reps-input"
						placeholder="reps"
						data-category-set="default"
						required
					/>
				</td>
				<td>
					<input
						style="width:100%"
						type="text"
						pattern="[0-9.]*"
						value="1"
						name="est1rm[default][]"
						id="est-1rm"
						placeholder="Estimated 1RM"
						data-category-set="default"
					/>
				</td>
				<td>
					<button class="button" style="width:100%" id="remove-player" data-input-index="<?php echo $gkey; ?>"><span aria-hidden="true" class="icon-close"></span></button>

			</tr>
		<?php
			}
		?>
		</table>
	</div>
</form>

<script src="js/fitnessTest.js"></script>