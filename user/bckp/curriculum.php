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

h2 {

                        background: #0275d8;
                        }

ul {
			list-style: none;
			padding-left: 0;
		}
		li {
			margin-bottom: 5px;
		}
		.project {
			margin-bottom: 20px;
		}
		.project h3 {
			margin-top: 0;
			margin-bottom: 5px;
		}
		.project p {
			margin-top: 0;
		}
.curriculum {
text-align: justify;
margin: 20px auto;
padding: 10px;
width: 40%;
box-shadow: 0px 4px 8px grey;
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

   <h1>Working Curriculum</h1>
   <div class="curriculum">
<?php
		// Recuperiamo i dati dell'utente loggato
		$current_user = json_decode(file_get_contents("../dbs/userlist.json"), true)[0];
		$current_user_id = $current_user['Id'];
		
		// Recuperiamo i dati dei progetti dell'utente loggato
		$project_list = json_decode(file_get_contents("../dbs/projectlist.json"), true);
		$user_projects = array();
		foreach ($project_list as $project) {
			if ($project['user'] == $current_user['Surname']) {
				$user_projects[] = $project;
			}
		}
                
                $company = json_decode(file_get_contents("../dbs/generals.json"), true);
		
		// Mostrare le informazioni dell'utente
		echo "<h2>User Information</h2>";
		echo "<ul>";
		echo "<li><strong>Name:</strong> " . $current_user['Name'] . "</li>";
		echo "<li><strong>Surname:</strong> " . $current_user['Surname'] . "</li>";
		echo "<li><strong>Email:</strong> " . $current_user['Email'] . "</li>";
		echo "<li><strong>Role:</strong> " . $current_user['Team'] . "</li>";
                echo "<li><strong>Company:</strong> " . $company['companyname'] . "</li>";
                echo "<li><strong>Sector:</strong> " . $company['marketsector'] . "</li>";                
		echo "</ul>";
		
		// Mostrare i progetti su cui ha lavorato
		echo "<h2>Projects</h2>";
		foreach ($user_projects as $project) {
			echo "<div class='project'>";
			echo "<h3>" . $project['name'] . "</h3>";
			echo "<ul>";
			echo "<li><strong>ID:</strong> " . $project['code'] . "</li>";
			echo "<li><strong>Client:</strong> " . $project['client'] . "</li>";
			echo "<li><strong>Start Date:</strong> " . $project['startdate'] . "</li>";
			echo "<li><strong>End Date:</strong> " . $project['duedate'] . "</li>";
			echo "</ul>";
			echo "<hr>";                        
			echo "</div>";
		}
	?>
        </div>

<p><br></p>
<a href="account.php"><button class="btn btn-outline-primary"> Back to Account </button></a>
<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/.index.php" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
