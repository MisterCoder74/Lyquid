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
        
        .progress-bar {
			width: 200px;
			height: 20px;
			background-color: white;
			border: 1px solid black;
			position: relative;
                        margin: 0 auto;
		}

		.progress-bar-fill {
			height: 100%;
			background-color: green;
			position: absolute;
			left: 0;
			top: 0;
                        margin: 0 auto;                        
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
<a class="navbar-brand rounded middle active" href="adminboard.php" target="">Admin Board</a>
<a class="navbar-brand rounded middle" href="proj_manager.php" target="">Projects</a>
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
<h1>Projects Progress Chart</h1>
<table>
		<thead>
			<tr>
				<th>Project Name</th>
				<th>Client</th>
				<th>Status</th>
				<th>Progress</th>
				<th>Progress %</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// Read the project list from projectlist.json
			$projects = json_decode(file_get_contents('../dbs/projectlist.json'), true);
			foreach ($projects as $index => $project) {
				// Create a row in the table for each project
				echo '<tr>';
				echo '<td>' . $project['name'] . '</td>';
				echo '<td>' . $project['client'] . '</td>';
				echo '<td>' . $project['status'] . '</td>';
				echo '<td align=center>';
				echo '<div class="progress-bar">';
				echo '<div class="progress-bar-fill" style="width: ' . $project['progress'] . '%"></div>';
				echo '</div>';
				echo '</td>';
				echo '<td>';
				echo '<input type="number" min="0" max="100" value="' . $project['progress'] . '" data-id="' . $index . '">';
				echo '</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>

	<script>
		// Add event listener to progress input elements
		const progressInputs = document.querySelectorAll('input[type="number"]');
		progressInputs.forEach(input => {
			input.addEventListener('keydown', event => {
				if (event.key === 'Enter') {
					// Get the project index and new progress value
					const index = input.dataset.id;
					const newProgress = parseInt(input.value, 10);

					// Update the progress value in the project list and the progress bar
					const progressBar = input.parentNode.previousElementSibling.querySelector('.progress-bar-fill');
					progressBar.style.width = `${newProgress}%`;

					// Update the progress value in the projectlist.json file
					const xhr = new XMLHttpRequest();
					xhr.open('POST', 'progress_update.php', true);
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhr.onreadystatechange = function() {
						if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
							console.log(this.responseText);
						}
					};
					xhr.send(`index=${index}&progress=${newProgress}`);
				}
			});
		});
	</script>

   
   
<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>

</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
