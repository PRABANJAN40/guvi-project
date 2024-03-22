<?php
$collections = require_once __DIR__ . "/mongoDB_config.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
try {
$POST_VAL = [];
if (isset($_POST['username'])) {
    $POST_VAL['username'] = $_POST['username'];
}
if (isset($_POST['age'])) {
    $POST_VAL['age'] = $_POST['age'];
}
if (isset($_POST['dob'])) {
    $POST_VAL['dob'] = $_POST['dob'];
}
if (isset($_POST['phonenumber'])) {
    $POST_VAL['phonenumber'] = $_POST['phonenumber'];
}

if(count($POST_VAL) < 0){
    $data = ['status' => 500, 'message' => 'Error: No Values'];
    echo json_encode($data);
    exit;
}
$id = $_POST['uId'];
$POST_VAL['uId'] = $id;

$document = array('$set' => $POST_VAL);

$userUpdate = $collection->updateOne(array("uId" => $id), $document);
$result = $collections->findOne(array("uId" => $id));

if ($userUpdate->getModifiedCount() > 0) {
    $result = $collections->findOne(array("uId" => $id));

    $data = ['status' => 200, 'uId' => $id,  "users" => $result];
    echo json_encode($data);
    exit;
} else {
    $data = ['status' => 500, 'message' => 'Error: Not Mod'];
    echo json_encode($data);
}

} catch (Exception $e) {
$data = ['status' => 500, 'message' => 'Error: ' . $e->getMessage()];
echo json_encode($data);
}
?>


