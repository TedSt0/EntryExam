<?php 
require "dbConnection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $majorId = $_POST['major_id'];
    $examId = $_POST['exam_id'];
    $paymentMethod = $_POST['paymentMethod'];

    $selectedExams = isset($_POST['exams']) ? $_POST['exams'] : [];

    try {
        $sqlCandidate = "INSERT INTO candidates (FirstName, LastName, Email, Major_ID, Exam_ID, PaymentMethod) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sqlCandidate);
        $stmt->execute([$firstName, $lastName, $email, $majorId, $examId, $paymentMethod]);

        header("Refresh: 5; url=../index.php");

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err applying";
        header("Location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "header.php"; ?>
    <main>
        <h1 style="text-align: center; font-weight: bold; color: ivory">Application Submitted Successfully</h1>
        <p style="text-align: center; font-weight: bold; color: ivory">
            Thank you for applying. Your application has been saved.</p><br>

        <p style="text-align: center; font-weight: bold; color: ivory">
            Redirecting to the homepage in 5 seconds...</p>
    </main>
    <?php require "footer.php"; ?>
</body>
</html>