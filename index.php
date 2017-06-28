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
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
        <link href="css/styles.min.css" rel="stylesheet" type="text/css">
        <meta charset="utf-8">
        <title>R/West Messenger</title>
    </head>
    <body>
        <h2 id="welcome-title">Welcome to R/West</h2>
        <?php if ($results->ok) : ?>
        <form action="success.php" method="post" id="form">
            <div id="emp-select">
                <label for="employee" id="emp-label">Who are you here to see?</label>
                <select name="employee" id="emp-list">
                    <?php foreach($results->members as $member) : ?>
                        <?php if ($member->profile->real_name_normalized && $member->deleted != 1 && $member->profile->real_name_normalized != 'slackbot' && $member->profile->real_name_normalized != 'Trello') : ?>
                            <option value="<?php echo $member->id; ?>"><?php echo ucwords($member->profile->real_name_normalized); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="guest-name">
                <label for="guest_name">Your Name:</label>
                <input name="guest_name" type="text" placeholder="your name" required>
            </div>

            <div id="guest-org">
                <label for="guest_org">Your Organization:</label>
                <input name="guest_org" type="text" placeholder="your organization" required>
            </div>

            <button type="submit" id="submit">Submit</button>
        </form>
        <?php else : ?>
            <h3>Sorry, we were not able to retrieve a list of employees. Please try again in a few minutes.</h3>
        <?php endif; ?>
    </body>
</html>
