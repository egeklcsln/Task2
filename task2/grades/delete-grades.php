<?php
include('../config.php');
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $gradeID = intval($_GET["id"]);

    
    if ($gradeID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid grade ID value."));
        exit;
    }

    
    $sql = "DELETE FROM grades WHERE ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gradeID);

    
    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Grade has been deleted."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Failed to delete the grade: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}


$conn->close();
?>
