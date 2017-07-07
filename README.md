# R/West Reception App
#### By Ash Laidlaw and Xia Amendolara

## About

This is a web-based PHP app that is meant for office reception areas. The app allows guests (deliveries, friends, etc.) to check in by choosing who they need to visit from the list. It will send a message to that person on Slack, but if that person is offline, it will send an email. Its purpose is to simplify office notifications using Slack.

![App Screenshot](/img/rwest-screenshot.png)

## Setup Instructions

To use this app, you will need to download the PHPMailer package from https://github.com/PHPMailer/PHPMailer. In addition, you will need to create a Slack token and either add the token directly to the index.php file, or create a new file to which to add the token. For more information about the Slack token, please visit https://api.slack.com/.

You will also need to compile the .scss file before loading the page, or else it will not have any styling applied. Please feel free to edit the files as you see fit for your office.

## Copyright Information

MIT License, © Ash Laidlaw and Xia Amendolara
