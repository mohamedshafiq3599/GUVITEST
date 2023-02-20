<?php
require 'vendor/autoload.php';
$client = new Predis\Client(); 
$mongoclient=new MongoDB\Client;
$guvidb=$mongoclient->guvidb;
$profile=$guvidb->profile;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guvi";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$email = $_POST["email"];
$pass = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phoneno = $_POST["phoneno"];
$address = $_POST["address"];
$hash = password_hash($pass, PASSWORD_DEFAULT);
$client->set('email', $email);
$client->set('firstname', $firstname);
$client->set('lastname', $lastname);
$client->set('phoneno', $phoneno);
$client->set('address', $address);
$stmt = mysqli_prepare($conn, "SELECT id FROM login WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "Error: Email already exists";
    http_response_code(401);
} 
else {
    $insertable = $profile->insertOne([
        'email' => $email,
        'firstname' => $firstname,
        'lastname' => $lastname,
        'phoneno' => $phoneno,
        'address' => $address
    ]);
    $stmt = mysqli_prepare($conn, "INSERT INTO login (email, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $email, $hash);
    if (mysqli_stmt_execute($stmt)) {
        echo "New record created successfully";
        http_response_code(200);
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
        http_response_code(401);
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>