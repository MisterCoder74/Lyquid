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
<title>Lyquyid - Project Area</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>

 .note {
            padding: 10px;
            margin: 10px;
            width: 300px;
            background-color: #ddd;
            border: 1px solid #999;

        }
        
 .board {
 width: 100%;
 display: flex;
 justify-content: space-evenly;
 padding: 2px;
 box-shadow: 0px 4px 10px grey;
 flex-wrap: wrap;
 }

textarea {
  resize: none;
  box-shadow: 0px 4px 6px grey;
  margin: 8px;
}
            
      table {
max-width: 1000px;
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
    <link rel="stylesheet" href="kanban.css">
</head>
<body>
<nav class="navbar navbar-light bg-light">

<div class="container-fluid">
<a class="navbar-brand rounded middle" href="../../user/userboard.php" target="">Main User Board</a>
<a class="navbar-brand rounded middle" href="management.php" target="">Project Board</a>
<a class="navbar-brand rounded middle active" href="pjkanban.php" target="">Project Kanban</a>
<a class="navbar-brand rounded middle" href="pjlogsystem.php" target="">Project Log</a>
<a class="navbar-brand rounded middle" href="pjsticky.php" target="">Project Sticky</a>
<a class="navbar-brand rounded middle" href="pjtaskmanager.php" target="">Project Tasks</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">Project Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="/logout.php">Disconnect!</a></small></span>
<hr>
<?php 
$project_details = file_get_contents('projectdetails.json');
$project = json_decode($project_details, true);

// Create the HTML table with project details
echo "<h3>You are working on proj: " . $project['name'] . "</h3>";
?>
<h1>Project Kanban</h1>
<div class="container">
    <div class="commands">
<center>
        <textarea id="card-title">Type card text here...</textarea>
    <br>
    <button id="add-card-button">Add Card</button>
<label for="column-select"> to Column:</label>
<select id="column-select">
  <option value="todo">To-Do</option>
  <option value="doing">Doing</option>
  <option value="done">Done</option>
  <option value="repo">Repository</option>
</select>
</center>
    </div>
    
<div class="board">
    <div class="column" id="todo-column">
      <h2>To Do</h2>
    </div>

    <div class="column" id="doing-column">
      <h2>Doing</h2>
    </div>

    <div class="column" id="done-column">
      <h2>Done</h2>
    </div>
    
        <div class="column" id="repo-column">
      <h2>Repository</h2>
    </div>

   
</div>   

</div>

    <script src="kanban.js"></script>

<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
