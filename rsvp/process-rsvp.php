<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $seats = htmlspecialchars($_POST['seats']);
    
    // Recipient email address (change this to your email)
    $to = "Tristoncolombaris@gmail.com";  // Change this to your email address
    
    // Subject
    $subject = "RSVP for Fanie & Triston's Wedding";
    
    // Message body
    $message = "You have received a new RSVP submission!\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Seats Needed: " . $seats . "\n";
    
    // Headers
    $headers = "From: no-reply@example.com" . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";
    
    // Send the email to you
    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you for your RSVP! We look forward to celebrating with you.";
    } else {
        echo "Sorry, there was an error processing your RSVP. Please try again later.";
    }

    // Send a confirmation email to the person who submitted the RSVP
    $confirmation_subject = "RSVP Confirmation for Fanie & Triston's Wedding";
    $confirmation_message = "Thank you for your RSVP!\n\nHere are your details:\n";
    $confirmation_message .= "Name: " . $name . "\n";
    $confirmation_message .= "Phone: " . $phone . "\n";
    $confirmation_message .= "Email: " . $email . "\n";
    $confirmation_message .= "Seats Needed: " . $seats . "\n\n";
    $confirmation_message .= "We look forward to celebrating with you on November 1, 2025!";
    $confirmation_headers = "From: no-reply@example.com" . "\r\n" .
                           "Reply-To: " . $to . "\r\n" .
                           "Content-Type: text/plain; charset=UTF-8";

    // Send confirmation email to the user
    mail($email, $confirmation_subject, $confirmation_message, $confirmation_headers);
}
?>
