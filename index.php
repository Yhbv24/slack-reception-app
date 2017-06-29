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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
  <link href='css/origin-files/opensans-fonts.css' rel='stylesheet' type='text/css'>
  <link href="css/styles.css" rel="stylesheet" type="text/css">

  <title>Welcome to R/West</title>
</head>
<body>
  <div id="page-container">
    <div class="content-container">
      <img src="img/rwest-logo-sm.png" alt="R/West" class="logo">
      <img id="welcome-title" src="img/rwest-welcome-sm.png" alt="Welcome to R/West" class="welcome">
      <div class="greeting-message">Who are you here to see?</div>
      <div class="body">
        <div class="contact-list-container">
          <?php if ($results->ok) : ?>
            <form action="success.php" method="post" name="form" id="form">
              <div id="emp-select">
                <select name="employee" id="slct" required>
                  <option value="" disabled selected>Office Directory</option>
                  <?php foreach($results->members as $member) : ?>
                    <?php if ($member->profile->real_name_normalized && $member->deleted != 1 && $member->profile->real_name_normalized != 'slackbot' && $member->profile->real_name_normalized != 'Trello' && $member->presence === 'active') : ?>
                      <option value="<?php echo $member->id; ?>"><?php echo ucwords($member->profile->real_name_normalized); ?></option>
                    <?php elseif ($member->presence === 'away' && $member->profile->real_name_normalized && $member->deleted != 1 && $member->profile->real_name_normalized != 'slackbot' && $member->profile->real_name_normalized != 'Trello') : ?>
                      <option value="<?php echo $member->profile->email; ?>" required><?php echo ucwords($member->profile->real_name_normalized); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div id="text-input">
                <div class="text-input">
                  <label for="guest_name">Your Name:</label>
                  <input placeholder="Your Name" name="guest_name" type="text" required>
                </div>

                <div class="text-input">
                  <label for="guest_org">Your Organization:</label>
                  <input placeholder="Your Organization" name="guest_org" type="text" required>
                </div>

                <button type="submit" id="submit">Message</button>
              </div>
            </form>
          <?php else : ?>
            <h3>Sorry, we were not able to retrieve a list of employees. Please try again in a few minutes.</h3>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
