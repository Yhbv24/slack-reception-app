<?php
    require_once('slack_url.php');
    $ch = curl_init();
    $guest_name = $_POST[filter_var('guest_name', FILTER_SANITIZE_MAGIC_QUOTES)];
    $guest_org = $_POST[filter_var('guest_org', FILTER_SANITIZE_MAGIC_QUOTES)];
    $emp_id = $_POST['employee'];
    $message_to_send = 'Hey! ' . $guest_name . ' from ' . $guest_org . ' is here.';
    $opts = array(
        'token' => $slack_token,
        'channel' => $emp_id,
        'as_user' => 0,
        'text' => $message_to_send,
        'username' => 'R/West Guest'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://slack.com/api/chat.postMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
    curl_exec($ch);
    curl_close($ch);
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
        <link href="css/styles.min.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8">
        <title>Thanks!</title>
    </head>
    <body>
        <br><img src="img/rwest-logo-sm.png" alt="R/West Logo" id="main-logo">
        <h3>Thanks <?php echo $guest_name ?>! Take a seat, and someone will be with you shortly.</h3>
    </body>
    <script>
        setTimeout(function() {
            window.location = "http://localhost:8000/";
        }, 5000);
    </script>
</html>
