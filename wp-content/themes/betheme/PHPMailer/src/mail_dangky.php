<?php
header("Content-type: text/html; charset=UTF-8");
require("PHPMailer.php");
require("SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function sendmail($mail_to,$url)
{
    $mail = new PHPMailer();
    $mail->IsSMTP(); // enable SMTP

//    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->SMTPSecure = 'tls';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->Host = "smtp.gmail.com";
    $mail->CharSet = 'UTF-8';
    $mail->Port = 587;   // or 587
    $mail->IsHTML(true);
    $mail->Username = "thiennhant95@gmail.com";
    $mail->Password = "tiep290696";
    $mail->SetFrom("thiennhant95@gmail.com",'Rookie Marketing 2018');
    $mail->Subject = "Xác nhân tài khoản đăng ký Rookie Marketing";
    $mail->Body = "Bạn đã đăng kí tài khoản thành công. Bạn vui lòng nhấn vào link dưới để xác nhận tài khoản đăng ký: <br><a href='$url'>$url</a>
<br>
<br/>
<b>Rookie Marketing 2018</b><br/>
<b>0984 580 548 </b>
";
    $mail->AddAddress($mail_to);
    $mail->AddAddress('anhduy.bui1995@gmail.com');

    if(!$mail->Send()) {
        return false;
//        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return true;
//        echo "Message has been sent";
    }
}
?>