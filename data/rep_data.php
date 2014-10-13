<?php

require "../sys/system.php";

$Data = new DataCollection();

$repTable = $Data->GetRepTable();

header("Content-Type: application/json");
echo json_encode($repTable);

?>