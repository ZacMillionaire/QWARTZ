<?php if(isset($_GET["e"])) { ?>

<div class="input-error">
	<?php echo $_GET["e"]; ?>
</div>

<?php } ?>

<div id="table-container">
	<form action="sys/exec/create-new-player.php" method="POST">
	<table>
		<tr>
			<th colspan="2" class="table-title">New Player</th>
		</tr>
		<tr>
			<td>
				First Name
			</td>
			<td>
				<input value="<?php echo @$_GET["firstName"]; ?>" style="width:100%;" type="text" name="firstName" placeholder="First Name" required/>
			</td>
		</tr>
		<tr>
			<td>
				Last Name
			</td>
			<td>
				<input value="<?php echo @$_GET["lastName"]; ?>" style="width:100%;" type="text" name="lastName" placeholder="Last Name" required/>
			</td>
		</tr>
		<tr>
			<td>
				Position
			</td>
			<td>
				<input value="<?php echo @$_GET["position"]; ?>" style="width:100%;" type="text" name="position" placeholder="Position" required/>
			</td>
		</tr>
		<tr>
			<td>
				Weight
			</td>
			<td>
				<input value="<?php echo @$_GET["weight"]; ?>" style="width:100%;" type="number" name="weight" placeholder="Weight" required/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<button style="width:100%;" class="button" type="submit">Create Player</button>
			</td>
		</tr>
	</table>
	</form>
</div>