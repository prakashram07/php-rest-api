<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../class/Student.php';

$database = new Database();
$db = $database->getConnection();
 
$students = new Students($db);

$students->id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';

$result = $students->read();

if($result->num_rows > 0){    
    $student_records=array();
    $student_records["students"]=array(); 
	while ($student = $result->fetch_assoc()) { 	
        extract($student); 
        $student_details=array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
			"contact" => $contact,
            "address" => $address,            
        ); 
       array_push($student_records["students"], $student_details);
    }    
    http_response_code(200);     
    echo json_encode($student_records);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No data found.")
    );
} 