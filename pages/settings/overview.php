<?php

$Data = $System->GetDataCollectionSystem();

$repTable = $Data->GetRepTable();
$readOnlyDuration = $Data->GetReadOnlyDuration();

?>
<div id="table-container">
	<form action="sys/exec/update-rep-table.php" method="POST">
		<table>
			<tr>
				<th colspan="2">Change Rep Lookup Table</th>
			</tr>
			<tr>
				<th>Rep Count</th>
				<th>Modifier</th>
			</tr>
			<tr>
				<td colspan="2">Please note that this will not affect previously entered test data. Only new, and edited data, will be affected.</td>
			</tr>
			<?php 
				foreach ($repTable as $key => $value) {
			?>
			<tr>
				<td><?php echo $key; ?></td>
				<td><input name="reps[<?php echo $key; ?>]" style="width:100%" type="text" pattern="[0-9.]+" value="<?php echo $value; ?>" required /></td>
			</tr>
			<?php
				}
			?>
			<tr>
				<td colspan="2"><button class="button" style="width:100%" type="submit">Update Rep Table Values</button></td>
			</tr>
		</table>
	</form>
	<form action="sys/exec/update-readonly-duration.php" method="POST">
		<table>
			<tr>
				<th colspan="2">Change Read-Only Duration</th>
			</tr>
			<tr>
				<td colspan="2">Value represents how long a page is marked as read only after being edited be a user. Number indicates the number of minutes required.</td>
			</tr>
			<tr>
				<td>Read-only Duration (as minutes)</td>
				<td><input style="width:100%" type="text" name="duration" pattern="[0-9]{1,}" value="<?php echo $readOnlyDuration; ?>" required/></td>
			</tr>
			<tr>
				<td colspan="2"><button class="button" style="width:100%" type="submit">Update Read Only Duration</button></td>
			</tr>
		</table>
	</form>
</div>