
<?php
// Include the required JWT library
require_once '../vendor/autoload.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
$collections = require_once __DIR__ . "/mongoDB_config.php";
$connection = require_once __DIR__ . "/db_config.php";
$token=$_POST['token'];


$secret_key = "Secret--key";


$sql = "SELECT * FROM reg WHERE userid=?";

$stmt = $connection->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $connection->error);
}
// Attempt to decode the JWT token
$decoded_payload = JWT::decode($token, new Key($secret_key, 'HS256'));

$id = $decoded_payload->uId;
//SQL
$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc(); // fetch data



$username = $_POST['username'];
$age =$_POST['age'];
$dob = $_POST['dob'];
$phonenumber =$_POST['phonenumber'];

// Create new MongoDB document
$document = [
    "username" => $username,
    "age" => $age,
    "dob" => $dob,
    "phonenumber" => $phonenumber
];



$result = $collections->insertOne($document);



if (!$secret_key) {
    echo json_encode(['status' => 500, 'message' => "Sry Internal Server Error"]);
    exit;
}

try {
    
    
    $document = ['uId' => $id, 'name' => $user["username"], 'email' => $user["email"]];
    

    $result = $collections->findOne(array("uId" => $id));

    if (!$result) {
        $insertResult = $collection->insertOne($document);

        // Check if the insert was successful
        if ($insertResult->getInsertedCount() > 0) {
            $data = ['status' => 200, 'uId' => $id, "users" => $document];
            echo json_encode($data);
            exit;
        } else {
            $data = ['status' => 500, 'message' => 'Error: ' . "Document not inserted"];
            echo json_encode($data);
            exit;
        }
    }

    $data = ['status' => 200, 'uId' => $id, "users" => $result];
    echo json_encode($data);
    exit;
} catch (Exception $e) {
    $data = ['status' => 500, 'message' => 'Error: ' . $e->getMessage()];
    echo json_encode($data);
}
?>