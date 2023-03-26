<?php

$file = fopen('../dbs/admin_kanban.json', 'r');
$data = fread($file, filesize('../dbs/admin_kanban.json'));
fclose($file);

echo $data;

?>