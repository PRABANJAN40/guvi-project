<?php


if (empty($_POST["username"])) {
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}



$ps = password_hash($_POST["password"], PASSWORD_DEFAULT);  
$connection = require __DIR__ . "/db_config.php";

$sql = "INSERT INTO reg (username, userid, email, password)
        VALUES (?, ?, ?, ?)";
        
$stmt = $connection->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $connection->error);
}

$stmt->bind_param("ssss",
                  $_POST["username"],
                  $_POST["userid"],
                  $_POST["email"],
                  $ps);
                 
                  if ($stmt->execute()) {
                    exit('1');

                } else {
                    if ($connection->errno === 1062) {
                        exit('2');  
                    } else {
                        exit('3');
                    }
                }