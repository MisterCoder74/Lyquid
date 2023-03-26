<?php

// Store the JSON file location
$file = './dbs/adminlist.json';

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Read the JSON file
    $json = file_get_contents($file);

    // Decode the JSON data into an array
    $data = json_decode($json, true);

    // Get the submitted username and password
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the username and password match any in the JSON data
    foreach ($data as $user) {

        // Check if the email and password match a user in the array
        if ($user['Email'] == $email && $user['Password'] == $password) {
            // Start the session
             session_start();
            
            // Store the user data in the session
            $_SESSION['user'] = $user;
                $_SESSION['Name'] = $user['Name'];
                $_SESSION['Surname'] = $user['Surname'];
                $_SESSION['Id'] = $user['Id'];
                $_SESSION['Email'] = $user['Email'];
                $_SESSION['Password'] = $user['Password'];                
                $_SESSION['Active'] = $user['Active'];                  
                $_SESSION['Role'] = $user['Role'];             
                $_SESSION['Phone'] = $user['Phone'];                
                $_SESSION['Location'] = $user['Location'];                


                // Redirect to the user page
                header('Location: admin/adminboard.php');
            
            exit;
        }
    }
    // If no match is found, show an error message
    echo 'Invalid username or password';
}
?>

<html>
<head>
    <title>Administrator Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
    
    a {
color: #14A44D;
}

        form {
            width: 30%;
            margin: 30px auto;
            text-align: center;
            padding: 20px;
            border: 1px solid black;
            border-radius: 10px;
            box-shadow: 0px 6px 8px black;
        }
        
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px 14px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 10px;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 10px 14px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid black;
            border-radius: 10px;
            color: white;
        }
    </style>
</head>
<body>
<center>
<p><br></p>
    <form action="" method="post"><h3>Admin Log In</h3>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Log In" class="btn btn-success">
    </form>
<p></p>
<img src="liquid_logo.png" width=300><p><small>&copy; 2023 - <a href="http://www.vivacitydesign.net/index.php" target="_blank">Vivacity Design Web Agency</a></small>
<p>
<a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Licenza Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/80x15.png" /></a><br />
Quest'opera è distribuita con Licenza<br>
<a rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribuzione 4.0 Internazionale</a>.
</p>
<p><a href="docs/Lyquid_Documentation.pdf" target="_blank">Reference Manual</a></p>
</center>    
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>