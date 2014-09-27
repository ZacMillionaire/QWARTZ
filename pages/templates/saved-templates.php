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
?>

saved template list
<div class="template-list-container">

	<div class="saved-template-item">

		<div class="saved-template-details">
			<div class="template-name">Template Name</div>
			<div class="template-date">Template Date</div>
		</div>

		<div class="saved-template-actions">
			<a href="templates.php?a=print">Print this template</a>
			<a href="templates.php?a=edit">Edit this template (no ID)</a>
			<a href="templates.php?a=edit&amp;id=abcd1234">Edit this template (with ID)</a>
			<a href="templates.php?a=edit&amp;id=abcd1234xx">Edit this template (bad ID)</a>
		</div>

	</div>

	<div class="saved-template-item">

		<div class="saved-template-details">
			<div class="template-name">Template Name</div>
			<div class="template-date">Template Date</div>
		</div>

		<div class="saved-template-actions">
			<a href="templates.php?a=print">Print this template</a>
			<a href="templates.php?a=edit">Edit this template (no ID)</a>
			<a href="templates.php?a=edit&amp;id=abcd1234">Edit this template (with ID)</a>
		</div>

	</div>

	<div class="saved-template-item">

		<div class="saved-template-details">
			<div class="template-name">Template Name</div>
			<div class="template-date">Template Date</div>
		</div>

		<div class="saved-template-actions">
			<a href="templates.php?a=print">Print this template</a>
			<a href="templates.php?a=edit">Edit this template (no ID)</a>
			<a href="templates.php?a=edit&amp;id=abcd1234">Edit this template (with ID)</a>
		</div>

	</div>

</div>