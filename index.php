<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NASA APOD by Year and Month</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .picNASA img {
            width: 40rem;
            height: 100%;
            overflow: hidden;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center p-3">Photo of the days</h1>
        <div class="d-flex justify-content-center pb-3">
            <form method="GET" action="">
                <div class="mb-3">
                    <label for="year" class="form-label">Year:</label>
                    <input type="number" id="year" name="year" min="1995" max="<?php echo date('Y'); ?>"
                        class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="month" class="form-label">Month:</label>
                    <select id="month" name="month" class="form-select" required>
                        <?php
                        for ($m = 1; $m <= 12; $m++) {
                            $month = str_pad($m, 2, '0', STR_PAD_LEFT);
                            echo "<option value=\"$month\">$month</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Show Pictures</button>
            </form>

        </div>

        <?php
        if (isset($_GET['year']) && isset($_GET['month'])) {
            $year = $_GET['year'];
            $month = $_GET['month'];
            $startDate = "$year-$month-01";
            $endDate = date("Y-m-t", strtotime($startDate));
            $apiUrl = 'https://api.nasa.gov/planetary/apod';
            $apiKey = 'HCaT9nkyAff4yCeIjTaGbbPC6LnDyYipQEFBUgUV';

            $url = $apiUrl . '?api_key=' . $apiKey . '&start_date=' . $startDate . '&end_date=' . $endDate;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            $data = json_decode($response, true);
            if ($httpStatusCode == 200 && !empty($data)) {
                foreach ($data as $dayData) {
                    if (isset($dayData['url'])) {
                        ?>
                        <div class="">
                            <h3 class="text-center"><?php echo $dayData['title']; ?></h3>
                            <div class="picNASA">
                                <a href="detail.php?url=<?php echo $dayData['url']; ?>&title=<?php echo urlencode($dayData['title']); ?>&date=<?php echo $dayData['date']; ?>&explanation=<?php echo urlencode($dayData['explanation']); ?>"
                                    target="_blank">
                                    <div class="d-flex justify-content-center">
                                        <img src="<?php echo $dayData['url']; ?>" alt="<?php echo $dayData['title']; ?>"
                                            style="max-width:100%;">
                                    </div>
                                </a>
                            </div>
                            <p><?php echo $dayData['date']; ?></p>
                        </div>
                        <hr>
                        <?php
                    }
                }
            } else {
                echo '<p>Unable to fetch data from API</p>';
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>