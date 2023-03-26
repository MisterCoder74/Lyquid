<?php
// get client data from form
$id = substr(str_shuffle('abcdefghijkmnopqrstuvwxyz1234567890ABCDEFGHIJKMNOPQRSTUVWXYZ'),0,10);
$name = $_POST['name'];
$address = $_POST['address'];
$reference_person = $_POST['reference_person'];
$reference_phone = $_POST['reference_phone'];
$reference_email = $_POST['reference_email'];

// create client array
$client = array(
        "id" => $id,
	"name" => $name,
	"address" => $address,
	"reference_person" => $reference_person,
	"reference_phone" => $reference_phone,
	"reference_email" => $reference_email,
	"granted_projects" => array()
);

// get existing clients from file
$clients = json_decode(file_get_contents('../dbs/clients.json'), true);

// add new client to array
$clients[] = $client;

// save clients to file
file_put_contents('../dbs/clients.json', json_encode($clients));

// redirect to form file
header('Location: clients_manager.php');
?>
