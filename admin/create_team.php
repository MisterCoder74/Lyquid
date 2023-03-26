<?php
// read teams.json file
$teams = json_decode(file_get_contents('../dbs/teams.json'), true);

// generate unique team ID
$team_id = uniqid();

// retrieve data from form
$team_name = $_POST['team_name'];
$team_members = $_POST['team_members'];

// create new team object
$new_team = array(
	'id' => $team_id,
	'name' => $team_name,
	'members' => $team_members,
        'projects' => array()
);

// add new team to teams array
array_push($teams, $new_team);

// write updated teams array to teams.json file
file_put_contents('../dbs/teams.json', json_encode($teams));

// redirect back to form
header("Location: usersteam_manager.php");
exit();
?>
