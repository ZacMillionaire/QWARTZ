<h2>Creating New Test</h2>

<form action="sys/exec/submit_test_results.php" method="POST">
	<div id="new-test-sticky">
	<input type="date" id="date-picker" name="testDate" placeholder="Testing Date" required/>

	<button id="add-row" class="button-small">
		Add Player
	</button>

	<button id="add-category" class="button-small">
		Add Category
	</button>
	</div>
	<div id="table-container">
		<div class="test-fauxtable" data-template-table data-category-set="default">
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-tablecell">
					<input style="width: 100%" type="text" id="category-input" name="categoryName[default]" placeholder="Category Name" data-category-set="default" required/>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">Player</div>
				<div class="test-fauxtable-header">Exercise</div>
				<div class="test-fauxtable-header">Weight</div>
				<div class="test-fauxtable-header">reps</div>
				<div class="test-fauxtable-header">Estimated 1RM</div>
			</div>
		<?php

			$players = $System->GetDataCollectionSystem()->GetPlayerList();

			$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

			foreach ($players as $gkey => $gvalue) {

				?>
			<div class="test-fauxtable-tablerow" data-template-row data-input-index="<?php echo $gkey; ?>">
				<div class="test-fauxtable-tablecell">
					<!-- <input type="text" id="player-name-entry" data-input-index="0" name="player[default][]" placeholder="Player Search" data-category-set="default" required/> -->
					<select name="players[default][]" data-category-set="default" id="player-name-entry" required>
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
					<button id="remove-player" data-input-index="<?php echo $gkey; ?>">remove player</button>
				</div>
				<div class="test-fauxtable-tablecell">
					<select name="exercise[default][]" id="exercise-dropdown" data-category-set="default" required>
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
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="weight[default][]" value="0" id="weight-input" placeholder="Weight" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="number" value="1" min="1" max="10" step="1" name="reps[default][]" id="reps-input" placeholder="reps" data-category-set="default" required/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" value="1" name="est1rm[default][]" id="est-1rm" placeholder="Estimated 1RM" data-category-set="default"/>
				</div>
			</div>
		<?php
			}
		?>
		</div>

	</div>

	<button type="submit">Submit</button>

</form>

<script src="js/fitnessTest.js"></script>