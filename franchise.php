<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';



// Database connection details
$servername = "localhost"; // Update with your server name if not localhost
$dbusername = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "snehafoamwash"; // Database name



// Start output buffering
ob_start();

// Get JSON input from the request
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Validate input
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    exit;
}



// Extract user data with default values for missing fields
$userName = $data['name'] ?? 'Unknown';
$phone = $data['phone'] ?? 'Not provided';
$userEmail = $data['email'] ?? 'Not provided';
$address = $data['address'] ?? 'Not provided';
$budget = $data['budget'] ?? 'Not provided';
$purpose = $data['purpose'] ?? 'Not provided';
$gender = $data['gender'] ?? 'Not provided';
$age = $data['age'] ?? 'Not provided';
$education = $data['education'] ?? 'Not provided';
$occupation = $data['occupation'] ?? 'Not provided';
$preferedLocation = $data['preferedLocation'] ?? 'Not provided';
$DurationOfStartingTheBusiness = $data['DurationOfStartingTheBusiness']?? 'Not provided';
$previousCustomer = $data['previousCustomer']?? 'Not provided';
$informationSource = $data['informationSource']?? 'Not provided';
$property = $data['property']?? 'Not provided';
$preferredArea = $data['preferredArea']?? 'Not provided';
$carSpa = $data['carSpa']?? 'Not provided';
$carDetailing = $data['carDetailing']?? 'Not provided';
$bodyShopBudget = $data['bodyShopBudget']?? 'Not provided';
$bodyShopBudgetPremium = $data['bodyShopBudgetPremium']?? 'Not provided';
$carElite = $data['carElite']?? 'Not provided';
$carGlassWorks = $data['carGlassWorks']?? 'Not provided';
$carDetailingAlignment = $data['carDetailingAlignment']?? 'Not provided';
$carSeatCover = $data['carSeatCover']?? 'Not provided';
$carMobileDetailer = $data['carMobileDetailer']?? 'Not provided';
$carDetailingBodyShop = $data['carDetailingBodyShop']?? 'Not provided';
$carPPF = $data['carPPF']?? 'Not provided';
$franchiseAgreement = $data['franchiseAgreement']?? 'Not provided';
$ManPower = $data['ManPower']?? 'Not provided';
$doYouKnowSnehaFoamWash = $data['doYouKnowSnehaFoamWash']?? 'Not provided';
$technology = $data['technology']?? 'Not provided';
$governmentSubsidy = $data['governmentSubsidy']?? 'Not provided';
$ROI = $data['ROI']?? 'Not provided';
$constructionPlan = $data['constructionPlan']?? 'Not provided';
$secondarySalesPartner = $data['secondarySalesPartner']?? 'Not provided';

// Compose a basic message (customize as needed)
$message1 = "
    Name: $userName<br>
    Phone: $phone<br>
    Email: $userEmail<br>
    Address: $address<br>
    Budget: $budget<br>
    Purpose: $purpose<br>";
$message = "
    <strong>Name:</strong> $userName<br>
    <strong>Phone:</strong> $phone<br>
    <strong>Email:</strong> $userEmail<br>
    <strong>Address:</strong> $address<br>
    <strong>Budget:</strong> $budget<br>
    <strong>Purpose:</strong> $purpose<br>
    <strong>Prefered Location:</strong>$preferedLocation<br>
    <strong>Duration Of Starting The Business:</strong>$DurationOfStartingTheBusiness<br>
    <strong>Previous Customer:</strong>$previousCustomer<br>
    <strong>Information Source:</strong>$informationSource<br>
    <strong>Property:</strong>$property<br>
    <strong>preferred Area:</strong>$preferredArea<br>
    <strong>Car Spa:</strong>$carSpa<br>
    <strong>Car Detailing:</strong>$carDetailing<br>
    <strong>Body Shop Budget:</strong>$bodyShopBudget<br>
    <strong>Body Shop Budget Premium:</strong>$bodyShopBudgetPremium<br>
    <strong>Car Elite:</strong>$carElite<br>
    <strong>Car Glass Works:</strong>$carGlassWorks<br>
    <strong>Car Detailing Alignment:</strong>$carDetailingAlignment<br>
    <strong>Car Seat Cover:</strong>$carSeatCover<br>
    <strong>Car Mobile Detailer:</strong>$carMobileDetailer<br>
    <strong>Car Detailing Body Shop:</strong>$carDetailingBodyShop<br>
    <strong>Car PPF:</strong>$carPPF<br>
    <strong>Franchise Agreement:</strong>$franchiseAgreement<br>
    <strong>ManPower:</strong>$ManPower<br>
    <strong>Do You Know Sneha Foam Wash:</strong>$doYouKnowSnehaFoamWash<br>
    <strong>Technology:</strong>$technology<br>
    <strong>Government Subsidy:</strong>$governmentSubsidy<br>
    <strong>ROI:</strong>$ROI<br>
    <strong>Construction Plan:</strong>$constructionPlan<br>
    <strong>Secondary Sales Partner:</strong>$secondarySalesPartner<br>
";

// Admin email to receive notifications
$adminEmail = 'nandhareddy6151@gmail.com'; // Replace with your admin email

$mail = new PHPMailer(true);


// Insert data into the database
try {
    // Create a new connection to dataBase
    $conn = new mysqli($servername, $dbusername, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // // Prepare the SQL query
    // $stmt = $conn->prepare("INSERT INTO franchise (name, email, message) VALUES (?, ?, ?)");
    // $stmt->bind_param("sss", $userName, $userEmail, $purpose);


    $stmt = $conn->prepare("INSERT INTO franchise_form (
        name, 
        email, phone, 
        address, 
        budget, 
        purpose, 
        gender, 
        age, 
        education, 
        occupation, 
        preferedLocation, 
        DurationOfStartingTheBusiness, 
        previousCustomer, 
        informationSource, 
        property, 
        preferredArea, 
        carSpa, 
        carDetailing, 
        bodyShopBudget, 
        bodyShopBudgetPremium, 
        carElite, 
        carGlassWorks, 
        carDetailingAlignment, 
        carSeatCover, 
        carMobileDetailer, 
        carDetailingBodyShop, 
        carPPF, 
        franchiseAgreement, 
        ManPower, 
        doYouKnowSnehaFoamWash, 
        technology, 
        governmentSubsidy, 
        ROI, 
        constructionPlan, 
        secondarySalesPartner
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sssssssssssssssssssssssssssssssssss", 
        $userName,
        $userEmail,
        $phone,
        $address,
        $budget,
        $purpose,
        $gender,
        $age,
        $education,
        $occupation,
        $preferedLocation,
        $DurationOfStartingTheBusiness,
        $previousCustomer,
        $informationSource,
        $property,
        $preferredArea,
        $carSpa,
        $carDetailing,
        $bodyShopBudget,
        $bodyShopBudgetPremium,
        $carElite,
        $carGlassWorks,
        $carDetailingAlignment,
        $carSeatCover,
        $carMobileDetailer,
        $carDetailingBodyShop,
        $carPPF,
        $franchiseAgreement,
        $ManPower,
        $doYouKnowSnehaFoamWash,
        $technology,
        $governmentSubsidy,
        $ROI,
        $constructionPlan,
        $secondarySalesPartner
    );
    

    // Execute the query
    if (!$stmt->execute()) {
        throw new Exception("Error executing query: " . $stmt->error);
    }

    // Close the statement and connection
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nandhareddy6151@gmail.com'; // Your email
    $mail->Password = 'ayzbwlthdslxhukf'; // Your app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Send email to Admin
    $mail->clearAddresses();
    $mail->setFrom($adminEmail, 'Franchise Form Notification');
    $mail->addAddress($adminEmail);
    $mail->isHTML(true);
    $mail->Subject = "New Franchise Inquiry from $userName";
    $mail->Body = "
        <h3>New Franchise Inquiry</h3>
        <p>$message</p>
    ";
    $mail->send();

    // Send confirmation email to User
    if ($userEmail !== 'Not provided') {
        $mail->clearAddresses();
        $mail->setFrom($adminEmail, 'Franchise Form Notification');
        $mail->addAddress($userEmail);
        $mail->Subject = "Thank you for your franchise inquiry!";
        $mail->Body = "
            <h3>Thank you for reaching out, $userName!</h3>
            <p>We will review your submission and get back to you shortly.</p>
            <br><br>
            <p>Regards,</p>
            <p>Sneha Foam Wash</p>
                    ";
        $mail->send();
    }

    // Success JSON response
    echo json_encode(['success' => true, 'message' => 'Form submitted successfully. You will receive a confirmation email shortly.']);
} catch (Exception $e) {
    // Error JSON response
    echo json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    exit;
}



// End output buffering
ob_end_flush();

?>
