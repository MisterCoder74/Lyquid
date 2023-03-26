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
$surname = $_SESSION['Surname'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data
  $taskText = $_POST['taskText'];
  $taskDate = $_POST['taskDate'];
  $taskTime = $_POST['taskTime'];
  
  
  // Create new task object
  $newTask = [
    'text' => $taskText,
    'date' => $taskDate,
    'time' => $taskTime,
    'originator' => $surname
  ];
  
  // Load existing tasks from JSON file
  $tasksJson = file_get_contents('pjtasks.json');
  $tasks = json_decode($tasksJson, true);
  
  // Add new task to array of tasks
  $tasks[] = $newTask;
  
  // Save updated tasks to JSON file
  file_put_contents('pjtasks.json', json_encode($tasks));
}

?>


<html>
<head>
<title>Lyquid - Project Area</title>
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
<a class="navbar-brand rounded middle" href="../../user/userboard.php" target="">Main User Board</a>
<a class="navbar-brand rounded middle" href="management.php" target="">Project Board</a>
<a class="navbar-brand rounded middle" href="pjkanban.php" target="">Project Kanban</a>
<a class="navbar-brand rounded middle" href="pjlogsystem.php" target="">Project Log</a>
<a class="navbar-brand rounded middle" href="pjsticky.php" target="">Project Sticky</a>
<a class="navbar-brand rounded middle active" href="pjtaskmanager.php" target="">Project Tasks</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Project Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="../../user/logout.php">Disconnect!</a></small></span>
<hr>
<?php 
$project_details = file_get_contents('projectdetails.json');
if (!$project_details) {
    // Handle error: unable to read project details file
    echo "<p>Error: unable to read project details file.</p>";
} else {
    $project = json_decode($project_details, true);
    if (is_array($project) && array_key_exists('name', $project)) {
        // Create the HTML table with project details
        echo "<h3>You are working on proj: " . $project['name'] . "</h3>";
    } else {
        // Handle error: invalid project details data structure
        echo "<p>Error: invalid project details data structure.</p>";
    }
}
?>
   <h1>Task Manager</h1>
    
<form method="POST">
  <label for="taskText">Task:</label>
  <textarea cols=60 rows=4 name="taskText" required></textarea><br>
  
  <label for="taskDate">Date:</label>
  <input type="date" name="taskDate" required>  
  
  <label for="taskTime">Time:</label>
  <input type="time" name="taskTime" required><br>
  
  <input class="btn btn-primary" type="submit" value="Add Task">
</form>

<h1>Task List</h1>
<button class="btn btn-primary" id="delete-button">Delete due tasks</button>

<script>
// Get a reference to the delete button
const deleteButton = document.getElementById('delete-button');

// Bind an event handler to the delete button's click event
deleteButton.addEventListener('click', () => {
  // Make an AJAX call to the PHP script that removes the past due tasks
  fetch('remove_past_due_tasks.php')
    .then(response => {
      if (response.ok) {
        console.log('Past due tasks removed primaryfully.');
      } else {
        console.error('Error removing past due tasks.');
      }
    })
    .catch(error => {
      console.error('AJAX error:', error);
    });
});
</script>

<?php

// Load tasks from JSON file
$tasksJson = file_get_contents('pjtasks.json');
$tasks = json_decode($tasksJson, true);

// Sort tasks by month, ascending
usort($tasks, function($a, $b) {
  $aMonth = date('m', strtotime($a['date']));
  $bMonth = date('m', strtotime($b['date']));
  return $aMonth - $bMonth;
});




// Display tasks in HTML table
echo '<table>';
echo '<tr><th>Task</th><th>Date</th><th>Time</th><th>Originator</th></tr>';
foreach ($tasks as $task) {
  $taskText = $task['text'];
  $taskDate = date('d/m/Y', strtotime($task['date']));
  $taskTime = $task['time'];
  $taskOriginator = $task['originator'];
  echo "<tr><td>$taskText</td><td>$taskDate</td><td>$taskTime</td><td>$taskOriginator</td></tr>";
}
echo '</table>';
?>

<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
