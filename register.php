<?php
session_start();
require_once "includes/db.php";
require_once "includes/mailer.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $token    = bin2hex(random_bytes(32));

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, token, is_verified) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("ssss", $name, $email, $password, $token);
        if ($stmt->execute()) {
            sendVerificationEmail($email, $token, $name); // from mailer.php
            $_SESSION['message'] = "Registration successful. Check your email for verification.";
        } else {
            $_SESSION['message'] = "Something went wrong. Please try again.";
        }
    }

    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - IP Facilitation Center</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    .form-container {
      max-width: 450px;
      margin: 80px auto;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(15px);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0,255,224,0.2);
    }
    .form-container h2 {
      margin-bottom: 20px;
      color: #00ffe0;
    }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0 20px;
      border: none;
      border-radius: 10px;
      background: rgba(255,255,255,0.15);
      color: white;
    }
    input::placeholder {
      color: #ccc;
    }
    button {
      background-color: #00ffe0;
      border: none;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      width: 100%;
      transition: all 0.3s ease;
    }
    button:hover {
      background-color: #00bfa5;
    }
    .popup {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #00ffe0;
      color: #000;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 255, 224, 0.4);
      animation: fadeInOut 4s ease;
      z-index: 9999;
    }

    @keyframes fadeInOut {
      0% {opacity: 0; transform: translateY(-20px);}
      10% {opacity: 1; transform: translateY(0);}
      90% {opacity: 1;}
      100% {opacity: 0; transform: translateY(-20px);}
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email Address" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Register</button>
    </form>
  </div>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="popup"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
  <?php endif; ?>
</body>
</html>
