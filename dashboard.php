<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - IP Center</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
  <div class="form-container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!</h2>
    <p>This is your secure dashboard.</p>
    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
