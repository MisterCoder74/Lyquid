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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'];

    if (!empty($text)) {
        $data = [
            'author' => $user['Surname'],
            'text' => $text,
            'datetime' => date('Y-m-d H:i:s')
        ];

        $jsonString = file_get_contents('pjlogging.json');
        $dataList = json_decode($jsonString, true);
        $dataList[] = $data;
        $jsonData = json_encode($dataList);
        file_put_contents('pjlogging.json', $jsonData);
    }
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
<a class="navbar-brand rounded middle active" href="pjlogsystem.php" target="">Project Log</a>
<a class="navbar-brand rounded middle" href="pjsticky.php" target="">Project Sticky</a>
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
   <h1>Logging Form</h1>
    <form method="POST">
        
        <label for="text">Enter text:</label>
        <br>
        <textarea name="text" cols="60" rows="3" style="resize: none;"></textarea>
        <br><br>
        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
    <hr>
    <h2>Log Entries</h2>
    <?php
    $jsonString = file_get_contents('pjlogging.json');
    $dataList = json_decode($jsonString, true);
    if ($dataList) {
        usort($dataList, function($a, $b) {
            return strtotime($b['datetime']) - strtotime($a['datetime']);
        });
        echo '<table>';
        echo '<thead><tr><th>Note</th><th>Author</th><th>Date/Time</th></tr></thead>';
        echo '<tbody>';
        foreach ($dataList as $data) {
            echo '<tr><td>' . $data['text'] . '</td><td>' . $data['author'] . '</td><td>' . $data['datetime'] . '</td></tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No log entries yet.</p>';
    }
    ?>

<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>
</center>
<br>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
