<?php

$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();
$FitnessTemplateSystem = $System->GetFitnessTemplateSystem();

$baseTemplateData = $FitnessTemplateSystem->GetSavedTemplatesByID($_GET['id']);

$playerData = $Data->GetPlayerDetailsByID($baseTemplateData["playerID"]);
$exercises = $System->GetDataCollectionSystem()->GetExerciseList();

$templateArray = $FitnessTemplateSystem->DecodeTemplateDataString($baseTemplateData["templateDataString"]);

$numberOfColumnsForExercise = 7;
$numberOfColumnsInSet = 3;


$GeneratedTable = $FitnessTemplateSystem->GenerateTableFromData($templateArray,$playerData,$exercises);


?>
<div id="new-test-sticky">

	<a id="edit-template-button" href="templates.php?a=edit&amp;id=<?php echo $_GET["id"]; ?>">
		Edit Template
	</a>
	<a id="print-template-button" href="templates.php?a=print&amp;id=<?php echo $_GET["id"]; ?>">
		Print Template
	</a>

</div>

<div id="template-name">
	<h2><?php echo $templateArray["templateName"]; ?> - <?php echo $baseTemplateData["dateAdded"]; ?></h2>
</div>

<div id="template-table-container">
	<?php
		echo $GeneratedTable;
	?>
</div>