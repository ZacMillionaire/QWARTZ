<?php

include "../system.php";

$Data = new DataCollection();

$repTable = $Data->UpdateRepTable($_POST);

header("Location: ../../settings.php");

?>