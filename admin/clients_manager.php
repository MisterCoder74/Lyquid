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
background-color: #acdf87;
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
<a class="navbar-brand rounded middle" href="usersteam_manager.php" target="">Users / Teams</a>
<a class="navbar-brand rounded middle active" href="#" target="">Clients</a>
<a class="navbar-brand rounded middle" href="performance_manager.php" target="">Performances</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Admin Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="adminlogout.php"><b>Disconnect!</b></a></small></span>
<hr>


	<h1>Create Client</h1>
	<form action="manage_client.php" method="post">
		<table>

			<tr>
				<td><label for="name">Name:</label><br>
				<input type="text" id="name" name="name" required></td>
			</tr>
			<tr>
				<td><label for="address">Address:</label><br>
				<input type="text" id="address" name="address" required></td>
			</tr>
			<tr>
				<td><label for="reference_person">Reference Person:</label><br>
				<input type="text" id="reference_person" name="reference_person" required></td>
			</tr>
			<tr>
				<td><label for="reference_phone">Reference Phone:</label><br>
				<input type="text" id="reference_phone" name="reference_phone" required></td>
			</tr>
			<tr>
				<td><label for="reference_email">Reference Email:</label><br>
				<input type="text" id="reference_email" name="reference_email" required></td>
			</tr>
		</table>
		<input class="btn btn-success" type="submit" value="Submit">
	</form>
<hr>
<h1>Clients List</h1>
	<table border="1">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Address</th>
				<th>Reference Person</th>
				<th>Reference Phone</th>
				<th>Reference Email</th>
				<th>Granted Projects</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// read clients from file
			$clients = json_decode(file_get_contents('../dbs/clients.json'), true);

			// read projects from file
			$projects = json_decode(file_get_contents('../dbs/projectlist.json'), true);
			
			// loop through clients and display data in table rows
			foreach ($clients as $client) {
				echo "<tr>";
				echo "<td>" . $client['id'] . "</td>";
				echo "<td>" . $client['name'] . "</td>";
				echo "<td>" . $client['address'] . "</td>";
				echo "<td>" . $client['reference_person'] . "</td>";
				echo "<td>" . $client['reference_phone'] . "</td>";
				echo "<td>" . $client['reference_email'] . "</td>";

				// find projects that match the client's name
				$granted_projects = array();
				foreach ($projects as $project) {
					if ($project['client'] === $client['name']) {
						$granted_projects[] = $project['name'];
					}
				}
				echo "<td>" . implode(', ', $granted_projects) . "</td>";
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
