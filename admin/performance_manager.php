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
        
        input[type="text"], select {
            width: 100%;
            padding: 6px 10px;
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
<a class="navbar-brand rounded middle" href="clients_manager.php" target="">Clients</a>
<a class="navbar-brand rounded middle active" href="performance_manager.php" target="">Performances</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Admin Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="adminlogout.php"><b>Disconnect!</b></a></small></span>
<hr>
<h1>Users Performance manager</h1>

<?php
// Load the userlist and projectlist files
$userlist = json_decode(file_get_contents('../dbs/userlist.json'), true);
$projectlist = json_decode(file_get_contents('../dbs/projectlist.json'), true);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $performances = $_POST['performances'];

  // Create a new array to hold the user performance data
  $user_performance = array();

  // Loop through each user
  foreach ($userlist as $user) {
    // Create a new array to hold the performance data for this user
    $user_performance_data = array(
      'Id' => $user['Id'],
      'Name' => $user['Name'],
      'Surname' => $user['Surname'],
      'Team' => $user['Team'],
      'performances' => array() // array to hold performance data for each project
    );

    // Loop through each project and check if the user is involved
    foreach ($projectlist as $project) {
      if ($user['Surname'] == $project['user']) {
        // If the user is involved in the project, add a new item to the performances array with the project name and performance value
        $performances_key = $user['Surname'] . '_' . $project['name'];
        if (isset($performances[$performances_key])) {
          $user_performance_data['performances'][] = array(
            'project_name' => $project['name'],
            'performance_value' => $performances[$performances_key]
          );
        } else {
          $user_performance_data['performances'][] = array(
            'project_name' => $project['name'],
            'performance_value' => ''
          );
        }
      }
    }

    // Add the user performance data to the user_performance array
    $user_performance[] = $user_performance_data;
  }

  // Save the user performance data to the user_performance.json file
  file_put_contents('../dbs/user_performance.json', json_encode($user_performance));
}

// Display the HTML form
?>

<form method="POST">
  <table >
    <thead>
      <tr>
    
        <th>Name</th>
        <th>Surname</th>
        <th>Team</th>
        <?php foreach ($projectlist as $project) : ?>
          <th><?php echo $project['name']; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($userlist as $user) : ?>
  <tr>

    <td><?php echo $user['Name']; ?></td>
    <td><?php echo $user['Surname']; ?></td>
    <td><?php echo $user['Team']; ?></td>
    <?php foreach ($projectlist as $project) : ?>
      <?php if ($user['Surname'] == $project['user']) : ?>
        <td>
          <select name="performances[<?php echo $user['Surname'] . '_' . $project['name']; ?>]">
            <option value="">Evaluate</option>
            <option value="below_expectation" <?php if (isset($user_performance[$user['Surname']][$project['name']]) && $user_performance[$user['Surname']][$project['name']] == 'below_expectation') echo 'selected'; ?>>Below expectation</option>
            <option value="met_expectation" <?php if (isset($user_performance[$user['Surname']][$project['name']]) && $user_performance[$user['Surname']][$project['name']] == 'met_expectation') echo 'selected'; ?>>Met expectation</option>
            <option value="beyond_expectation" <?php if (isset($user_performance[$user['Surname']][$project['name']]) && $user_performance[$user['Surname']][$project['name']] == 'beyond_expectation') echo 'selected'; ?>>Beyond expectation</option>
          </select>
        </td>
      <?php else: ?>
        <td></td>
      <?php endif; ?>
    <?php endforeach; ?>
  </tr>
<?php endforeach; ?>

</tbody>
</table>
  <input class="btn btn-success" type="submit" value="Save Evaluation">
</form>

<h1>Users Performances</h1>
<table>
		<thead>
			<tr>
				<th>Name</th>
				<th>Surname</th>
				<th>Team</th>
				<th>Project Name</th>
				<th>Performance Value</th>
			</tr>
		</thead>
		<tbody>
			<?php
				// Read JSON file
				$data = file_get_contents('../dbs/user_performance.json');

				// Decode JSON file into an array of objects
				$users = json_decode($data);

				// Loop through each user and their performance data
				foreach ($users as $user) {
					foreach ($user->performances as $performance) {
						echo '<tr>';
						echo '<td>' . $user->Name . '</td>';
						echo '<td>' . $user->Surname . '</td>';
						echo '<td>' . $user->Team . '</td>';
						echo '<td>' . $performance->project_name . '</td>';
						echo '<td>' . $performance->performance_value . '</td>';
						echo '</tr>';
					}
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
