<?php try {
    $sql = "SELECT entryexam.Exam_ID, entryexam.ExamName, major.Major AS MajorName, 
    DATE_FORMAT(entryexam.ExamDate, '%d/%m/%Y') AS ExamDateFormatted, 
    TIME_FORMAT(entryexam.ExamTime, '%H:%i') AS ExamTimeFormatted, 
    entryexam.ExamRoom 
    FROM entryexam
    INNER JOIN major ON entryexam.Major_ID = major.Major_ID
    ORDER BY entryexam.ExamDate ASC, entryexam.ExamTime ASC";
            
    $stmt = $pdo->query($sql);
    $exams = $stmt->fetchAll();
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error_message'] = "Err loading exams";
    header("Location: error.php");
    exit();
}
?>