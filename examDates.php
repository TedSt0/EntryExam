<?php require "PHP/dbConnection.php";
    require "PHP/getExams.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Dates</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/tables.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "PHP/header.php"; ?>
    <main>
        <h1 id="pageTitle">Exam Dates</h1>
        <p id="pageText">Here you can find the dates for the upcoming entry exams.<br>
        Please make sure to check back regularly for any updates or changes to the schedule.</p>

        <form action="updateExams.php" method="POST">

        <?php // edit option 
        if (isset($_SESSION["loggedIn"])):?>

        <div id=adminButtons>
            <button type="submit" name="deleteBtn" class="deleteButton" disabled>DELETE</button>
            <button type="submit" name="editBtn" class="editButton" disabled>EDIT</button>
        </div>

        <?php endif ?>

            <table id="examDatesTable">
                <tr>
                    <th>Exam</th>
                    <th>Major</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Room</th>
                    <?php //admin only column for selection
                    if (isset($_SESSION["loggedIn"])):?>
                    <th>Selected</th>
                    <?php endif ?>
                </tr>

                <?php if (count($exams) > 0):
                    foreach ($exams as $exam): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exam['ExamName']); ?></td>
                            <td><?php echo htmlspecialchars($exam['MajorName']); ?></td>
                            <td><?php echo htmlspecialchars($exam['ExamDateFormatted']); ?></td>
                            <td><?php echo htmlspecialchars($exam['ExamTimeFormatted']); ?></td>
                            <td><?php echo htmlspecialchars($exam['ExamRoom']); ?></td>
                            <?php if (isset($_SESSION["loggedIn"])):?>
                            <td><input type="checkbox" name="exam_ids[]" 
                            value="<?php echo $exam['Exam_ID']; ?>"class="checkboxSquare"></td>
                            <?php endif ?>
                        </tr>
                <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="<?php isset($_SESSION['loggedIn']) ? '6' : '5'; ?>"
                        style="text-align: center;">There are currently no Exams</td>
                    </tr>
                <?php endif; ?>
            </table>
        </form>
    </main>
    <?php require "PHP/footer.php"; ?>

    <script src="Scripts/loadAdminButtons.js"></script>
</body>
</html>