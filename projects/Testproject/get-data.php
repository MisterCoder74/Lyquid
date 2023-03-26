<?php

$file = fopen('pjkanbandata.json', 'r');
$data = fread($file, filesize('pjkanbandata.json'));
fclose($file);

echo $data;

?>