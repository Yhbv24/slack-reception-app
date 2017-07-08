# R/West Reception App
#### By Ash Laidlaw and Xia Amendolara

## About

This is a web-based PHP app that is meant for office reception areas. The app allows guests (deliveries, friends, etc.) to check in by choosing who they need to visit from the list. It will send a message to that person on Slack, but if that person is offline, it will send an email to that person's email address associated with Slack.. Its purpose is to simplify check-in for office visitors in an easy way.

![App Screenshot](/img/rwest-screenshot.png)

## Technologies Used

• PHP
• PHPMailer
• JavaScript
• HTML
• SASS
• Slack API
  • chat.postMessage
  • users.list

## Setup Instructions

To use this app, you will need to download the PHPMailer package from https://github.com/PHPMailer/PHPMailer. In addition, you will need to create a Slack token and either add the token directly to the index.php file, or create a new file to which to add the token. For more information about the Slack token, please visit https://api.slack.com/.

You will also need to compile the .scss file before loading the page, or else it will not have any styling applied. You can also create a custom CSS file and use that.

## Copyright Information

MIT License, © Ash Laidlaw and Xia Amendolara
