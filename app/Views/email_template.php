<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <p>You have received a new message from your website's contact form.</p>
    <p>Here are the details:</p>
    <p>Subject: <strong><?= $subject; ?></strong><br>
        Name : <strong><?= $fromName; ?></strong><br>
        Phone: <strong><?= $phone; ?></strong><br>
        Email: <strong><?= $fromEmail; ?></strong></p>
    <p>Message:<br>
        <?= $message; ?>
    </p>
    <p>From: <strong>noreply <?= $to; ?></strong><br>
        Reply-To: <strong><?= $fromEmail; ?></strong></p>
</body>

</html>