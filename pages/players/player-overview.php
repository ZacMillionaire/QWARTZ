<?php

$Players = $System->GetPlayerSystem();


$playerData = $Players->GetPlayerData($_GET["id"]);


//print_r($playerData);

?>

<?php

    $lockData = $System->GetDataLockSystem()->GetPlayerDataLockStatus($_GET["id"]);
	$rowUnlocks = strtotime("+5 minutes", strtotime($lockData["lastEditDateTime"]));
	$editOwner = ($userData["userID"] == $lockData["lastEditOwner"]);
    $pageReadOnly =(time() < $rowUnlocks);

    if($pageReadOnly){

		$timeTillUnlock = number_format(($rowUnlocks - time())/60,0);

		include "pages/fragments/lockout.php";

	}

?>

	<div class="player-card-single">
		<div class="player-profile-picture">
			<img src="<?php echo ($playerData["playerInfo"]["profilePicture"] != null)?$playerData["playerInfo"]["profilePicture"]:"images/default_profile.png"; ?>" alt="" />
		</div>
		<div class="player-name">
			<h2><?php echo $playerData["playerInfo"]["FirstName"]." ".$playerData["playerInfo"]["LastName"]; ?></h2>
		</div>
		<div class="player-position">
			<div class="profile-label">Position</div>
			<div class="profile-value"><?php echo $playerData["playerInfo"]["Position"]; ?></div>
		</div>
		<div class="player-weight">
			<div class="profile-label">Weight</div>
			<div class="profile-value"><?php echo $playerData["playerInfo"]["Weight"]; ?>KG</div>
		</div>
	</div>
<div class="previous-test-list">
	<!--
		future TODO: I should make the following a template as
		it's basically the same across lookup-results and lookup-form.php
	-->
	<table>
		<tr>
			<th colspan="5" class="table-title">Previous Tests</th>
		</tr>
		<tr>
			<th>Date</th>
			<th>Player</th>
			<th>Exercises</th>
			<th colspan="2">Actions</th>
		</tr>
		<?php
			// see line 87
			//$TestSystem = $System->GetFitnessTestSystem();
			foreach($playerData["testData"] as $key => $value) {
		?>
		<tr>
			<td>
				<?php echo date("d/m/Y",strtotime($value["DateEntered"])); ?>
			</td>
			<td>
				<a href="players.php?a=view&amp;id=<?php echo $value["PlayerID"]; ?>">
					<?php 
						echo $value["player_first"]." ".$value["player_last"];
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
				<?php
					/*
					this'll probably be a thing next meeting, but I'm commenting it out for now
					
					$lockData = $TestSystem->GetTestDataLockStatus($value["playerTestID"]);
					$rowUnlocks = strtotime("+5 minutes", strtotime($lockData["lastEditDateTime"]));

					if(time() < $rowUnlocks && $userData["userID"] != $lockData["lastEditOwner"]){
				?>

                <a class="button disabled">(NYI: disabled state)Edit Player</a>

				<?php
					} else { */
				?>
				<a class="button" href="tests.php?a=edit&amp;m=single&amp;tid=<?php echo $value["playerTestID"]; ?>">Edit Data</a>
				<?php
					//}
				?>
			</td>
		</tr>
		<?php	
			}
		?>
	</table>
</div>
<div class="player-template-list">
	<table>
		<tr>
			<th colspan="3" class="table-title">Related Templates</th>
		</tr>
		<tr>
			<th>Title</th>
			<th>Date</th>
			<th>&nbsp;</th>
		</tr>
		<?php
			foreach($playerData["templateData"] as $key => $value) {
		?>
		<tr>
			<td>
				<?php

					echo $value["title"];

				?>
			</td>
			<td>
				<?php echo date("d/m/Y",strtotime($value["dateAdded"])); ?>
			</td>
			<td>
				<a class="button" href="templates.php?a=view&amp;id=<?php echo $value["templateUID"]; ?>">View Template</a>
			</td>
		</tr>
		<?php	
			}
		?>
	</table>
</div>