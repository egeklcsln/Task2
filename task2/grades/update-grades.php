<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    
    $gradeID = intval($_GET["id"]);

    if ($gradeID <= 0) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid grade ID value."));
        exit;
    }

    $courseID = isset($_GET["cid"]) ? intval($_GET["cid"]) : null;
    $studentID = isset($_GET["sid"]) ? intval($_GET["sid"]) : null;
    $year = isset($_GET["year"]) ? intval($_GET["year"]) : null;
    $semester = isset($_GET["semester"]) ? intval($_GET["semester"]) : null;
    $score = isset($_GET["score"]) ? floatval($_GET["score"]) : null;

    if ($courseID !== null && ($courseID <= 0 || !is_numeric($courseID))) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid CourseID value."));
        exit;
    }

    if ($studentID !== null && ($studentID <= 0 || !is_numeric($studentID))) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid StudentID value."));
        exit;
    }

    if ($year !== null && ($year <= 0 || !is_numeric($year))) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid Year value."));
        exit;
    }

    if ($semester !== null && ($semester <= 0 || !is_numeric($semester))) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid Semester value."));
        exit;
    }

    if ($score !== null && ($score < 0 || $score > 100 || !is_numeric($score))) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Invalid Score value."));
        exit;
    }

    $sql = "UPDATE grades SET ";
    $params = array();

    if ($courseID !== null) {
        $sql .= "CourseID = ?, ";
        $params[] = $courseID;
    }

    if ($studentID !== null) {
        $sql .= "StudentID = ?, ";
        $params[] = $studentID;
    }

    if ($year !== null) {
        $sql .= "Year = ?, ";
        $params[] = $year;
    }

    if ($semester !== null) {
        $sql .= "Semester = ?, ";
        $params[] = $semester;
    }

    if ($score !== null) {
        $sql .= "Score = ?, ";
        $params[] = $score;
    }

    if (empty($params)) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "No parameters were updated."));
        exit;
    }

    $sql = rtrim($sql, ", ") . " WHERE ID = ?";
    $params[] = $gradeID;

    $stmt = $conn->prepare($sql);
    $types = str_repeat("s", count($params));
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Grade information has been updated."));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array("message" => "Failed to update grade information: " . $stmt->error));
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(array("message" => "Invalid request type or missing parameters."));
}

$conn->close();
?>
