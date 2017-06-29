<?php
    require_once 'slack_url.php';
    require 'PHPMailer/PHPMailerAutoload.php';
    $guest_name = $_POST[filter_var('guest_name', FILTER_SANITIZE_MAGIC_QUOTES)];
    $guest_org = $_POST[filter_var('guest_org', FILTER_SANITIZE_MAGIC_QUOTES)];
    $emp_info = $_POST['employee'];
    $guest_reason = $_POST['reason'];
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
        $mail->Subject = 'R/West Receptionist: ' . message_to_send($guest_reason, $guest_name, $guest_org);
        $mail->Body = message_to_send($guest_reason, $guest_name, $guest_org);
        $mail->AltBody = message_to_send($guest_reason, $guest_name, $guest_org);
        $mail->send();
    } else { // If employee is online, send Slack message
        $opts = array(
            'token' => $slack_token,
            'channel' => $emp_info,
            'as_user' => 0,
            'text' => message_to_send($guest_reason, $guest_name, $guest_org),
            'username' => 'R/West Guest'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/chat.postMessage');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
        curl_exec($ch);
        curl_close($ch);
    }

    function message_to_send($guest_reason, $guest_name, $guest_org) {
        switch ($guest_reason) {
            case '0':
                $message_to_send = 'Hey! ' . $guest_name . ' from ' . $guest_org . ' is here with your delivery.';
                return $message_to_send;
            break;
            case '1':
                $message_to_send = 'Hey! ' . $guest_name . ' from ' . $guest_org . ' is here for the meeting.';
                return $message_to_send;
            break;
            case '2':
                $message_to_send = 'Hey! ' . $guest_name . ' from ' . $guest_org . ' is here to meet you.';
                return $message_to_send;
            break;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
      <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
      <link href='css/origin-files/opensans-fonts.css' rel='stylesheet' type='text/css'>
      <link href="css/styles.css" rel="stylesheet" type="text/css">
        <title>Thanks! We'll be with you shortly.</title>
    </head>
    <body class="success-page">
      <div id='success-container'>
        <br><img src="img/rwest-logo-sm.png" alt="R/West Logo" id="main-logo">
        <h1>Thank you <span id='name'>
        <?php echo $guest_name ?>
      </span>
        !</h1>
        <h3 class="greeting-message" id="success-greet">Please take a seat, and someone will be with you shortly.</h3>
      </div>
    </body>
    <script>
        setTimeout(function() {
            window.location = "http://rweststaging.com/RWest-Greeting-App/";
        }, 5000);
    </script>
</html>
