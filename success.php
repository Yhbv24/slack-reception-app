<?php
    require_once('slack_url.php');
    $ch = curl_init();
    $message_to_send = $_POST[filter_var('guest_name', FILTER_SANITIZE_MAGIC_QUOTES)] . ' from ' . $_POST[filter_var('guest_org', FILTER_SANITIZE_MAGIC_QUOTES)] . ' sent you a message: ' . $_POST[filter_var('message', FILTER_SANITIZE_MAGIC_QUOTES)];
    $opts = array(
        'token' => $slack_token,
        'channel' => $_POST['employee'],
        'as_user' => 0,
        'text' => $message_to_send,
        'username' => 'R/West Guest'
    );
    curl_setopt($ch, CURLOPT_URL,'https://slack.com/api/chat.postMessage');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $opts);
    $response = curl_exec($ch);
    $results = json_decode($response);
    curl_close($ch);
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="css/styles.min.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8">
        <title>Thanks!</title>
    </head>
    <body>
        <h3>Thanks <?php echo $_POST[filter_var('guest_name', FILTER_SANITIZE_MAGIC_QUOTES)] ?>, we've sent your message!</h3>
    </body>
</html>
