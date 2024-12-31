<?php
// Allows requests from any origin by setting the CORS (Cross-Origin Resource Sharing) policy.
header("Access-Control-Allow-Origin: *"); 

// Specifies the HTTP methods that are allowed for CORS requests.
// In this case, it allows GET, POST, and OPTIONS requests.
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Specifies the HTTP headers that are allowed in requests.
// This allows 'Content-Type' (for JSON or other data) and 'Authorization' (for tokens or credentials).
header("Access-Control-Allow-Headers: Content-Type, Authorization");


// Sets the content type of the response to JSON format.
// Ensures that the server response will be correctly interpreted by the client as JSON.
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Get JSON input from the request
$jsonData = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($jsonData, true);

// Check if the data is valid
if (isset($data['name'])) {
    // User-submitted form details
    $userName = $data['name'];
    $phone = $data['phone'];
    $userEmail = $data['email'];
    $vehicle = $data['vehicle'];
    $message = $data['message'];
    
    // Admin email to receive notifications
    $adminEmail = 'nandhareddy6151@gmail.com';  // Replace with the actual admin email

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nandhareddy6151@gmail.com';
        $mail->Password = 'ayzbwlthdslxhukf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Send email to Admin
        $mail->clearAddresses();
        $mail->setFrom($userEmail);
        $mail->addAddress($adminEmail);
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from $userEmail";
        $mail->Body = "
            <h3>New Contact Form Submission</h3>
            <p><strong>User Name:</strong> $userName</p>
            <p><strong>Email:</strong> $userEmail</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";
        $mail->send();

        // Send confirmation email to User
        $mail->clearAddresses();  // Clear previous recipient
        $mail->setFrom($adminEmail, 'Contact Form Notification');
        $mail->addAddress($userEmail);  // Set recipient to the user's email
        $mail->Subject = "Thank you for your submission!";
        $mail->Body = "
            <h3>Thank you for reaching out!</h3>
            <p>We have received your details and will get back to you shortly.</p>
            <br><br>
            <p>Regards,</p>
            <p>Sneha Foam Wash</p>
        ";
        $mail->send();

        // Success JSON response
        echo json_encode(['success' => true, 'message' => 'Form submitted successfully. You will receive a confirmation email shortly.']);
    } 
    catch (Exception $e) {
        // Error JSON response
        echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} 
else {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
}
?>







