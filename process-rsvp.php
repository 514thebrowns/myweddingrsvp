<?php
// Include Composer's autoloader and Dotenv
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $seats = htmlspecialchars($_POST['seats']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Validate the number of seats (must be a positive integer)
    if (!is_numeric($seats) || $seats < 1) {
        die("Invalid number of seats.");
    }

    // Admin email address
    $to = "tristoncolombaris@gmail.com";

    // Subject for admin email
    $subject = "RSVP for Fanie & Triston's Wedding";
    
    // Admin message body
    $message = "You have received a new RSVP submission!\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Seats Needed: " . $seats . "\n";
    
    // PHPMailer setup for admin email
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();                                           // Set mailer to use SMTP
    $mail->Host       = getenv('SMTP_HOST');                     // Get SMTP host from .env
    $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
    $mail->Username   = getenv('SMTP_USERNAME');                 // Get SMTP username from .env
    $mail->Password   = getenv('SMTP_PASSWORD');                 // Get SMTP password from .env
    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port       = getenv('SMTP_PORT');                     // Get SMTP port from .env

    // Admin email
    $mail->setFrom('no-reply@myweddingrsvp.ca', 'Wedding RSVP');
    $mail->addAddress($to);                                      // Add the admin's email address

    // Email content for admin
    $mail->Subject = $subject;
    $mail->Body    = $message;

    // Send the email to admin
    if (!$mail->send()) {
        die("Failed to send email to admin: " . $mail->ErrorInfo);
    }

    // Confirmation email to guest
    $confirmation_subject = "Thank You for Your RSVP – A Few Quick Questions";
    $confirmation_message = "Hi {$name},\n\n";
    $confirmation_message .= "Thank you for submitting your request to join us at our wedding. We can’t wait to celebrate with you!\n\n";
    $confirmation_message .= "Before we confirm your seat, we just need a little more information:\n\n";
    $confirmation_message .= "- Will you be bringing any children?\n";
    $confirmation_message .= "- Do you or anyone in your party have allergies we should be aware of?\n";
    $confirmation_message .= "- Will you need help with carpooling or transportation?\n";
    $confirmation_message .= "- Would you like information on nearby hotels or accommodations?\n\n";
    $confirmation_message .= "Please reply at your earliest convenience.\n\n";
    $confirmation_message .= "With love,\n";
    $confirmation_message .= "The Browns.";

    // Set up guest confirmation email
    $mail->clearAddresses();
    $mail->addAddress($email);                                     // Guest email address
    $mail->Subject = $confirmation_subject;
    $mail->Body    = $confirmation_message;

    // Send confirmation email to guest
    if (!$mail->send()) {
        die("Failed to send confirmation email to guest: " . $mail->ErrorInfo);
    }

    // Display thank you message after successful submission
    echo "Thank you for your RSVP! We look forward to celebrating with you.";

    // Stop script execution after displaying the message
    exit();
}
?>
