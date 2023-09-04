<?php
include('../config.php');

if (
    $_SERVER["REQUEST_METHOD"] === "GET" &&
    isset($_GET["cid"]) &&
    isset($_GET["sid"]) &&
    isset($_GET["year"]) &&
    isset($_GET["semester"]) &&
    isset($_GET["score"])
) {
    
    $courseID = intval($_GET["cid"]);
    $studentID = intval($_GET["sid"]);
    $year = intval($_GET["year"]);
    $semester = intval($_GET["semester"]);
    $score = floatval($_GET["score"]);

    
    if ($courseID <= 0 || $studentID <= 0 || $year <= 0 || $semester <= 0 || $score < 0 || $score > 100) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid parameter values."));
        exit;
    }

    
    $sql = "INSERT INTO grades (CourseID, StudentID, Year, Semester, Score) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiii", $courseID, $studentID, $year, $semester, $score);

    
    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Grade has been successfully added."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "An error occurred while adding the grade: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}


$conn->close();
?>
