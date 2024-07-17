<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASA APOD Detail</title>
</head>
<body>
    <?php
    if (isset($_GET['url']) && isset($_GET['title']) && isset($_GET['date'])) {
        $url = $_GET['url'];
        $title = $_GET['title'];
        $date = $_GET['date'];
        $explanation = $_GET['explanation']; 

        echo '<h1>' . $title . '</h1>';
        echo '<img src="' . $url . '" alt="' . $title . '" style="max-width:100%;">';
        echo '<p>Date: ' . $date . '</p>';
        echo '<p>' . $explanation . '</p>';

    } else {
        echo '<p>No image details available.</p>';
    }
    ?>
</body>
</html>
