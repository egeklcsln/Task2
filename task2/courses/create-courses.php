<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["title"])) {
    
    $title = mysqli_real_escape_string($conn, $_GET["title"]);

    $sql = "INSERT INTO courses (Title) VALUES (?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $title);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "The course has been added successfully."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "An error occurred while adding the course: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}

$conn->close();
?>
