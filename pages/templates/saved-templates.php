<?php

$savedTemplates = $System->GetFitnessTemplateSystem()->GetSavedTemplatesList();

?>

<div class="template-list-container">

<?php
	// This could probably be done as a table as well, for sorting reasons and etc
    foreach($savedTemplates as $key => $value) {
?>
	<div class="saved-template-item">

		<div class="saved-template-details">
			<div class="template-name"><?php echo $value["title"]; ?></div>
			<div class="template-date">Date Created: <?php echo $value["dateAdded"]; ?></div>
		</div>

		<div class="saved-template-actions">
			<ul>
				<li><a href="templates.php?a=view&amp;id=<?php echo $value["templateUID"]; ?>">View this template</a></li>
				<li><a href="templates.php?a=edit&amp;id=<?php echo $value["templateUID"]; ?>">(partial NYI) Edit this template (with ID)</a></li>
			</ul>
		</div>

	</div>
<?php
	}
?>

</div>