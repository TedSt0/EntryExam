<?php try {
    $sql = "SELECT candidates.Candidates_ID, candidates.FirstName, candidates.LastName, candidates.Email, 
    candidates.Major_ID, major.Major AS MajorName, 
    candidates.Exam_ID, entryexam.ExamName AS ExamName, 
    candidates.PaymentMethod
    FROM candidates
    INNER JOIN major ON candidates.Major_ID = major.Major_ID
    INNER JOIN entryexam ON candidates.Exam_ID = entryexam.Exam_ID
    ORDER BY Candidates_ID ASC";

    $stmt = $pdo->query($sql);
    $applicants = $stmt->fetchAll();
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error_message'] = "Err loading applicants";
    header("Location: error.php");
    exit();
}
?>