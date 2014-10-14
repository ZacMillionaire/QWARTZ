<?php

$savedTemplates = $System->GetFitnessTemplateSystem()->GetSavedTemplatesList();

?>

<table>
			<tr>
			<th>Template Name</th>
			<th>Created On</th>
			<th>Author</th>
			<th>Actions</th>
		</tr>

<?php
	// This could probably be done as a table as well, for sorting reasons and etc
    foreach($savedTemplates as $key => $value) {
?>
	<tr>

		<td class="saved-template-name">
			<?php echo $value["title"]; ?>
			
		</td>
		<td><?php echo $value["dateAdded"]; ?></td>
		<td>#CREATOR</td>

		<td class="saved-template-actions">
		<a class="button" href="templates.php?a=view&amp;id=<?php echo $value["templateUID"]; ?>">View Template</a>
		<a class="button"href="templates.php?a=edit&amp;id=<?php echo $value["templateUID"]; ?>">(NYI) Edit Template (with ID)</a>
		</td>

	</tr>
<?php
	}
?>

</table>