<?php 

$Data = $System->GetDataCollectionSystem();

// update player row with last edited data
$Players = $System->GetPlayerSystem();

$playerID = (isset($_GET["playerID"])) ? $_GET["playerID"] : $_GET["id"];
$playerData = $Data->GetPlayerDetailsByID($playerID);


?>

<?php if(isset($_GET["e"])) { ?>

<div class="input-error">
	<?php echo $_GET["e"]; ?>
</div>

<?php } ?>

<?php

    $playerLockData = $System->GetDataLockSystem()->GetPlayerDataLockStatus($_GET["id"]);
	$rowUnlocks = strtotime("+5 minutes", strtotime($playerLockData["lastEditDateTime"]));

	if(time() < $rowUnlocks && $userData["userID"] != $playerLockData["lastEditOwner"]){

		$timeTillUnlock = number_format(($rowUnlocks - time())/60,0);

?>

	<div id="edit-warning">
		Editing this player is locked for another <?php echo $timeTillUnlock; ?> minute<?php echo ($timeTillUnlock > 1) ? "s" : ""; ?>.
		<?php 
			if($userData["userID"] == $playerLockData["lastEditOwner"]) {
		?>
			<div id="edit-owner-message">
				However, you are the owner of this edit and are not restricted by this lockout.
			</div>
		<?php
			}
		?>
	</div>

<?php 
	} else {
?>

<div id="table-container">
	<form action="sys/exec/update-player.php" method="POST">
		<input type="hidden" name="playerID" value="<?php echo (isset($_GET["playerID"])) ? $_GET["playerID"] : $playerData["PlayerID"]; ?>">
	<table>
		<tr>
			<th colspan="2" class="table-title">Edit <?php echo $playerData["FirstName"]." ".$playerData["LastName"]; ?></th>
		</tr>
		<tr>
			<td>
				First Name
			</td>
			<td>
				<input value="<?php echo (isset($_GET["FirstName"])) ? $_GET["FirstName"] : $playerData["FirstName"]; ?>" style="width:100%;" type="text" name="firstName" placeholder="First Name"/>
			</td>
		</tr>
		<tr>
			<td>
				Last Name
			</td>
			<td>
				<input value="<?php echo (isset($_GET["LastName"])) ? $_GET["LastName"] : $playerData["LastName"]; ?>" style="width:100%;" type="text" name="lastName" placeholder="Last Name" required/>
			</td>
		</tr>
		<tr>
			<td>
				Position
			</td>
			<td>
				<input value="<?php echo (isset($_GET["Position"])) ? $_GET["Position"] : $playerData["Position"]; ?>" style="width:100%;" type="text" name="position" placeholder="Position" required/>
			</td>
		</tr>
		<tr>
			<td>
				Weight
			</td>
			<td>
				<input value="<?php echo (isset($_GET["Weight"])) ? $_GET["Weight"] : $playerData["Weight"]; ?>" style="width:100%;" type="number" name="weight" placeholder="Weight" required/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button style="width:100%;" type="submit" class="button">Update Player</button>
			</td>
		</tr>
	</table>
	</form>
</div>
<?php

}

?>