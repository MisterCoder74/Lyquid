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
            width: 50%;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            border: 1px solid black;
            border-radius: 8px;
            box-shadow: 0px 4px 10px grey;
        }
        
        input[type="text"], select, textarea {
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
width: 1000px;
box-shadow: 0px 4px 10px grey;
border-radius: 8px;
padding: 4px;
margin-top: 10px;

}

th, td {
padding: 8px 4px;
font-size: 1.0rem;
}

th {
border-bottom: 1px solid black;
background-color: #ccc;
}

td:first-child, th:first-child {
width: 65%;
text-align: justify:
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
<a class="navbar-brand rounded middle" href="project_list.php" target="">Projects List</a>
<a class="navbar-brand rounded middle" href="log_system.php" target="">Log System</a>
<a class="navbar-brand rounded middle" href="jsonstickyboard.php" target="">Sticky Notes</a>
<a class="navbar-brand rounded middle active" href="account.php" target="">Account</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">User Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="logout.php">Disconnect!</a></small></span>
<hr>

   <h1>User Details</h1>

<?php
// Read the user details from the session
$surname = $_SESSION['Surname'];

// Read the project details from the JSON file
$project_details = file_get_contents('../dbs/projectlist.json');
$projects = json_decode($project_details, true);

// Find all projects that match the user's Surname
$user_projects = array();
foreach ($projects as $project) {
  if ($project['user'] == $surname) {
    $user_projects[] = $project['name'];
  }
}

// Mask the password with asterisks
$password_masked = str_repeat('*', strlen($_SESSION['Password']));

// Output the user details and projects in a table
echo "<table>";
echo "<tr><td>Name</td><td>" . $_SESSION['Name'] . "</td></tr>";
echo "<tr><td>Surname</td><td>" . $_SESSION['Surname'] . "</td></tr>";
echo "<tr><td>Email</td><td>" . $_SESSION['Email'] . "</td></tr>";
echo "<tr><td>Password</td><td><span id='password_masked'>$password_masked</span><br><a href='#' onclick='document.getElementById(\"password_masked\").innerHTML = \"" . $_SESSION['Password'] . "\"'>Reveal Password</a></td></tr>";
echo "<tr><td>Active</td><td>" . ($_SESSION['Active'] ? "True" : "False") . "</td></tr>";
echo "<tr><td colspan=2><hr></td></tr>";
echo "<tr><td>Phone</td><td>" . $_SESSION['Phone'] . "</td></tr>";
echo "<tr><td>Location</td><td>" . $_SESSION['Location'] . "</td></tr>";
echo "<tr><td>Manager</td><td>" . $_SESSION['Manager'] . "</td></tr>";
echo "<tr><td>Team</td><td>" . $_SESSION['Team'] . "</td></tr>";
echo "<tr><td>Projects</td><td>" . implode(', ', $user_projects) . "</td></tr>";
echo "</table>";
?>
<p><br></p>
<a href="curriculum.php"><button class="btn btn-outline-primary"> Curriculum </button></a>
<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/.index.php" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
