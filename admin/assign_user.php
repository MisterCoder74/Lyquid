<?php
// read teams.json file
$teams = json_decode(file_get_contents('../dbs/teams.json'), true);

// read userlist.json file
$users = json_decode(file_get_contents('../dbs/userlist.json'), true);

// retrieve data from form
$team_id = $_POST['team_id'];
$user_id = $_POST['user_id'];

// find team with matching ID
$found_team = false;
foreach ($teams as &$team) {
	if ($team['id'] == $team_id) {
		// add new member to team
		if (!in_array($user_id, $team['members'])) {
			array_push($team['members'], $user_id);
			$found_team = true;
			break;
		} else {
			// user is already a member of the team
			echo "<script>
				  alert('The user is already in the chosen team');
				  window.location.href='usersteam_manager.php';
				  </script>";
			exit();
		}
	}
}

if (!$found_team) {
	// team with given ID was not found
	echo "Error: Team not found.";
	exit();
}

// update user's team in userlist.json
foreach ($users as &$user) {
	if ($user['Id'] == $user_id) {
		$user['Team'] = $team['name'];
		break;
	}
}

// write updated teams array to teams.json file
file_put_contents('../dbs/teams.json', json_encode($teams));

// write updated users array to userlist.json file
file_put_contents('../dbs/userlist.json', json_encode($users));

// redirect back to form
header("Location: usersteam_manager.php");
exit();
?>
