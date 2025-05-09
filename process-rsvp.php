<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data (Formspree submission)
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Assuming Formspree handling is successful (simple confirmation)
    // You can configure Formspree as needed
    $formspreeUrl = 'https://formspree.io/f/your-form-id'; // Replace with your Formspree form URL

    $response = file_get_contents($formspreeUrl, false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query([
                'name' => $name,
                'email' => $email,
                'message' => $message,
            ]),
        ],
    ]));

    // If the response from Formspree is successful, show a success page with confetti
    if ($response) {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Thank You!</title>
          <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
          <style>
            body {
              font-family: Arial, sans-serif;
              background-color: #f4f4f4;
              text-align: center;
              padding-top: 50px;
            }
            h1 {
              font-size: 3rem;
              color: #b71c1c;
            }
            p {
              font-size: 1.25rem;
            }
          </style>
        </head>
        <body>
          <h1>Thank You for Your RSVP!</h1>
          <p>We can’t wait to celebrate with you!</p>

          <script>
            // Confetti effect
            var end = Date.now() + (5 * 1000);
            var colors = ['#ff0', '#0f0', '#00f', '#f0f', '#ff0000'];

            (function frame() {
              confetti({
                particleCount: 2,
                angle: Math.random() * 360,
                spread: 360,
                origin: { x: Math.random(), y: Math.random() - 0.2 },
                colors: colors
              });
              if (Date.now() < end) {
                requestAnimationFrame(frame);
              }
            })();
          </script>
        </body>
        </html>';
        exit();
    } else {
        // Show error if Formspree submission fails
        echo "Sorry, there was an issue with your submission. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Wedding RSVP</title>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>RSVP to Our Wedding</h1>
    <form action="" method="
