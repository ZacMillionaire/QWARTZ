<?php

$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$players = $System->GetDataCollectionSystem()->GetPlayerList();
$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

?>

<div id="table-container">
	<?php include "search-form.php"; ?>
</div>

<?php

	$pastTestData = $System->GetSearchSystem()->GetPreviousTestEntriesByRange();

?>

<div class="previous-test-list">
	## TODO: add some padding for the previous test container
	<table>
		<tr>
			<th colspan="5" class="table-title">Previous Tests: Most recent 30</th>
		</tr>
		<tr>
			<th>Date</th>
			<th>Player</th>
			<th>Exercises</th>
			<th colspan="2">Actions</th>
		</tr>
		<?php
			foreach($pastTestData as $key => $value) {
		?>
		<tr>
			<td>
				<?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?>
			</td>
			<td>
				<a href="players.php?id=<?php echo $value["playerID"]; ?>">
					<?php 
						echo $value["firstName"]." ".$value["lastName"];
					?>
				</a>
			</td>
			<td>
				<?php

					echo $value["exercises"];

				?>
			</td>
			<td>
				<a class="button" href="tests.php?a=view&amp;id=<?php echo $value["fitnessTestGroupID"]; ?>#test-row-<?php echo $value["testID"]; ?>">View Test</a>
			</td>
			<td>
				<a class="button" href="tests.php?a=edit&amp;m=single&amp;tid=<?php echo $value["testID"]; ?>">Edit Data</a>
			</td>
		</tr>
		<?php	
			}
		?>
	</table>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
	$(".date-picker").datepicker();
});
</script>