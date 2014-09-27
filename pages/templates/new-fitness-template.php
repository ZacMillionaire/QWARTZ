<!--
The user uses this page to create templates that they will later fill out by hand after printing off. 

The main functionality we can build into this is auto-generating as many of the fields as possible.

The user should be able to fill out before printing off :

-A player
-Then they select the exercise type(upper body etc.)
-This should then fill the exercise of that type that that player performed in the MOST RECENT test
results and the 1rm value for that exercise. 
-If there is no exercise of that type the player performed in testing, there should be a dropdown
box of all the exercises of that type for the user to specify.

A notes section at the bottom

The %1RM column specifies what percent of the 1 rep maximum (taken from the first page) they want
that player to perform for each repetition. This is specified by the user.

The sets value is specified by the user, this value will alter the number of rows for that exercise.

There should also be a session value, which will specify the number of columns for all exercises.

Once these fields have been filled the user can print the template to use in the gym.

We need to include an option to make an exercise a ‘superset’, what this means is that the rest
column of that exercise will merge with the one beneath it as seen with the bench/military press
and supine chin/prone row exercise in the diagram.

When the user changes the player, the form should change the auto populated information to suit
that player, but NOT change the specified exercise type, sets and rep values.

There should be a ‘save template’ button that saves whatever fields are populated into a template
the user can use later on.

-->
<?php
			$players = $System->GetDataCollectionSystem()->GetPlayerList();

			$exercises = $System->GetDataCollectionSystem()->GetExerciseList();
?>
<form action="sys/exec/create-new-template.php" method="POST">

	<div id="new-test-sticky">

		<button id="add-exercise" class="button-small">
			Add Exercise
		</button>

		<button id="dummied" class="button-small" disabled>
			dummied
		</button>

	</div>

	<div id="table-container">
		<div class="test-fauxtable" data-template-table data-category-set="default">
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">
					dummied player stuff
 					<select name="players[default]" data-category-set="default" id="player-name-entry" disabled>
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
 				</div>
			</div>
<!-- SUPERSET DATA SECTION START -->
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">
					Exercise Super Set 1 (change this to something more insightful tia) ((make this a collapsable section for super sets))
				</div>
			</div>
<!-- REPEATING COLLAPSE AREA START -->
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">
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
					<select style="width: 100%" name="exercise[default]" id="exercise-dropdown" data-category-set="default" required>
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
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">
					Notes
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell">
					<textarea style="width: 100%" type="text" id="notes-input" name="exerciseNotes[default]" data-category-set="default"></textarea>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">
					Rest (mins)
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell">
					<input style="width: 100%" type="text" id="rest-time-input" name="restTime[default]" placeholder="Rest (mins)" data-category-set="default" required/>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">Row and Column Data</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<!--

				[?] tooltip stuff to explain what they do

				-->
				<div class="test-fauxtable-header">Sets [?]</div>
				<div class="test-fauxtable-header">Sessions [?]</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell">
					<input type="text" name="sets[default]" value="1" id="sets-input" placeholder="Sets" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" name="sessions[default]" value="1" id="sessions-input" placeholder="Sessions" data-category-set="default"/>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-header">Set data</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-header">Reps</div>
				<div class="test-fauxtable-header">%1RM</div>
				<div class="test-fauxtable-header">1 RM</div>
			</div>
			<div class="test-fauxtable-tablerow" data-template-row data-input-index="0">
				<div class="test-fauxtable-tablecell">
					<input type="number" value="1" min="1" max="10" step="1" name="reps[default][]" id="reps-input" placeholder="reps" data-category-set="default" required/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" value="1" name="1RMPercent[default][]" id="1RMPercent-input" placeholder="%1RM" data-category-set="default"/>
				</div>
				<div class="test-fauxtable-tablecell">
					<input type="text" value="1" name="1RM[default][]" id="1RM-input" placeholder="1RM" data-category-set="default"/>
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell">
					<button id="add-superset" data-input-index="0" data-category-set="default" disabled>Add extra exercise (dummied)</button>
				</div>
			</div>
<!-- REPEATING COLLAPSE AREA END -->
<!-- SUPERSET DATA SECTION START -->
			<div class="test-fauxtable-tablerow">
				<div class="table-title test-fauxtable-tablecell">
					Extras
				</div>
			</div>
			<div class="test-fauxtable-tablerow">
				<div class="test-fauxtable-tablecell">
					<textarea style="width: 100%" id="extra-notes" name="extraNotes[default]" data-category-set="default"></textarea>
				</div>
			</div>
		</div>
	</div>

	<button type="submit">Preview Generated Template</button>

</form>
