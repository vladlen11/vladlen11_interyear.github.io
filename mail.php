<?php

require_once __DIR__ . '/inc/class.smtp.php';
require_once __DIR__ . '/inc/class.phpmailer.php';

$rv = array();

$name = ''.@$_POST['name'];
$surname = ''.@$_POST['surname'];
$subject = ''.@$_POST['subject'];
$project = ''.@$_POST['project'];
$area = ''.@$_POST['area'];
$city = ''.@$_POST['city'];
$email = ''.@$_POST['email'];
$phone = ''.@$_POST['phone'];
$message = ''.@$_POST['message'];

$mail = new PHPMailer;

$mail->setFrom($email, $name . ' ' . $surname);
$mail->addAddress('interyear@intermedium.ru');

if (isset($_FILES['photo'])) {
    foreach ($_FILES['photo']['tmp_name'] as $i => $file_tmp_name) {
        if (!file_exists($file_tmp_name)) continue;
        $filename = $_FILES['photo']['name'][$i];
        $mail->addAttachment($file_tmp_name, $filename);
    }
}

$mail->isHTML(false);

$mail->Subject = 'Заявка на участие - ' . $subject;

$mail->Body = '';

$mail->Body .= 'Имя: ' . $name . "\n";
$mail->Body .= 'Фамилия: ' . $surname . "\n";
$mail->Body .= 'Проект: ' . $project . "\n";
$mail->Body .= 'Город: ' . $city . "\n";
$mail->Body .= 'Площадь: ' . $area . "\n";
$mail->Body .= 'Номинация: ' . $subject . "\n";
$mail->Body .= 'E-mail: ' . $email . "\n";
$mail->Body .= 'Телефон: ' . $phone . "\n";

$mail->Body .= "\n\n" . $message;

if(!$mail->send()) {
    $rv['message'] = 'Сообщение не может быть отправлено: ' . $mail->ErrorInfo;
} else {
    $rv['message'] = 'Сообщение успешно отправлено!';
}

echo json_encode($rv);
