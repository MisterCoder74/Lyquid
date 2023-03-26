<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not
    header('Location: ../../login.php');
    exit;
}

// Get the user data from the session
$user = $_SESSION['user'];



?>
<html>
<head>
<title>Lyquid - Project Area</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>



            
      table {
width: 1000px;
box-shadow: 0px 4px 10px grey;
border-radius: 8px;
padding: 4px;
margin-top: 10px;

}

td {
padding: 8px 4px;
font-size: 1.1rem;
width: 200px;
}

td {
border-bottom: 1px solid black;
background-color: #ddd;
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
<a class="navbar-brand rounded middle" href="../../user/userboard.php" target="">Main User Board</a>
<a class="navbar-brand rounded middle active" href="management.php" target="">Project Board</a>
<a class="navbar-brand rounded middle" href="pjkanban.php" target="">Project Kanban</a>
<a class="navbar-brand rounded middle" href="pjlogsystem.php" target="">Project Log</a>
<a class="navbar-brand rounded middle" href="pjsticky.php" target="">Project Sticky</a>
<a class="navbar-brand rounded middle" href="pjtaskmanager.php" target="">Project Tasks</a>

</div>
</nav>

<p>
</p>
<center>
<h3 class="padded">User Panel - Welcome, (<?php echo $user['Name']; ?>)</h3>
<span><small><a href="../../user/logout.php">Disconnect!</a></small></span>
<hr>

<?php
// Read the project details from the JSON file
$project_details = file_get_contents('projectdetails.json');
$project = json_decode($project_details, true);

// Create the HTML table with project details
echo "<h3>You are working on proj: " . $project['name'] . "</h3>";
echo "<table>";
echo "<tr><td>ID</td><td>" . $project['id'] . "</td></tr>";
echo "<tr><td>Name</td><td>" . $project['name'] . "</td></tr>";
echo "<tr><td>Code</td><td>" . $project['code'] . "</td></tr>";
echo "<tr><td>Client</td><td>" . $project['client'] . "</td></tr>";
echo "<tr><td>User</td><td>" . $project['user'] . "</td></tr>";
echo "<tr><td>Folder</td><td>" . $project['folder'] . "</td></tr>";
echo "<tr><td>Budget</td><td>" . $project['budget'] . "</td></tr>";
echo "<tr><td>Status</td><td>" . $project['status'] . "</td></tr>";
echo "<tr><td>Coordinator</td><td>" . $project['coordinator'] . "</td></tr>";
echo "<tr><td>Start Date</td><td>" . $project['startdate'] . "</td></tr>";
echo "<tr><td>Due Date</td><td>" . $project['duedate'] . "</td></tr>";
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
