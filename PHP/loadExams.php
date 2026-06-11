<?php
// loads the exams for the applicant based on the chosen major
require "dbConnection.php";

header('Content-Type: application/json');

// get the exams where major_Id = entryexam.Major_ID (foreign key)
if (isset($_GET['major_id'])) {
    $majorId = (int)$_GET['major_id'];

    $stmt = $pdo->prepare("SELECT Exam_ID, ExamName FROM entryexam WHERE Major_ID = ?");
    $stmt->execute([$majorId]);
    $exams = $stmt->fetchAll();

    echo json_encode($exams);
    exit;
}
echo json_encode([]);