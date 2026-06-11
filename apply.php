<?php require "PHP/dbConnection.php"; 
    require "PHP/getMajors.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply For Entry Exam</title>
    <link rel="stylesheet" href="/Styles/main.css">
    <link rel="icon" type="image/x-icon" href="/Images/icon.png">
    <link rel="stylesheet" href="/Styles/apply.css">
</head>
<body>
    <?php require "PHP/header.php"; ?>

    <main>
        <form action="PHP/candidateApplied.php" method="POST"> 
        <table id="applyTable">
            <tr><th class="entryLabel">First Name:</th>
            <td><input type="text" name="firstName" class="entryInput" required></td></tr>

            <tr><th class="entryLabel">Last Name:</th>
            <td><input type="text" name="lastName" class="entryInput" required></td></tr>

            <tr><th class="entryLabel">Email:</th>
            <td><input type="email" name="email" class="entryInput" required></td></tr>

            <tr>
            <th class="entryLabel">Major:</th>
            <td>
                <select name="major_id" id="majorSelect" class="entryInput" required onchange="loadExams(this.value)">
                    <option value="">-- Choose a Major --</option>
                    
                    <?php foreach ($allMajors as $major): ?>
                    <option value="<?php echo $major['Major_ID']; ?>">
                    <?php echo htmlspecialchars($major['Major']); ?>
                    </option>
                    <?php endforeach; ?>

                </select>
            </td>
        </tr>
        
        <tr>
            <th class="entryLabel">Exam:</th>
            <td>
                <select name="exam_id" id="examSelect" class="entryInput" required disabled>
                    <option value="">-- First Choose a Major --</option>
                </select>
            </td>
        </tr>

            <tr><th class="entryLabel">Payment Method:</th0>
            <td><select name="paymentMethod" class="entryInput">
                <option value="Visa">Visa</option>
                <option value="Mastercard">MasterCard</option>
                <option value="Bank_Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
            </select></td></tr>
            <tr><th colspan="2"><input type="submit" value="Apply"></th></tr>
        </table>
    </main>

    <script src="Scripts/loadExams.js"></script>
    <?php require "PHP/footer.php"; ?>
</body>
</html>