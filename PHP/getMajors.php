<?php try {
    // get all the major id's from the db
    $majorSql = "SELECT Major_ID, Major FROM major ORDER BY Major ASC";
    $majorStmt = $pdo->query($majorSql);
    $allMajors = $majorStmt->fetchAll();
} catch (Exception $e) {
    error_log($e->getMessage());
    $_SESSION['error_message'] = "Err loading Majors";
    header("Location: error.php");
    exit();
} ?>