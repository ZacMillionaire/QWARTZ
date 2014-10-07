<?php 

$Data = $System->GetDataCollectionSystem();

$playerID = (isset($_GET["playerID"])) ? $_GET["playerID"] : $_GET["id"];
$playerData = $Data->GetPlayerDetailsByID($playerID);

?>

<?php if(isset($_GET["e"])) { ?>

<div class="input-error">
	<?php echo $_GET["e"]; ?>
</div>

<?php } ?>

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