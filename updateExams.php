<?php require "PHP/dbConnection.php";

// check if logged in

if (!isset($_SESSION["loggedIn"])) {
    header("Location: examDates.php");
    exit();
}

// arrays of exams to edit.
$examsToEdit = [];

// delete button clicked
if (isset($_POST['deleteBtn']) && !empty($_POST['exam_ids'])) {
    
    // array of ids
    // placeholders
    $ids = $_POST['exam_ids'];
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';

    try {
        $sql = "DELETE FROM entryexam WHERE Exam_ID IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        
        header("Location: examDates.php?msg=deleted");
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err deleting";
        header("Location: error.php");
        exit();
    }
}
// save values for edit
elseif (isset($_POST['saveChangesBtn'])) {
    try {
        $pdo->beginTransaction();

        $sql = "UPDATE entryexam 
                SET ExamName = ?, ExamRoom = ?, ExamDate = ?, ExamTime = ? 
                WHERE Exam_ID = ?";
        $stmt = $pdo->prepare($sql);

        foreach ($_POST['exams'] as $exam_id => $data) {
            $stmt->execute([
                $data['name'],
                $data['room'],
                $data['date'],
                $data['time'],
                $exam_id
            ]);
        }

        $pdo->commit();
        header("Location: examDates.php?msg=updated");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err saving";
        header("Location: error.php");
        exit();
    }
}
// get values to display when edit is clicked
elseif (isset($_POST['editBtn']) && !empty($_POST['exam_ids'])) {
    $ids = $_POST['exam_ids'];
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    try {
        $sql = "SELECT Exam_ID, ExamName, ExamDate, ExamTime, ExamRoom FROM entryexam WHERE Exam_ID IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        $examsToEdit = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err getting the edit values";
        header("Location: error.php");
        exit();
    }
} 
else {
    header("Location: examDates.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exams</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/tables.css">

</head>
<body>
    <?php require "PHP/header.php"; ?>
    <main>
        <h1 id="pageTitle">Edit Mode</h1>

        <form action="updateExams.php" method="POST">
            
            <div id="adminButtons">
                <button type="submit" name="saveChangesBtn" class="editButton">SAVE CHANGES</button>
                <button type="button" class="deleteButton" onclick="window.location.href='examDates.php'">Cancel</button>
            </div>

            <table id="examDatesTable">
                <tr>
                    <th>Exam Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Room</th>
                </tr>

                <?php foreach ($examsToEdit as $exam): ?>
                    <tr>
                        <td>
                            <input type="text" name="exams[<?php echo $exam['Exam_ID']; ?>][name]" 
                                   value="<?php echo htmlspecialchars($exam['ExamName']); ?>" class="editData" required>
                        </td>
                        <td>
                            <input type="date" name="exams[<?php echo $exam['Exam_ID']; ?>][date]" 
                                   value="<?php echo $exam['ExamDate']; ?>" class="editData" required>
                        </td>
                        <td>
                            <input type="time" name="exams[<?php echo $exam['Exam_ID']; ?>][time]" 
                                   value="<?php echo date('H:i', strtotime($exam['ExamTime'])); ?>" class="editData" required>
                        </td>
                        <td>
                            <input type="text" name="exams[<?php echo $exam['Exam_ID']; ?>][room]" 
                                   value="<?php echo htmlspecialchars($exam['ExamRoom']); ?>" class="editData" required>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </main>
</body>
</html>

