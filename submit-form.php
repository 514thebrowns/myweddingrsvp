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
    mail($to, $subject, $message, $headers);

    // Confirmation email to guest
    $confirmation_subject = "Wedding Invitation - A Few Details Before We Confirm";

    $confirmation_message = "Dear {$name},\n\n";
    $confirmation_message .= "Thank you so much for submitting your request to attend our wedding! We are absolutely thrilled to celebrate this special day with you and can't wait to see you there. Before we can finalize your invite, there are a couple of details we need to confirm:\n\n";
    $confirmation_message .= "    - How many children will you be bringing?\n";
    $confirmation_message .= "    - Will you need assistance with carpooling or transportation?\n";
    $confirmation_message .= "    - Do you have any allergies we should be aware of?\n";
    $confirmation_message .= "    - Would you like information on reserving a room at the hotel?\n\n";
    $confirmation_message .= "Once we have these details, we'll be able to lock in your invitation. Looking forward to hearing from you!\n\n";
    $confirmation_message .= "Warm regards,\nThe Browns.";

    // Headers for guest confirmation
    $guest_headers = "From: no-reply@myweddingrsvp.ca\r\n" .
                     "Reply-To: tristoncolombaris@gmail.com\r\n" .
                     "Content-Type: text/plain; charset=UTF-8";

    // Prevent header injection
    $guest_headers = str_replace(array("\r", "\n"), '', $guest_headers);

    // Send email to the guest
    mail($email, $confirmation_subject, $confirmation_message, $guest_headers);

    // Redirect or display a thank you message
    echo "Thank you for your RSVP! We look forward to celebrating with you.";
}
?>
