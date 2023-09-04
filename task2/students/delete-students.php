<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $studentID = intval($_GET["id"]);

    
    if ($studentID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid student ID value."));
        exit;
    }

    
    $sql = "DELETE FROM students WHERE ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Student has been deleted."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Failed to delete the student: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}

$conn->close();
?>
