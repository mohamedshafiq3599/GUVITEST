<?php
require 'vendor/autoload.php';
$client = new Predis\Client();
$mongo=new MongoDB\Client;
$guvidb=$mongo->guvidb;
$profile=$guvidb->profile;
$email = $client->get('email');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
    $results = $profile->findOne(['email' => $email]);
    $json = json_encode($results); 
    header('Content-Type: application/json');
    echo $json;
} catch (Exception $e) {    
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(['message' => 'Unable to retrieve profile data', 'error' => $e->getMessage()]));
}
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $phoneno=$_POST['phoneno'];
    $address=$_POST['address'];
    $updateResult = $profile->updateOne(
        ['email' => $email],
        ['$set' => [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phoneno' => $phoneno,
            'address' => $address
        ]]
    );
     if($updateResult->getMatchedCount()>0)
     {
        $final = $profile->findOne(['email' => $email]);
        $json = json_encode($final); 
    header('Content-Type: application/json');
    echo $json;
        http_response_code(200);
     }
     else {
        echo "Error ";
        http_response_code(401);
    }
}
?>