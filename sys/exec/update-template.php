<?php

/*

	TODO : tidy this shit up

 */


include "../system.php";

$System = new System();
$Database = $System->GetDatabaseSystem();
$Data = $System->GetDataCollectionSystem();
$FitnessTemplateSystem = $System->GetFitnessTemplateSystem();

$templateUID = $FitnessTemplateSystem->UpdateTemplateData($_POST);

header("Location: ../../templates.php?a=view&id=".$templateUID);

?>