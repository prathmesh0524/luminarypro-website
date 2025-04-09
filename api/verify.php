<?php
require_once "../includes/db.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = $conn->prepare("SELECT * FROM users WHERE token = ? AND is_verified = 0");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $update = $conn->prepare("UPDATE users SET is_verified = 1 WHERE token = ?");
        $update->bind_param("s", $token);
        $update->execute();

        echo "<h2>Email verified successfully!</h2>";
    } else {
        echo "<h2>Invalid or already verified token.</h2>";
    }
} else {
    echo "<h2>Access Denied</h2>";
}
?>
