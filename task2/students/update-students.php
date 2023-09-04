<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $studentID = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if ($studentID === false || $studentID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid student ID value."));
        exit;
    }

    $firstName = isset($_GET["fname"]) ? $_GET["fname"] : null;
    $lastName = isset($_GET["lname"]) ? $_GET["lname"] : null;
    $entranceDate = isset($_GET["ed"]) ? $_GET["ed"] : null;

    $sql = "UPDATE students SET ";
    $params = array();

    if (!empty($firstName)) {
        $sql .= "FirstName = ?, ";
        $params[] = $firstName;
    }

    if (!empty($lastName)) {
        $sql .= "LastName = ?, ";
        $params[] = $lastName;
    }

    if (!empty($entranceDate)) {
        $sql .= "EntranceDate = ?, ";
        $params[] = $entranceDate;
    }

    if (empty($params)) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "No parameters were updated."));
        exit;
    }

    $sql = rtrim($sql, ", ") . " WHERE ID = ?";
    $params[] = $studentID;

    $stmt = $conn->prepare($sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Student information has been updated."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Failed to update student information: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameter."));
}


$conn->close();
?>
