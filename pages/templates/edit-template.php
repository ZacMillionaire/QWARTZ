<pre>
<?php

$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();

$FitnessTemplateSystem = $System->GetFitnessTemplateSystem();

$baseTemplateData = $FitnessTemplateSystem->GetSavedTemplatesByID($_GET['id']);

$templateDataString = $FitnessTemplateSystem->DecodeTemplateDataString($baseTemplateData["templateDataString"]);

print_r($templateDataString);

?>