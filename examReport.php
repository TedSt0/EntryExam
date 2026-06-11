<?php require "PHP/dbConnection.php";
require "PHP/getExams.php";
require "PHP/getApplicants.php";

if (!isset($_SESSION["loggedIn"])) {
    header("Location: index.php");
    exit();
}

$examReport = [];

if (isset($_POST['genReportBtn']) && !empty($_POST['exam_id'])) {
    try {
        $sql = "SELECT CONCAT_WS(' ', candidates.FirstName, candidates.LastName) AS FullName, candidates.email AS ApplicantEmail
            FROM entryexam
            LEFT JOIN candidates ON entryexam.Exam_ID = candidates.Exam_ID
            WHERE entryexam.Exam_ID = ?
            GROUP BY candidates.Candidates_ID, Candidates.FirstName, candidates.LastName, candidates.email
            ORDER BY FullName DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['exam_id']]);
        $examReport = $stmt->fetchAll();

        } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err generating report";
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
    <title>Exam Report</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/reports.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "PHP/header.php"; ?>
    <main>
        <h1 id="pageTitle">Exam Report</h1>
        <div class="reportForm">
            <form action="examReport.php" method="POST">

                <select class="reportSelect" name="exam_id" required>
                    <?php foreach ($exams as $exam): ?>
                        <option value="<?php echo $exam['Exam_ID']; ?>"
                        <?php echo (isset($_POST['exam_id']) && $_POST['exam_id'] == $exam['Exam_ID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($exam['ExamName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" name="genReportBtn" class="reportSubmit" value="Generate Report">
            </form>
        </div>

            <?php if (count($examReport) > 0): ?>
                <table class="reportTable">
                    <tr>
                        <th>Applicant Name</th>
                        <th>Applicant Email</th>
                    </tr>
                    <?php foreach ($examReport as $report): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($report['FullName']); ?></td>
                            <td><?php echo htmlspecialchars($report['ApplicantEmail']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <h2 id="pageText">Please select an exam and generate the report.</h2>
            <?php endif; ?>
    </main>
    <?php require "PHP/footer.php"; ?>
</body>
</html>