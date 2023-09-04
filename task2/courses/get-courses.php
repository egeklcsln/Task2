<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
    $sql = "SELECT * FROM courses";
    
    
    $stmt = $conn->prepare($sql);
    
    
    if ($stmt->execute()) {
        $courses = array();
        
        
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
        
        header('Content-Type: application/json');
        echo json_encode($courses);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Database query failed: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type."));
}


$conn->close();
?>
