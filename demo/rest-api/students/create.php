<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../class/Student.php';

$database = new Database();
$db = $database->getConnection();

$students = new Students($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) && !empty($data->email) &&
    !empty($data->contact) && !empty($data->address)
) {

    $students->name = $data->name;
    $students->email = $data->email;
    $students->contact = $data->contact;
    $students->address = $data->address;

    if ($students->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Student data created successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create student data."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create student data. Data is incomplete."));
}
