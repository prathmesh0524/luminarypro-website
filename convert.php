<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Start Filing - IP Assistant</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h2>Welcome to Patent Filing Assistant</h2>
        <p>This feature will help you file your IP easily.</p>
        <p>Coming soon...</p>
        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>
</html>
