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
<?php

$file = 'pjnotes.json';

// Check if the form has been submitted
if (isset($_POST['save'])) {
    // Read the existing notes from the file
    $notes = json_decode(file_get_contents($file), true);
    $date = date('m/d/Y h:i:s a', time());

    // Add the new note to the notes array
    $notes[] = [
        'text' => $_POST['text'],
        'color' => $_POST['color'],
        'user' => $_SESSION['Surname'],
        'date' => $date,
    ];

    // Save the notes back to the file
    file_put_contents($file, json_encode($notes));
}

// Read the existing notes from the file
$notes = json_decode(file_get_contents($file), true);

// Check if a note has been deleted
if (isset($_GET['delete'])) {
    // Read the existing notes from the file
    $notes = json_decode(file_get_contents($file), true);

    // Find the note with the specified ID and remove it from the array
    foreach ($notes as $key => $note) {
        if ($note['id'] == $_GET['delete']) {
            unset($notes[$key]);
            break;
        }
    }

    // Save the notes back to the file
    file_put_contents($file, json_encode($notes));

    // Redirect back to the main page
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Read the existing notes from the file
$notes = json_decode(file_get_contents($file), true);

// Assign a unique ID to each note
foreach ($notes as $key => $note) {
    $notes[$key]['id'] = uniqid();
}

// Save the notes back to the file
file_put_contents($file, json_encode($notes));


?>

<html>
<head>
<title>Lyquid - Project Area</title>
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

#content {
text-align: justify;
font-size: 1.1rem;
color: #000;
}

#notescontainer {
padding: 4px;
margin-bottom: 8px;
border: 1px solid grey;
display: flex;
justify-content: space-between;
flex-wrap: wrap;
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
<a class="navbar-brand rounded middle active" href="pjsticky.php" target="">Project Sticky</a>
<a class="navbar-brand rounded middle" href="pjtaskmanager.php" target="">Project Tasks</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">User Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="../../user/logout.php">Disconnect!</a></small></span>
<hr>
<?php 
$project_details = file_get_contents('projectdetails.json');
$project = json_decode($project_details, true);

// Create the HTML table with project details
echo "<h3>You are working on proj: " . $project['name'] . "</h3>";
?>
   <h1>Sticky Note Board</h1>

    <?php if (!isset($_SESSION['user'])): ?>
        <p>Please log in to add and view notes.</p>
    <?php else: ?>
        <form action="" method="post">
            <textarea name="text" rows="6" cols="70"></textarea>
            <br>
            <label for="color">Importance:</label>
            <select name="color">
                <option value="#03c04a">Standard</option>
                <option value="#ffff00">Warning</option>
                <option value="#a22828">Critical</option>
            </select>
            <p></p>
            <p><input class="btn btn-primary" type="submit" name="save" value="Save"></p>
        </form>

<div id="notescontainer">
        <?php foreach ($notes as $note): ?>
            <div class="note" style="background-color: <?php echo $note['color']; ?>">
                
                <div id="content"><?php echo $note['text']; ?></div>
                <hr>
                <b><?php echo $note['user']; ?></b>
                <br>
                <?php echo $note['date']; ?>
                <hr>
                <button class="btn btn-primary" onclick="deleteNote('<?php echo $note['id']; ?>')">Delete</button>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<script>
    function deleteNote(id) {
        if (confirm("Are you sure you want to delete this note?")) {
            window.location.href = "?delete=" + id;
        }
    }
</script>


<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
