<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Constants (recommended to move to a separate config file)
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USERNAME', 'luminary.web24@gmail.com');
define('MAIL_PASSWORD', 'iobb dxeg pnji cvtb'); // Store in env for production
define('MAIL_FROM_NAME', 'IP Center');
define('BASE_URL', 'https://luminary-ip.wuaze.com');

function sendVerificationEmail($email, $token, $name = 'User') {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom(MAIL_USERNAME, MAIL_FROM_NAME);
        $mail->addAddress($email);

        // Email Content
        $verifyLink = BASE_URL . "/api/verify.php?token=" . urlencode($token);

        $mail->isHTML(true);
        $mail->Subject = '🚀 Verify your Email - IP Facilitations Center';

        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <style>
            @media screen and (max-width: 600px) {
              .container { padding: 15px !important; }
              .button { padding: 10px 20px !important; font-size: 14px !important; }
              .logo { width: 60px !important; }
              h2 { font-size: 20px !important; }
              p { font-size: 14px !important; }
            }
            .button:hover {
              transform: scale(1.05);
              box-shadow: 0 0 15px #00ffe7;
            }
            a img { vertical-align: middle; }
          </style>
        </head>
        <body style="margin: 0; padding: 0; background-color: #1e1e2f;">
          <div class="container" style="font-family: Segoe UI, Roboto, sans-serif; max-width: 600px; margin: auto; padding: 30px; background: linear-gradient(135deg, #1e1e2f, #2b2b45); color: #ffffff; border-radius: 15px; box-shadow: 0 0 20px rgba(0,0,0,0.5);">
            <div style="text-align: center; margin-bottom: 20px;">
              <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" alt="IP Center" style="width: 100px;">
            </div>

            <h2 style="text-align: center; color: #00ffe7;">👋 Welcome, ' . htmlspecialchars($name) . '</h2>

            <p style="font-size: 16px;">Thanks for joining <strong>IP Facilitations Center</strong>! Let\'s activate your account:</p>

            <div style="text-align: center; margin: 30px 0;">
              <a href="' . $verifyLink . '" class="button" 
                 style="display: inline-block; background: #00ffe7; color: #000; padding: 14px 35px; border-radius: 30px; text-decoration: none; font-weight: bold; font-size: 16px; box-shadow: 0 0 10px #00ffe7; transition: all 0.3s ease;">
                 ✅ Verify My Email
              </a>
            </div>

            <p>If the button above doesn\'t work, copy and paste this link in your browser:</p>
            <p style="word-break: break-all; color: #00ffe7; text-align: center;">
              <a href="' . $verifyLink . '" style="color: #00ffe7;">' . $verifyLink . '</a>
            </p>

            <hr style="border: none; border-top: 1px solid #555; margin: 40px 0;">

            <div style="text-align: center;">
              <p style="font-size: 12px; color: #888;">Need help? Email us at 
              <a href="mailto:support@ipcenter.com" style="color: #00ffe7;">support@ipcenter.com</a></p>

              <div style="margin-top: 10px;">
                <a href="https://facebook.com" style="margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/24/733/733547.png" alt="Facebook" width="24"></a>
                <a href="https://twitter.com" style="margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/24/733/733579.png" alt="Twitter" width="24"></a>
                <a href="https://linkedin.com" style="margin: 0 8px;"><img src="https://cdn-icons-png.flaticon.com/24/145/145807.png" alt="LinkedIn" width="24"></a>
              </div>
            </div>

          </div>
        </body>
        </html>';

        // Fallback plain text
        $mail->AltBody = "Hello $name,\n\nPlease verify your email by clicking the link: $verifyLink\n\nThank you for joining IP Facilitations Center.";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email failed: " . $mail->ErrorInfo);
        return false;
    }
}
