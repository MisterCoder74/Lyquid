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
<?php

$file = '../dbs/adminnotes.json';

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
<title>Lyquid - Admin Area</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
a {
color: #14A44D;
}

 .note {
            padding: 10px;
            margin: 10px;
            width: 300px;
            min-width: 280px;
            background-color: #ddd;
            border: 1px solid #999;
            
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


   <h1>Sticky Note Board</h1>

    <?php if (!isset($_SESSION['user'])): ?>
    <p>Please log in to add and view notes.</p>
<?php else: ?>
    <form action="" method="post">
        <textarea name="text" rows="8" cols="60"></textarea>
        <br>
        <label for="color">Priority:</label>
        <select name="color">
            <option value="#03c04a">Standard</option>
            <option value="#ffff00">Warning</option>
            <option value="#a22828">Critical</option>
 
        </select>
        <p></p>
        <p><input class="btn btn-success" type="submit" name="save" value="Save"></p>
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
                <button class="btn btn-success" onclick="deleteNote('<?php echo $note['id']; ?>')">Delete</button>
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
