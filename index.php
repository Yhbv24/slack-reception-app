<?php
    require_once 'slack_url.php';
    $ch = curl_init();
    $opts = array(
        'token' => $slack_token,
        'presence' => 1
    );
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
        <title>Welcome to R/West</title>
    </head>
    <body>
        <h2 id="welcome-title">Welcome to R/West</h2>
        <img src="img/rwest-logo-sm.png" alt="R/West Logo" id="main-logo">
        <?php if ($results->ok) : ?>
        <form action="success.php" method="post" name="form" id="form">
            <div id="emp-select">
                <label for="employee">Who are you here to see?</label>
                <select name="employee" id="emp-list">
                    <option value="none" disabled selected>Office Directory</option>
                    <?php foreach($results->members as $member) : ?>
                        <?php if ($member->profile->real_name_normalized && $member->deleted != 1 && $member->profile->real_name_normalized != 'slackbot' && $member->profile->real_name_normalized != 'Trello' && $member->presence === 'active') : ?>
                            <option value="<?php echo $member->id; ?>"><?php echo ucwords($member->profile->real_name_normalized); ?></option>
                        <?php elseif ($member->presence === 'away' && $member->profile->real_name_normalized && $member->deleted != 1 && $member->profile->real_name_normalized != 'slackbot' && $member->profile->real_name_normalized != 'Trello') : ?>
                            <option value="<?php echo $member->profile->email; ?>"><?php echo ucwords($member->profile->real_name_normalized); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-input">
                <label for="guest_name">Your Name:</label>
                <input name="guest_name" type="text" required>
            </div>

            <div class="text-input">
                <label for="guest_org">Your Organization:</label>
                <input name="guest_org" type="text" required>
            </div>

            <div type="submit" id="submit" onclick="submitForm()">Submit</div>
            <script>
                function submitForm() {
                    document.forms["form"].submit();
                }
            </script>
        </form>
        <?php else : ?>
            <h3>Sorry, we were not able to retrieve a list of employees. Please try again in a few minutes.</h3>
        <?php endif; ?>
    </body>
</html>
