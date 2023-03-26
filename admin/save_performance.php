<?php
	// Read the user performance data from the request body
	$user_performance = json_decode(file_get_contents('php://input'), true);

	// Write the user performance data to a new file called user_performance.json
	file_put_contents('user_performance.json', json_encode($user_performance));
?>
