<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $grades = array();

    $sql = "SELECT * FROM grades";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $grades[] = $row;
            }
            header('Content-Type: application/json');
            echo json_encode($grades);
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "No grades found."));
        }
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
