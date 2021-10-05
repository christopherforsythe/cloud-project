<?php 

// Include PHPMailer library files 
require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP;  

// Create an instance of PHPMailer class 
$mail = new PHPMailer();

// SMTP configuration
$mail->isSMTP();
$mail->Host     = 'smtp.gmail.com';
$mail->SMTPAuth = "true";
$mail->Username = 'chris40134121@gmail.com';
$mail->Password = 'custom22';
$mail->SMTPSecure = 'tls';
$mail->Port     = 587;

// Sender info 
$mail->setFrom('chris40134121@gmail.com', 'cf'); 
$mail->addReplyTo('chris40134121@gmail.com', 'cf'); 
 
// Add a recipient 
$mail->addAddress('christtr1234@gmail.com'); 
 
// Email subject 
$mail->Subject = 'Error Update'; 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Email body content 
$mailContent = ' 
    <h2>Service Down!</h2> 
    <p>URL = '.$url.'</p>
    <p>Status = '.$response_code.'</p>
    <p>Response time = '.$serviceResponseTime.'</p>
    <p>Message = '.$message.'</p>'; 
$mail->Body = $mailContent; 
 
// Send email 
if(!$mail->send()){ 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;  
}else{ 
    echo 'Message sent!';
}

$mail->smtpClose();

?>