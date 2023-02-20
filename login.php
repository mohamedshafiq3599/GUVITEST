<?php
require 'vendor/autoload.php'; 
$client = new Predis\Client(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "guvi";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$email=$_POST['email'];
$password=$_POST['password']; 
$query = "select * FROM login WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s",$email);
$stmt->execute();
$memberResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if(!empty($memberResult))
{
    $hashedPassword = $memberResult[0]["password"];
    if (password_verify($password, $hashedPassword)) 
     {
      $client->set('email',$memberResult[0]['email']);
      $client->set('id',$memberResult[0]['id']);
        http_response_code(200);
        $response = array(
    "status"=>http_response_code(),
    "id"=>$client->get('id'),
    "email"=>$client->get('email'),
);
header('Content-Type:application/json');
echo json_encode($response);
exit();
    }
    else {

  echo "Incorrect username or password";
  http_response_code(401);
  $status_code = 401;
    }
}
else {
  echo "Incorrect username or password";
  http_response_code(401);
  $status_code = 401;
}


$conn->close();
?>