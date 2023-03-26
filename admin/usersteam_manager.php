<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not
    header('Location: ../adminlogin.php');
    exit;
}

// Get the user data from the session
$user = $_SESSION['user'];



?>


<html>
<head>
<title>Lyquid - Admin Area</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>

a {
color: #14A44D;
}


form {
            width: 70%;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            border: 1px solid black;
            border-radius: 8px;
            box-shadow: 0px 4px 10px grey;
        }
        
        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 6px 14px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 8px;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 10px 14px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 8px;
            color: white;
        }
            
      table {
width: 80%;
box-shadow: 0px 4px 10px grey;
border-radius: 8px;
padding: 4px;
margin-top: 10px;

}

th, td {
padding: 8px 4px;
font-size: 1rem;
width: 10%;
text-align: center;

}

th {
border-bottom: 1px solid black;
background-color: #ccc;
}

h1 {
text-align: center;
}

h5,h4{
text-shadow: 2px 2px 4px grey;
}

h3 {
    font-size: 2rem;
    font-weight: 400;
    color: #000000;
    text-align: center;
text-shadow: 6px 6px 6px grey;
}

.active {
text-shadow: 2px 2px 4px grey;
}

.rounded:hover {
border-top: 1px solid grey;
border-bottom: 1px solid grey;
border-radius: 20px;
}
.middle {
font-size: 1.6rem;
}
.rounded {
padding: 8px;
border-top: 1px solid transparent;
border-bottom: 1px solid transparent;
}

.padded {
padding: 0px 10px;
margin: 2px;
}


    </style>
    
</head>
<body>
<nav class="navbar navbar-light bg-light">

<div class="container-fluid">
<a class="navbar-brand rounded middle" href="adminboard.php" target="">Admin Board</a>
<a class="navbar-brand rounded middle" href="proj_manager.php" target="">Projects</a>
<a class="navbar-brand rounded middle active" href="#" target="">Users / Teams</a>
<a class="navbar-brand rounded middle" href="clients_manager.php" target="">Clients</a>
<a class="navbar-brand rounded middle" href="performance_manager.php" target="">Performances</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Admin Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="adminlogout.php"><b>Disconnect!</b></a></small></span>
<hr>
<table>
<tr>
<td valign="top">
<h1>Create a New Team</h1>
	<form method="post" action="create_team.php">
		<label for="team-name">Team Name:</label>
		<input type="text" id="team-name" name="team_name" required><br><br>

		<label for="user-list">Select Team Members:</label>
		<select id="user-list" name="team_members[]" multiple required>
			<?php
			// read userlist.json file
			$user_list = json_decode(file_get_contents('../dbs/userlist.json'), true);
			foreach ($user_list as $user) {
				echo '<option value="'.$user['Id'].'">'.$user['Surname'].'</option>';
			}
			?>
		</select><br><br>

		<input class="btn btn-success" type="submit" value="Create Team">
	</form>
</td>
<td  valign="top">
<h1>Assign Users to Team</h1>
	<form method="post" action="assign_user.php">
		<label for="team-list">Select Team:</label>
		<select id="team-list" name="team_id" required>
			<?php
			// read teams.json file
			$teams = json_decode(file_get_contents('../dbs/teams.json'), true);
			foreach ($teams as $team) {
				echo '<option value="'.$team['id'].'">'.$team['name'].'</option>';
			}
			?>
		</select><br><br>

		<label for="user-list">Select User:</label>
		<select id="user-list" name="user_id" multiple required>
			<?php
			// read userlist.json file
			$user_list = json_decode(file_get_contents('../dbs/userlist.json'), true);
			foreach ($user_list as $user) {
				echo '<option value="'.$user['Id'].'">'.$user['Surname'].'</option>';
			}
			?>
		</select><br><br>

		<input class="btn btn-success" type="submit" value="Assign User">
	</form>
</td>
</tr>
<tr>

<td valign="top">
<h1>Assign Project to Team</h1>
	<form action="project_assignment.php" method="POST">
		<label for="team">Select Team:</label>
		<select name="team" id="team">
			<?php
				$teams = json_decode(file_get_contents("../dbs/teams.json"), true);
				foreach ($teams as $team) {
					echo "<option value='" . $team['id'] . "'>" . $team['name'] . "</option>";
				}
			?>
		</select>
		<br><br>
		<label for="project">Select Project:</label>
		<select name="project" id="project">
			<?php
				$projects = json_decode(file_get_contents("../dbs/projectlist.json"), true);
				foreach ($projects as $project) {
					echo "<option value='" . $project['id'] . "'>" . $project['name'] . "</option>";
				}
			?>
		</select>
		<br><br>
		<input class="btn btn-success" type="submit" name="submit" value="Assign Project">
	</form>
</td>
</tr>
</table>
	
<hr>

<?php
// Leggi i dati dal file teams.json
$teams = json_decode(file_get_contents("../dbs/teams.json"), true);

// Leggi i dati dal file projects.json e crea un array associativo che mappa gli ID dei progetti ai loro nomi
$projects = json_decode(file_get_contents("../dbs/projectlist.json"), true);
$projectNames = array();
foreach ($projects as $project) {
  $projectNames[$project['id']] = $project['name'];
}

// Leggi i dati dal file userlist.json e crea un array associativo che mappa gli ID degli utenti ai loro nomi
$users = json_decode(file_get_contents("../dbs/userlist.json"), true);
$userNames = array();
foreach ($users as $user) {
  $userNames[$user['Id']] = $user['Surname'];
}

// Costruisci la tabella HTML
echo "<table>";
echo "<tr><th>Team Name</th><th>Assigned Users</th><th>Assigned Projects</th></tr>";
foreach ($teams as $team) {
  echo "<tr>";
  echo "<td>" . $team['name'] . "</td>";
  echo "<td>" . implode(", ", array_map(function($userId) use ($userNames) { return $userNames[$userId]; }, $team['members'])) . "</td>";
  echo "<td>" . implode(", ", array_map(function($projectId) use ($projectNames) { return $projectNames[$projectId]; }, $team['projects'])) . "</td>";
  echo "</tr>";
}
echo "</table>";
?>


   <p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>

</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
