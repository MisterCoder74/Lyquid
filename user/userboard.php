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



            
      table {
max-width: 1000px;
}

.card {
width: 30rem;
height: 12rem;
}

.card-header {
font-size: 1.3rem;
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

@media only screen and (max-width:400px) { 

table {
max-width: 550px;
}

.card {
max-width: 22rem;
}

.card-header {
font-size: 1.1rem;
}

.card-text {
font-size: 1rem;
text-align: justify;
}

p {
text-align: justify;
}

.card-title {
font-size: 1.1rem;
}

.middle {
font-size: 1.3rem;
}

.padded {
padding: 0px 6px;
font-size: 1.4rem;
margin: 2px;
}

}
    </style>
    
</head>
<body>
<nav class="navbar navbar-light bg-light">

<div class="container-fluid">
<a class="navbar-brand rounded middle active" href="userboard.php" target="">User Board</a>
<a class="navbar-brand rounded middle" href="project_list.php" target="">Projects List</a>
<a class="navbar-brand rounded middle" href="log_system.php" target="">Log System</a>
<a class="navbar-brand rounded middle" href="jsonstickyboard.php" target="">Sticky Notes</a>
<a class="navbar-brand rounded middle" href="account.php" target="">Account</a>

</div>
</nav>

<p>
</p>
<center><h3 class="padded">User Panel - Welcome, (<?php echo $user['Name']; ?>) </h3>
<span><small><a href="logout.php">Disconnect!</a></small></span></h1>
<hr>

<!-- start tools table -->
<table class="padded" align=center cellpadding=5>
<tr>
<td align=center valign=middle>
<div class="card border-dark bg-transparent">
<h5 class="card-header text-primary">PROJECTS LIST</h5>
<div class="card-body">
<p class="card-text">
Review the project list and access existing projects.
</p><br>
<a href="project_list.php" target=""><button class="btn btn-outline-primary"> Go to Page </button></a>
</div>
</div>
<br>
</td>

<td align=center valign=middle>
<div class="card border-dark bg-transparent">
<h5 class="card-header text-primary">LOG SYSTEM</h5>
<div class="card-body">
<p class="card-text">
Global logging system for activities, project non-specific.
</p><br>
<a href="log_system.php"><button class="btn btn-outline-primary"> Go to Page </button></a>
</div>
</div>
<br>
</td>
</tr>
<tr>
<td align=center valign=middle>
<div class="card border-dark bg-transparent">
<h5 class="card-header text-primary">STICKY NOTES</h5>
<div class="card-body">
<p class="card-text">
Global sticky notes system for activities, project non-specific.<br>
</p><br>
<a href="jsonstickyboard.php"><button class="btn btn-outline-primary"> Go to Page </button></a>
</div>
</div>
<br>
</td>
<td align=center valign=middle>
<div class="card border-dark bg-transparent">
<h5 class="card-header text-primary">ACCOUNT</h5>
<div class="card-body">
<p class="card-text">
Review your user account information.<br>
</p><br>
<a href="account.php"><button class="btn btn-outline-primary"> Go to Page </button></a>
</div>
</div>
<br>
</td>
</tr>


</table>
<!-- end tools table -->
<p><br><br></p>
<img src="liquid_logo.png" width="200"><br>
&copy; 2023 - <a href="http://www.vivacitydesign.net/" target="_blank">Vivacity Design Web Agency</a>

</center>
<br>
<hr>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
