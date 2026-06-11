<?php require "PHP/dbConnection.php";

if (!isset($_SESSION["loggedIn"])) {
    header("Location: index.php");
    exit();
}

try {
    $sql = "SELECT major.Major, COUNT(candidates.Candidates_ID) AS TotalApplicantsPerMajor
        FROM major
        LEFT JOIN candidates ON major.Major_ID = candidates.Major_ID
        GROUP BY major.Major_ID, major.Major
        ORDER BY TotalApplicantsPerMajor DESC";

    $stmt = $pdo->query($sql);
    $majorReport = $stmt->fetchAll();

    } catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error_message'] = "Err generating report";
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Major Report</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/reports.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "PHP/header.php"; ?>
    <main>
        <h1 id="pageTitle">Major Report</h1>

        <table class="reportTable" id="majorTable">
            <tr>
                <th>Major</th>
                <th>Total Applicants</th>
            </tr>

            <?php if (count($majorReport) > 0):
                foreach ($majorReport as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['Major']); ?></td>
                        <td><?php echo htmlspecialchars($report['TotalApplicantsPerMajor']); ?></td>
                    </tr>
            <?php endforeach;
            else: ?>
                <tr><td colspan="2">No data available.</td></tr>
            <?php endif ?>
        </table>
    </main>
    <?php require "PHP/footer.php"; ?>
</body>
</html>