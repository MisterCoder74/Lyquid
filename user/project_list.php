<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not
    header('Location: ../login.php');
    exit;
}

// Get the user data from the session
$user = $_SESSION['user'];



?>


<html>
<head>
<title>Lyquid - User Area</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>



form {
            width: 30%;
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
text-align: justify;
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
<a class="navbar-brand rounded middle" href="userboard.php" target="">User Board</a>
<a class="navbar-brand rounded middle active" href="#" target="">Projects List</a>
<a class="navbar-brand rounded middle" href="log_system.php" target="">Log System</a>
<a class="navbar-brand rounded middle" href="jsonstickyboard.php" target="">Sticky Notes</a>
<a class="navbar-brand rounded middle" href="account.php" target="">Account</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">User Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="logout.php">Disconnect!</a></small></span>
<hr>

   	<h3>Project List</h3>
	<table>
		<thead>
			<tr>
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
	// Display the project list in a table
	$project_list = file_get_contents('../dbs/projectlist.json');
	$projects = json_decode($project_list, true);

	foreach ($projects as $project) {
		echo "<tr>";
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
