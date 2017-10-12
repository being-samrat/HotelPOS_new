<?php
// $to='samratbizmotech@gmail.com';
// $subject='Demo email';
// $body='Hello its test php email\n\n';
// $headers='From:mundesamrat@gmail.com';

// if (mail($to, $subject, $body,$headers)) {
// 	echo 'Message sent';
// }
// else{
// 	echo 'Message not sent';
// }
?>
<?php
require 'mail/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'samratbizmotech@gmail.com';                 // SMTP username
$mail->Password = '8446524095';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('mundesamrat@gmail.com', 'Mailer');
$mail->addAddress('samratbizmotech@gmail.com', 'Joe User');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}