<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();
$mail->setFrom('nguyenthuquan99@gmail.com');
$mail->addAddress('nguyenthuquan99@gmail.com');
$mail->Subject = 'Test Mail';
$mail->Body    = 'Hello, this is a test!';
$mail->send();
