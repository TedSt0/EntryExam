<?php require "PHP/dbConnection.php";
require "PHP/getApplicants.php";
require "PHP/getMajors.php";

// check if logged in

if (!isset($_SESSION["loggedIn"])) {
    header("Location: index.php");
    exit();
}

// arrays of applicants to edit.
$applicantsToEdit = [];

// delete button clicked
if (isset($_POST['deleteBtn']) && !empty($_POST['candidates_ids'])) {
    // array of ids
    // placeholders
    $ids = $_POST['candidates_ids'];
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';

    try {
        $sql = "DELETE FROM candidates WHERE Candidates_ID IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        
        header("Location: applicants.php?msg=deleted");
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

        $sql = "UPDATE candidates 
                SET FirstName = ?, LastName = ?, Email = ?, 
                Major_ID = ?, Exam_ID = ?, PaymentMethod = ? 
                WHERE Candidates_ID = ?";
        $stmt = $pdo->prepare($sql);

        foreach ($_POST['applicants'] as $candidate_id => $data) {
            $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $data['major_id'],
                $data['exam_id'],
                $data['paymentMethod'],
                $candidate_id
            ]);
        }

        $pdo->commit();
        header("Location: applicants.php?msg=updated");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err saving";
        header("Location: error.php");
        exit();
    }
}
elseif (isset($_POST['editBtn']) && !empty($_POST['candidates_ids'])) {
    $ids = $_POST['candidates_ids'];
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    
    try {
        $sql = "SELECT Candidates_ID, FirstName, LastName, Email, Major_ID, Exam_ID, PaymentMethod 
        FROM candidates WHERE Candidates_ID IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
        $applicantsToEdit = $stmt->fetchAll();
    } catch (Exception $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Err getting the edit values";
        header("Location: error.php");
        exit();
    }
} 
else {
    header("Location: applicants.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Applicants</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/tables.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "PHP/header.php"; ?>
    
    <main>
        <form action="updateApplicants.php" method="POST">

            <div id="adminButtons">
                <button type="submit" name="saveChangesBtn" class="editButton">SAVE CHANGES</button>
                <button type="button" class="deleteButton" onclick="window.location.href='applicants.php'">Cancel</button>
            </div>

            <table id="applicantsTable">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Major</th>
                    <th>Exam</th>
                    <th>Payment Method</th>
                </tr>
                    <?php if (count($applicantsToEdit) > 0):
                        foreach ($applicantsToEdit as $applicant): ?>
                            <tr>
                                <td><input type="text" name="applicants[<?php echo $applicant['Candidates_ID']; ?>][firstName]" 
                                        value="<?php echo htmlspecialchars($applicant['FirstName']); ?>" class="editData" required>
                                </td>

                                <td><input type="text" name="applicants[<?php echo $applicant['Candidates_ID']; ?>][lastName]" 
                                        value="<?php echo htmlspecialchars($applicant['LastName']); ?>" class="editData" required>
                                </td>

                                <td><input type="email" name="applicants[<?php echo $applicant['Candidates_ID']; ?>][email]" 
                                        value="<?php echo htmlspecialchars($applicant['Email']); ?>" class="editData" required>
                                </td>

                                <td><select name="applicants[<?php echo $applicant['Candidates_ID']; ?>][major_id]" 
                                            class="editData" required
                                            onchange="updateApplicantExams(this)">
                                                <?php foreach ($allMajors as $major): ?>
                                                    <option value="<?php echo $major['Major_ID']; ?>" <?php if ($major['Major_ID'] == $applicant['Major_ID']) echo 'selected'; ?>>
                                                        <?php echo htmlspecialchars($major['Major']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                </td>
                                
                                <td><select name="applicants[<?php echo $applicant['Candidates_ID']; ?>][exam_id]" 
                                    class="resetExam editData" required>
                                        <?php 
                                            // Load exams only for the current applicant
                                            $stmtExams = $pdo->prepare("SELECT Exam_ID, ExamName FROM entryexam WHERE Major_ID = ?");
                                            $stmtExams->execute([$applicant['Major_ID']]);
                                            $rowExams = $stmtExams->fetchAll();
                                            
                                            foreach ($rowExams as $exam): ?>
                                                <option value="<?php echo $exam['Exam_ID']; ?>" 
                                                    <?php if ($exam['Exam_ID'] == $applicant['Exam_ID']) echo 'selected'; ?>>
                                                    <?php echo htmlspecialchars($exam['ExamName']); ?>
                                                </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>

                                <td>
                                    <select name="applicants[<?php echo $applicant['Candidates_ID']; ?>][paymentMethod]" class="editData" required>
                                        <option value="Visa" <?php if ($applicant['PaymentMethod'] == 'Visa') echo 'selected'; ?>>Visa</option>
                                        <option value="Mastercard" <?php if ($applicant['PaymentMethod'] == 'Mastercard') echo 'selected'; ?>>MasterCard</option>
                                        <option value="Bank_Transfer" <?php if ($applicant['PaymentMethod'] == 'Bank_Transfer') echo 'selected'; ?>>Bank Transfer</option>
                                        <option value="Cash" <?php if ($applicant['PaymentMethod'] == 'Cash') echo 'selected'; ?>>Cash</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach;

                    else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">There are currently no Applicants</td>
                        </tr>
                    <?php endif; ?>
            </table>
        </form>
    </main>

    <?php require "PHP/footer.php"; ?>
    <script src="Scripts/updateApplicantExams.js"></script>
</body>
</html>