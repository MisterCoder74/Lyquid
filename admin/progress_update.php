<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Read the project list from projectlist.json
	$projects = json_decode(file_get_contents('../dbs/projectlist.json'), true);

	// Update the progress value for the specified project
	$index = $_POST['index'];
	$newProgress = $_POST['progress'];
	$projects[$index]['progress'] = $newProgress;

	// Save the updated project list to projectlist.json
	$file = fopen('../dbs/projectlist.json', 'w');
	fwrite($file, json_encode($projects));
	fclose($file);

	echo 'Progress updated successfully';
}
