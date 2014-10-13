<?php

include "../system.php";

$Data = new DataCollection();

$repTable = $Data->UpdateReadOnlyDuration($_POST);

header("Location: ../../settings.php");

?>