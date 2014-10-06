<?php

$Data = $System->GetDataCollectionSystem();
$Search = $System->GetSearchSystem();

$players = $System->GetDataCollectionSystem()->GetPlayerList();
$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

if(isset($_POST)){

	$nullKeys = 0;
	foreach ($_POST as $key => $value) {
		if($value == null){
			$nullKeys++;
		}
	}

	if($nullKeys != count($_POST)){
		$searchResults = $System->GetSearchSystem()->GetFilteredSearchResults($_POST);
	}
}

?>

<div id="table-container">
	<?php include "search-form.php"; ?>
</div>
<div id="search-results-container">

	<h1>Search Results</h3>

	<div class="search-results-table">
		<?php 
			if(!isset($searchResults)){
		?>
		<div class="search-error">
			<h2>Please enter values to filter by.</h2>
		</div>
		<?php
			} elseif(!$searchResults){
		?>
		<div class="search-error">
			<h2>No data was found matching your query.</h2>
		</div>
		<?php
			} else {
		?>
		<table>
			<tr>
				<th>Date</th>
				<th>Player</th>
				<th>Exercises</th>
				<th colspan="2">Actions</th>
			</tr>

			<?php
				foreach($searchResults as $key => $value) {
			?>
			<tr>
				<td>
					<?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?>
				</td>
				<td>
					<a href="players.php?id=<?php echo $value["PlayerID"]; ?>">
						(NYI) 
						<?php 
							echo $value["FirstName"]." ".$value["LastName"];
						?>
					</a>
				</td>
				<td>
					<?php

						echo $value["ExerciseName"];

					?>
				</td>
				<td>
					<a class="button" href="tests.php?a=view&amp;id=<?php echo $value["fitnessTestGroupID"]; ?>#test-row-<?php echo $value["playerTestID"]; ?>">View Test</a>
				</td>
				<td>
					<a class="button" href="tests.php?a=edit&amp;id=<?php echo $value["playerTestID"]; ?>">(NYI) Edit Data</a>
				</td>
			</tr>
			<?php
				}
			?>

		</table>
		<?php
			}
		?>
	</div>
	
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
	$(".date-picker").datepicker();
});
</script>