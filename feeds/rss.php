<?php

include 'include/functions.php';
include 'include/db/dbFunctions.php';
header("Content-Type: application/rss+xml; charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>My Application RSS feed</title>';
echo '<link>http://localhost/Demos_NP/feeds/</link>';
echo '<description>Give a description here</description>';
echo '<language>en-us</language>';

$url = "http://localhost/Demos_NP/feeds/rss.php";
$conn = connect('simpleblog');

$results = getAllPosts($conn);


foreach ($results as $row) {
    $date = date(DATE_RSS, strtotime($row['created_at']));
    echo '<item>';
    echo '<id>' . $row['id'] . '</id>';
    echo '<authorId>' . $row['author_id'] . '</authorId>';
    echo '<teaser>' . $row['teaser'] . '</teaser>';
    echo '<title>' . $row['title'] . '</title>';
    echo '<description>' . $row['body'] . '</description>';
    echo '<link>' . $url . $row['id'] . '</link>';
    echo '<guid>' . $url . $row['id'] . '</guid>';
    echo '<pubDate>' . $date . '</pubDate>';
    echo '</item>';
}
$conn->close();

echo '</channel>';
echo  '</rss>';
