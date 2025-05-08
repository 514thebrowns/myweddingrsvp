<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $seats = htmlspecialchars($_POST['seats']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Your email address
    $to = "tristoncolombaris@gmail.com";

    // Subject for admin email
    $subject = "RSVP for Fanie & Triston's Wedding";
    
    // Message to you
    $message = "You have received a new RSVP submission!\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Seats Needed: " . $seats . "\n";
    
    // Headers for email to you
    $headers = "From: no-reply@myweddingrsvp.ca\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    // Prevent header injection
    $headers = str_replace(array("\r", "\n"), '', $headers);

    // Send email to you
    if (!mail($to, $subject, $message, $headers)) {
        die("Failed to send email to admin.");
    }

    // Confirmation email to guest
    $confirmation_subject = "Thank You for Your RSVP – A Few Quick Questions";

    $confirmation_message = "Hi {$name},\n\n";
    $confirmation_message .= "Thank you so much for submitting your request to join us at our wedding — we’re so excited and can’t wait to celebrate with you!\n\n";
    $confirmation_message .= "Before we officially lock in your seat, we just need a little more information to help us plan:\n\n";
    $confirmation_message .= "    - Will you be bringing any children?\n";
    $confirmation_message .= "    - Do you or anyone in your party have any allergies we should be aware of?\n";
    $confirmation_message .= "    - Will you need help with carpooling or transportation?\n";
    $confirmation_message .= "    - Would you like us to send information about nearby hotels or booking accommodations?\n\n";
    $confirmation_message .= "Please reply at your earliest convenience so we can make sure everything is perfect for your visit.\n\n";
    $confirmation_message .= "With love,\n";
    $confirmation_message .= "The Browns.";

    // Headers for guest confirmation
    $guest_headers = "From: no-reply@myweddingrsvp.ca\r\n" .
                     "Reply-To: tristoncolombaris@gmail.com\r\n" .
                     "Content-Type: text/plain; charset=UTF-8";

    // Prevent header injection
    $guest_headers = str_replace(array("\r", "\n"), '', $guest_headers);

    // Send email to the guest
    if (!mail($email, $confirmation_subject, $confirmation_message, $guest_headers)) {
        die("Failed to send confirmation email to guest.");
    }

    // Redirect or display a thank you message
    echo "Thank you for your RSVP! We look forward to celebrating with you.";
}
?>

