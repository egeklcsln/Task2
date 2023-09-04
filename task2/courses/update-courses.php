<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $courseID = intval($_GET["id"]);

    if ($courseID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid course ID value."));
        exit;
    }

    
    $title = isset($_GET["title"]) ? mysqli_real_escape_string($conn, $_GET["title"]) : null;
    
    
    $sql = "UPDATE courses SET ";
    $params = array();

    if (!empty($title)) {
        $sql .= "title = ?, ";
        $params[] = $title;
    }

    if (empty($params)) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "No parameters were updated."));
        exit;
    }

    $sql = rtrim($sql, ", ") . " WHERE ID = ?";
    $params[] = $courseID;

    
    $stmt = $conn->prepare($sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);

    
    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Course information has been successfully updated."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Failed to update course information: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameter."));
}


$conn->close();
?>
