<?php
require("../library/Date.php");
$date = new Apile\Date();
$variables = ${"_".$_SERVER['REQUEST_METHOD']};
$date->utc($variables['utc']);
echo $date->format($variables['format']);
?>
