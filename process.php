<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Load config and dependencies
require 'config/config.php';  // Contains $pdo connection
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Email sender function
function sendWelcomeEmail($userEmail, $userName) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@techalphahub.com';
        $mail->Password = 'Uyioobong155@';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('info@techalphahub.com', 'TechAlpha Hub');
        $mail->addAddress($userEmail, $userName);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to TechAlpha Hub!';
        $mail->Body    = "<h1>Welcome, $userName!</h1><p>Thank you for registering with TechAlpha Hub.</p>";
        $mail->AltBody = "Welcome, $userName! Thank you for registering with TechAlpha Hub.";
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle registration
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Check for existing email
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "❌ Email already registered. Please use another email.";
        exit;
    }

    // ✅ Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $result = $stmt->execute([$name, $email, $password]);

    if ($result) {
        sendWelcomeEmail($email, $name);
        header('Location: thankyou.php');
        exit;
    } else {
        echo "❌ Error occurred during registration.";
    }
}

// Handle login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: dashboard.php');
        exit;
    } else {
        echo "❌ Invalid login credentials.";
    }
}
?>
