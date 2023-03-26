<?php

if (isset($_POST['submit'])) {
    // Generate a random 10 character user ID
    $user_ID = substr(str_shuffle('abcdefghijkmnopqrstuvwxyz1234567890ABCDEFGHIJKMNOPQRSTUVWXYZ'),0,10);
  
    // Collect user input data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $manager = $_POST['manager'];
    $phone = $_POST['phone'];    
    $location = $_POST['location'];    
    $team = $_POST['team'];    

    // Generate activation key
    $activation_key = md5(uniqid());

    // Create user data array
    $userData = [
        'Id' => $user_ID,
        'Name' => $name,
        'Surname' => $surname,
        'Email' => $email,
        'Password' => $password,
        'ActivationKey' => $activation_key, // Add activation key to user data
        'Active' => false, // Set user as inactive by default
        'Phone' => $phone,
        'Location' => $location,
        'Manager' => $manager,
        'Team' => $team        
    ];

    // Encode user data as JSON
    $jsonData = json_encode($userData);

    // Read existing user data from JSON file
    $existingUsers = json_decode(file_get_contents('./dbs/userlist.json'), true);

    // Check if email already exists in user data
    $emailExists = false;
    foreach ($existingUsers as $existingUser) {
        if ($existingUser['Email'] == $email) {
            $emailExists = true;
            break;
        }
    }

    // If email exists, redirect to error page and exit script
    if ($emailExists) {
        header('Location: ./user/goback_existing.php');
        exit;
    } else {
        // Add new user to existing user data
        $existingUsers[] = $userData;

        // Encode updated user data as JSON
        $jsonData = json_encode($existingUsers);

        // Write updated user data to JSON file
        file_put_contents('./dbs/userlist.json', $jsonData);

        // Send confirmation email to user
        $to = $email;
        $subject = 'Activate Your Account';
        $message = 'Dear ' . $name . ' ' . $surname . ',<br><br>';
        $message .= 'Thank you for registering with our website. To activate your account, please click the following link:<br><br>';
//customize with absolute path to the activate file
        $message .= '<a href="http://testsite.vivacitydesign.net/lyquid/activate.php?key=' . $activation_key . '">Activate Account</a><br><br>';
        $message .= 'Thank you,<br>Your Website Team';
//customize with sende email 
        $headers = 'From: info@vivacitydesign.net' . "\r\n" .
            'Reply-To: info@vivacitydesign.net' . "\r\n" .
            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Redirect to success page and exit script
        header('Location: ./user/goback_confirm.php');
        exit;
    }
}

?>

<html>
<head>
    <title>User Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        form {
            width: 30%;
            margin: 30px auto;
            text-align: center;
            padding: 20px;
            border: 1px solid black;
            border-radius: 10px;
            box-shadow: 0px 6px 8px black;
        }
        
        input[type="email"], input[type="password"], input[type="text"], select {
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

  <form action="" method="post"><h3>Sign Up</h3>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <input type="text" name="name" placeholder="Name"><br>
  <input type="text" name="surname" placeholder="Surname"><br>
  <input type="text" name="location" placeholder="Location"><br>
  <input type="text" name="phone" placeholder="Phone"><br>  
  <input type="text" name="manager" placeholder="Manager"><br>  
<!--   <input type="text" name="team" placeholder="Team"><br>   -->
        <select name="team" required>
        <option value="">Select a team...</option>
        <?php
        // read clients from file
        $teams = json_decode(file_get_contents('./dbs/teams.json'), true);

        // loop through clients and create option for each one
        foreach ($teams as $team) {
        echo "<option value=\"" . $team['name'] . "\">" . $team['name'] . "</option>";
        }
        ?>
        </select>
  <input type="submit" name="submit" value="Sign Up" class="btn btn-primary">
  </form>
  <br><small>Already have an account? <a href="login.php">Log in here!</a></small>
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
