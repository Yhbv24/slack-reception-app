<?php
    require_once('slack_url.php');
    $ch = curl_init();
    $opts['token'] = $slack_token;
    curl_setopt($ch, CURLOPT_URL,'https://slack.com/api/users.list');
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
        <title>R/West Messenger</title>
    </head>
    <body>
        <form action="success.php" method="post">
            <label for="employee">Employee:</label><br>
            <select name="employees">
                <option value="none">Please choose a name:</option>
                <?php foreach($results->members as $member) : ?>
                    <?php if ($member->profile->real_name_normalized && $member->deleted != 1) : ?>
                        <option value="<?php $member ?>"><?php echo $member->profile->real_name_normalized ?></option>
                <?php endif; endforeach; ?>
            </select>

            <label for="message">Message:</label>
            <input type="textarea">

            <button type="submit">Submit</button>
        </form>
    </body>
</html>
