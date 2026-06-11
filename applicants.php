<?php require "PHP/dbConnection.php";
    require "PHP/getExams.php"; 
    require "PHP/getMajors.php";
    require "PHP/getApplicants.php"; 

    if (!isset($_SESSION["loggedIn"])) {
    header("Location: index.php");
    exit();
    }?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicants</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="stylesheet" href="/Styles/tables.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
</head>
<body>
    <?php require "PHP/header.php"; ?>
    <main>
        <h1 id="pageTitle">All Applicants</h1>

        <form action="updateApplicants.php" method="POST">

            <div id=adminButtons>
                <button type="submit" name="deleteBtn" class="deleteButton" disabled>DELETE</button>
                <button type="submit" name="editBtn" class="editButton" disabled>EDIT</button>
            </div>

            <table id="applicantsTable">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Major</th>
                    <th>Exam</th>
                    <th>Payment Method</th>
                    <th>Selected</th>
                </tr>

                <?php if (count($applicants) > 0):
                        foreach ($applicants as $applicant): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($applicant['FirstName']); ?></td>
                                <td><?php echo htmlspecialchars($applicant['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($applicant['Email']); ?></td>
                                <td><?php echo htmlspecialchars($applicant['MajorName']); ?></td>
                                <td><?php echo htmlspecialchars($applicant['ExamName']); ?></td>
                                <td><?php echo htmlspecialchars(str_replace('_', ' ', $applicant['PaymentMethod'])); ?></td>
                                <td><input type="checkbox" name="candidates_ids[]" 
                                value="<?php echo $applicant['Candidates_ID']; ?>"class="checkboxSquare"></td>
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
    <script src="Scripts/loadAdminButtons.js"></script>
</body>
</html>