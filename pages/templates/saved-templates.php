<?php

$savedTemplates = $System->GetFitnessTemplateSystem()->GetSavedTemplatesList();

?>

<table>
	<tr>
		<th style="text-align:center;">Template Name</th>
		<th style="text-align:center;">Created On</th>
		<th style="text-align:center;">Author</th>
		<th style="text-align:center;">Actions</th>
	</tr>

<?php
	// This could probably be done as a table as well, for sorting reasons and etc
    foreach($savedTemplates as $key => $value) {
?>
	<tr>

		<td style="text-align:center;" class="saved-template-name">
			<?php echo $value["title"]; ?>
		</td>
		<td style="text-align:center;">
			<?php echo date('d/m/Y',strtotime($value["dateAdded"])); ?>
		</td>
		<td style="text-align:center;">
			<?php echo $value["author"]; ?>
		</td>

		<td style="text-align:center;" class="saved-template-actions">
			<a class="button" href="templates.php?a=view&amp;id=<?php echo $value["templateUID"]; ?>">View</a>
			<a class="button"href="templates.php?a=edit&amp;id=<?php echo $value["templateUID"]; ?>">Edit</a>
		</td>

	</tr>
<?php
	}
?>

</table>