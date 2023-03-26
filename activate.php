<?php

// Read existing user data from JSON file
$existingUsers = json_decode(file_get_contents('./dbs/userlist.json'), true);

// Check if activation key is set and valid
if (isset($_GET['key'])) {
    $activation_key = $_GET['key'];
    foreach ($existingUsers as &$user) {
        if ($user['ActivationKey'] == $activation_key) {
            $user['Active'] = true; // Activate user's account
            break;
        }
    }

    // Update user data in JSON file
    $jsonData = json_encode($existingUsers);
    file_put_contents('./dbs/userlist.json', $jsonData);

    // Redirect to success page
    header('Location: ./user/goback_success.php');
    exit;
} else {
    // Redirect to error page if activation key is not set
    header('Location: ./user/goback_acterror.php');
    exit;
}

?>
