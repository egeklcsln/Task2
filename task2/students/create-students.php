<?php
include('../config.php');

if (
    $_SERVER["REQUEST_METHOD"] === "GET" &&
    isset($_GET["fname"]) &&
    isset($_GET["lname"]) &&
    isset($_GET["ed"])
) {
    
    $firstName = mysqli_real_escape_string($conn, $_GET["fname"]);
    $lastName = mysqli_real_escape_string($conn, $_GET["lname"]);
    $entranceDate = mysqli_real_escape_string($conn, $_GET["ed"]);

    
    if (empty($firstName) || empty($lastName) || empty($entranceDate)) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Missing or empty parameters."));
        exit;
    }

    
    $sql = "INSERT INTO students (FirstName, LastName, EntranceDate) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstName, $lastName, $entranceDate);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Student has been successfully added."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "An error occurred while adding the student: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}

$conn->close();
?>
