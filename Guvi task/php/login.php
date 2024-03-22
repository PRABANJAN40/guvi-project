<?php
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $connection = require __DIR__ . "/db_config.php";
    
    $sql = "SELECT * FROM reg WHERE email=?";

    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $connection->error);
    }

    // print_r($_POST);exit;
    $uemail = urldecode($_POST["email"]);

    //SQL
    $stmt->bind_param("s", $uemail);
    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc(); 
    
    // echo $_POST["password"];
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"])) {
            $payload = array(
                'uId' => $user["userid"],
                'name' => $user["username"],
                'exp' => time() + (60 * 60 * 24 * 3) 
            );
            $secret_key = "Secret--key";

            // Generate the JWT token to sign the JWT
            $jwt= JWT::encode($payload, $secret_key, 'HS256');

            $data = ['status' => 200, 'token' => $jwt];

            // Sending JWT token
            echo json_encode($data);
            exit;
        }
        $data = ['status' => "300", 'message' => "Invalid Credentials"];
        echo json_encode($data);
        exit;
    }
    
    $data = ['status' => "400", 'msg ' => "Please Signin"];

    echo json_encode($data);
}