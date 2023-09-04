<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
    $students = array();

    
    $sql = "SELECT * FROM students";

    
    $result = $conn->query($sql);

    if ($result) {
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $students[] = $row;
            }
            
            header('Content-Type: application/json');
            
            echo json_encode($students);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "No students found."));
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Database query failed: " . $conn->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type."));
}


$conn->close();
?>
