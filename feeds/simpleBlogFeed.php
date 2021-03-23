<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSS Demo</title>
</head>
<?php

$pageTitle = "All Posts";
include 'include/header.php';

?>

<body>
    <h3>Simple Blog RSS Demo</h3>
    <?php
    $feedUrl = "http://localhost/Demos_NP/feeds/rss.php";
    $ch = curl_init($feedUrl);

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    // echo curl_getinfo($ch);

    // var_dump($response);

    curl_close($ch);

    $doc = simplexml_load_string($response);

    if (isset($doc->channel)) {
        //Do sth
        parseData($doc);
    }

    function parseData($xml)
    {
        echo "<h3>" . $xml->channel->title  . "</h3>";
        $count = count($xml->channel->item);

        for ($i = 0; $i < $count; $i++) {
            $id = $xml->channel->item[$i]->id;
            $authorId = $xml->channel->item[$i]->authorId;
            $title = $xml->channel->item[$i]->title;
            $desc = $xml->channel->item[$i]->description;
            $teaser = $xml->channel->item[$i]->teaser;
            $link = $xml->channel->item[$i]->link;
            $pubDate = $xml->channel->item[$i]->pubDate;

    ?>
            <div style="width:50%; float:left;">
                <h3>Title: <?php echo $title; ?></h3>
                <h4>Published Date: <?php echo $pubDate ?></h4>
                <p>ID: <?php echo $id; ?> Auth Id: <?php echo $authorId ?></p>
                <p>Teaser: <?php echo $teaser; ?></p>
                <p>Description: <?php echo $desc; ?></p>
                <a href="<?php echo $link ?>" target="_blank"> See Full story</a>
            </div>
    <?php
        }
    }

    ?>
</body>

</html>