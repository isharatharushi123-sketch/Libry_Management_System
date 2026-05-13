<?php
$servername="localhost";
$username="root";
$password="";
$database="library_management_system";

try{
    $conn =new mysqli($servername,$username,$password,$database);
    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }
    else{
        //echo json_encode(['dbstatus' => 'success', 'message' => 'Connected successfully']);
    }

}
catch(Exeption $e){
    //echo json_encode(['dbstatus' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
}
?>