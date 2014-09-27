<?php
/*

	// ignore this for now

	switch (@$_GET['e']) {

		case 'no_id':
			$error = "No ID specified to edit.";
			break;
		
		case 'bad_id':
			$error = "Malformed ID, or template with that ID does not exist.";
			break;
		
		default:
			$error = null;
			break;
	}

?>
<?php
if(isset($error)){
	?>
<div class="error-container">
	<?php
		echo $error;
	?>
</div>
<?php
}
*/

	$savedTemplates = $System->GetFitnessTemplateSystem()->GetSavedTemplatesList();

?>

saved template list
<div class="template-list-container">

<?php
    foreach($savedTemplates as $key => $value) {
?>
	<div class="saved-template-item">

		<div class="saved-template-details">
			<div class="template-name">Template Name (COMING SOON!)</div>
			<div class="template-date"><?php echo $value["dateAdded"]; ?></div>
		</div>

		<div class="saved-template-actions">
			<ul>
				<li><a href="templates.php?a=print&amp;id=<?php echo $value["templateID"]; ?>">(partial NYI) Print this template</a></li>
				<li><a href="templates.php?a=edit&amp;id=<?php echo $value["templateID"]; ?>">(partial NYI) Edit this template (with ID)</a></li>
			</ul>
		</div>

	</div>
<?php
	}
?>

</div>