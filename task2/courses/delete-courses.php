<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $courseID = intval($_GET["id"]);

    if ($courseID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid course ID value."));
        exit;
    }

    
    $sql = "DELETE FROM courses WHERE ID = ?";
    
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $courseID);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Course deleted successfully."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "An error occurred while deleting the course: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameter."));
}


$conn->close();
?>
