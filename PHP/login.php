<?php
// check if the button was clicked
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

require "dbConnection.php";

// check if the username exists and if the password is correct
$stmt = $pdo->prepare("SELECT * FROM users WHERE Username = ?");
$stmt->execute([$_POST["username"]]);
$user = $stmt->fetch();

// log in if the credentials are correct
if ($user && password_verify($_POST["password"], $user["Password"])) {
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["Username"];
    $_SESSION["loggedIn"] = true;
    header("Location: ../index.php");
    exit;
} 
// message for incorrect credentials
else { 
    $_SESSION["login_error"] = "Wrong username or password.";
    header("Location: ../index.php");
    exit;
}

?>