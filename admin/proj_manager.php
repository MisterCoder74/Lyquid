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
            width: 60%;
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
            width: 90%;
            padding: 10px 14px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 8px;
            color: white;
        }
            
      table {
width: 90%;
box-shadow: 0px 4px 10px grey;
border-radius: 8px;
padding: 4px;
margin: 10px auto;

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
<a class="navbar-brand rounded middle active" href="#" target="">Projects</a>
<a class="navbar-brand rounded middle" href="usersteam_manager.php" target="">Users / Teams</a>
<a class="navbar-brand rounded middle" href="clients_manager.php" target="">Clients</a>
<a class="navbar-brand rounded middle" href="performance_manager.php" target="">Performances</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Admin Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="adminlogout.php"><b>Disconnect!</b></a></small></span>
<hr>

   <h3>Create Project</h3>
   <form method="post">
	<table>
	<tr>
		<td><label for="name">Project Name:</label><br><input type="text" name="name" required onchange="document.getElementById('folder').value = this.value;"></td>

		<td><label for="code">Project Code:</label><br><input type="text" name="code" required></td>
	</tr>
	<tr>
		<td><label for="client">Client:</label><br>
                <select name="client" required>
						<option value="">Select a client...</option>
						<?php
						// read clients from file
						$clients = json_decode(file_get_contents('../dbs/clients.json'), true);

						// loop through clients and create option for each one
						foreach ($clients as $client) {
							echo "<option value=\"" . $client['name'] . "\">" . $client['name'] . "</option>";
						}
						?>
					</select>
                </td>
		<td><label for="budget">Budget (€):</label><br><input type="text" name="budget"></td>
	</tr>
	<tr>
		<td><label for="user">Assigned User:</label><br>
			<select name="user" required>
				<option value="">Select User</option>
				<?php
				// Read the user list from the JSON file
				$user_list = file_get_contents('../dbs/userlist.json');
				$users = json_decode($user_list, true);

				// Display the users in the select list
				foreach ($users as $user) {
					echo "<option value=\"" . $user['Surname'] . "\">" . $user['Surname'] . "</option>";
				}
				?>
			</select>
		</td>
		<td><label for="folder">Project Folder:</label><br><input type="text" id="folder" name="folder" required></td>
	</tr>
	<tr>
		<td><label for="coordinator">Reference Person:</label><br><input type="text" name="coordinator" required></td>
		<td><label for="status">Status:</label><br>
			<select name="status" required>
				<option value="">Select Status</option>
				<option value="proposal">Proposal</option>
				<option value="started">Started</option>
				<option value="accepted">Accepted</option>
				<option value="rejected">Rejected</option>
				<option value="completed">Completed</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><label for="startdate">Start Date:</label><br><input type="date" name="startdate" required></td>
		<td><label for="duedate">Due Date:</label><br><input type="date" name="duedate" required></td>
	</tr>
	
		
	
</table>
<input class="btn btn-success" type="submit" name="submit" value="Create Project">
</form>


	<hr>

	<h3>Projects List</h3>
	<table>
		<thead>
			<tr>
				<th>ID</th>
                                <th>Name</th>
				<th>Code</th>
				<th>Client</th>                                
				<th>Budget</th>                                                                
				<th>Status</th>
				<th>Start Date</th>
       				<th>Due Date</th>
                                <th>Assigned to</th>
                                <th>Reference</th>                                
                                <th>Folder</th>


			</tr>
		</thead>
		<tbody>
			<?php
	if (isset($_POST['submit'])) {
		// Get the project data from the form
                $id = substr(str_shuffle('abcdefghijkmnopqrstuvwxyz1234567890ABCDEFGHIJKMNOPQRSTUVWXYZ'),0,10);
		$name = $_POST['name'];
		$code = $_POST['code'];
		$client = $_POST['client'];                
		$user = $_POST['user'];
		$folder = $_POST['folder'];
        $status = $_POST['status'];
        $coordinator = $_POST['coordinator'];
        $budget = $_POST['budget'];
        $startdate = $_POST['startdate'];
        $duedate = $_POST['duedate'];        

		// Create a new project array
		$new_project = array(
			'id' => $id,
                        'name' => $name,
			'code' => $code,
                        'client' => $client,
			'user' => $user,
                        'folder' => $folder,
			'budget' => $budget,
			'status' => $status,
                        'coordinator' => $coordinator,
                        'startdate' => $startdate,
                        'duedate' => $duedate
		);

		// Read the existing project list from the JSON file
		$project_list = file_get_contents('../dbs/projectlist.json');
		$projects = json_decode($project_list, true);

		// Add the new project to the project list
		$projects[] = $new_project;

		// Write the updated project list back to the JSON file
		$updated_project_list = json_encode($projects, JSON_PRETTY_PRINT);
		file_put_contents('../dbs/projectlist.json', $updated_project_list);

		// Create a copy of the projdata folder in the new project folder
		if (!file_exists('../projects/'.$folder)) {
			mkdir('../projects/'.$folder);
			$source_folder = 'projdata';
			$files = scandir('../'.$source_folder);
			foreach ($files as $file) {
				if ($file !== '.' && $file !== '..') {
					copy('../' . $source_folder . '/' . $file, '../projects/' . $folder . '/' . $file);
				}
			}
			// Write the project details to the projectdetails.json file
			$project_details = json_encode($new_project, JSON_PRETTY_PRINT);
			file_put_contents('../projects/'.$folder . '/projectdetails.json', $project_details);
		}
	}

	// Display the project list in a table
	$project_list = file_get_contents('../dbs/projectlist.json');
	$projects = json_decode($project_list, true);

	foreach ($projects as $project) {
		echo "<tr>";
		echo "<td>" . $project['id'] . "</td>";
                echo "<td>" . $project['name'] . "</td>";
		echo "<td>" . $project['code'] . "</td>";
		echo "<td>" . $project['client'] . "</td>";                
		echo "<td>" . $project['budget'] . "</td>";                           
		echo "<td>" . $project['status'] . "</td>";                
		echo "<td>" . $project['startdate'] . "</td>";
		echo "<td>" . $project['duedate'] . "</td>";                
		echo "<td>" . $project['user'] . "</td>";
		echo "<td>" . $project['coordinator'] . "</td>";                
                echo "<td><a href='" . '../projects/'.$project['folder'] . "/management.php'>" . $project['folder'] . "</a></td>";                
		echo "</tr>";
	}
?>

		</tbody>
	</table>
<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>

</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
