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
<form action="sys/exec/preview-new-template.php" method="POST">

	<div id="new-test-sticky">

		<button id="add-exercise" class="button-small">
			Add Exercise
		</button>

	</div>

	<div id="table-container">
		<table>
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

								printf(
									"<option value=\"%s\">%s</option>",
									$value["PlayerID"],
									$value["FirstName"]." ".$value["LastName"]
								);

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
						type="text"
						name="sessions"
						value="1"
						id="sessions-input"
						placeholder="Sessions"
						disabled
					/>
				</td>
			</tr>
		</table>
		<br/>
<!-- REPEATING AREA START -->
		<table id="exercise-table">
			<tr>
				<th class="table-title" colspan="3">
 					Exercise
				</th>
			</tr>
			<tr>
				<td colspan="3">
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
						name="exercise[default]"
						id="exercise-dropdown"
						data-category-set="default"
						required
						disabled
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
			</tr>
			<tr>
				<th colspan="3">
					<input
						type="checkbox"
						id="mark-superset"
						name="superset[default]"
						data-input-index="0"
						data-category-set="default"
						disabled
					/>
					Exercise is superset [?] (this could look better)
				</th>
			</tr>
			<tr>
				<th class="table-title" colspan="3">
					Rest (mins)
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<input
						style="width: 100%"
						type="text"
						id="rest-time-input"
						name="restTime[default]"
						placeholder="Rest (mins)"
						data-category-set="default"
						required
						disabled
					/>
				</td>
			</tr>
			<tr>
				<!--

				[?] tooltip stuff to explain what they do

				-->
				<th class="table-title" colspan="3">Sets [?]</th>
			</tr>
			<tr>
				<td colspan="3">
					<input
						type="text"
						name="sets[default]"
						value="1"
						id="sets-input"
						placeholder="Sets"
						data-category-set="default"
						disabled
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
						type="number"
						min="1"
						max="10"
						step="1"
						name="reps[default]"
						id="reps-input"
						placeholder="reps"
						data-category-set="default"
						required
						disabled
					/>
				</td>
				<td>
					<input
						type="text"
						name="oneRM[default]"
						id="oneRM-input"
						placeholder="1RM"
						data-category-set="default"
						disabled
					/>
				</td>
				<td>
					<input
						type="text"
						name="oneRMPercent[default]"
						id="oneRMPercent-input"
						placeholder="%1RM"
						data-category-set="default"
						disabled
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
						type="text"
						name="sessionEstimated[default]"
						id="estimated-session-input"
						placeholder="Est"
						data-category-set="default"
						disabled
					/>
				</td>
				<td>
					<input
						type="text"
						value="Target"
						name="sessionTarget[default]"
						id="target-session-input"
						placeholder="target"
						data-category-set="default"
						disabled
					/>
				</td>
				<td>
					<input
						type="text"
						name="sessionReps[default]"
						id="reps-session-input"
						placeholder="Reps"
						data-category-set="default"
						disabled
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
						name="exerciseNotes[default]"
						data-category-set="default"
						disabled
						></textarea>
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
						disabled
						></textarea>
				</td>
			</tr>
		</table>
	</div>

	<button id="preview-template-button" type="submit" disabled>Preview Generated Template</button>

</form>

<script src="js/fitnessTemplates.js"></script>