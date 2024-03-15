<?php
header('Content-Type: application/json');
// get request method
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    //$_GET['brand_id'];
     echo "THIS IS A GET REQUEST";
    // $data = getUser();
    // echo $data;
}
if ($method == 'POST') {
    // if (isset($_POST['brand_id'])) {
    //     $username = !$_POST['brand_id']? 'textronics' :$_POST['brand_id'];
    //     echo "Username: " . $username;
    // } else {
    //     // Handle case where 'username' field is missing from POST data
    //     echo "Error: 'brand_id' field is missing from POST data";
    // }
    $data = getUser();
   // $jsonObj = json_decode($data);
   // echo $jsonObj->brand_name;
   echo $data;
    
}
if ($method == 'PUT') {
	echo "THIS IS A PUT REQUEST";
}
if ($method == 'DELETE') {
	echo "THIS IS A DELETE REQUEST";
}
function getUser(){
    $data = file_get_contents('user_data.json');
    return $data;
}
