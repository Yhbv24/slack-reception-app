<?php
    require_once 'slack_url.php';
    require 'PHPMailer/PHPMailerAutoload.php';
    $guest_name = $_POST[filter_var('guest_name', FILTER_SANITIZE_MAGIC_QUOTES)];
    $guest_org = $_POST[filter_var('guest_org', FILTER_SANITIZE_MAGIC_QUOTES)];
    $emp_info = $_POST['employee'];
    $message_to_send = 'Hey! ' . $guest_name . ' from ' . $guest_org . ' is here.';
    if (strpos($_POST['employee'], '@') !== false) { // If employee is not online, send email to email address
        date_default_timezone_set('Etc/UTC');
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'rwestalerts@gmail.com';
        $mail->Password = $mail_password;
        $mail->setFrom('rwestalerts@gmail.com', 'R/West Alerts');
        $mail->addReplyTo('rwestalerts@gmail.com', 'R/West Alerts');
        $mail->addAddress(strtolower($emp_info));
        $mail->Subject = 'R/West Receptionist: ' . $guest_name . ' is here to see you!';
        $mail->Body = 'Hi, ' . $guest_name . ' is here to see you!';
        $mail->AltBody = 'Hi, ' . $guest_name . ' is here to see you!';
        $mail->send();
    } else { // If employee is online, send Slack message
        $opts = array(
            'token' => $slack_token,
            'channel' => $emp_info,
            'as_user' => 0,
            'text' => $message_to_send,
            'username' => 'R/West Guest: ' . $guest_name
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/chat.postMessage');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
        curl_exec($ch);
        curl_close($ch);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
        <link href="css/styles.min.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8">
        <title>Thanks! We'll be with you shortly.</title>
    </head>
    <body>
        <br><img src="img/rwest-logo-sm.png" alt="R/West Logo" id="main-logo">
        <h3>Thanks <?php echo $guest_name ?>! Take a seat, and someone will be with you shortly. <?php echo $_POST['emp_email']?></h3>
    </body>
    <script>
        setTimeout(function() {
            window.location = "http://rweststaging.com/RWest-Greeting-App/";
        }, 5000);
    </script>
</html>
