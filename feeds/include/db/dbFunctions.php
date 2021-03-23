<?php

function connect($dbName)
{
    $dbLink = new mysqli('localhost', 'dev', 'Dev1234$', $dbName)
        or die("There is a problem connecting to the database");
    return $dbLink;
}

function insertPost($conn, $title, $teaser, $body, $author_id)
{
    $sql = "INSERT INTO posts(title,teaser, body, author_id) VALUES (?,?,?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssi', $title, $teaser, $body, intval($author_id));
        $stmt->execute();
        $stmt->close();
        $msg = "Successfully inserted {$title}. New record id is " . $conn->insert_id;
    } else {
        $msg = "Error inserting record";
    }

    return $msg;
}


function getLoggedInId($conn, $uName, $pWord)
{
    $sql = "SELECT id FROM login WHERE username = ? and password = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $uName, $pWord);
        $stmt->execute();
        $stmt->bind_result($id);
        $authId = 0;
        while ($stmt->fetch()) {
            $authId = $id;
        }
        $stmt->close();
        return $authId;
    }
}


function getAllPosts($conn)
{

    $sql = "SELECT id, title, teaser, body, author_id, post_date FROM posts";

    $stmt = $conn->prepare($sql) or die("Unable to select from the database");
    $stmt->execute();
    $stmt->bind_result($id, $title, $teaser, $body, $authId, $created_at);

    while ($row = $stmt->fetch()) {
        $item = array(
            'id' => $id,
            'title' => $title,
            'teaser' => $teaser,
            'body' => $body,
            'author_id' => $authId,
            'created_at' => $created_at
        );

        $rows[] = $item;
    }
    $stmt->close();
    return $rows;
}

function getAllPostsByAuthId($conn, $authId)
{
    $stmt = $conn->prepare("SELECT id, title, teaser, body, author_id FROM posts WHERE author_id = ?") or die("Unable to select from the database");
    $stmt->bind_param('i', intval($authId));
    $stmt->execute();
    $stmt->bind_result($id, $title, $teaser, $body, $authId);

    while ($row = $stmt->fetch()) {
        $item = array(
            'id' => $id,
            'title' => $title,
            'teaser' => $teaser,
            'body' => $body,
            'author_id' => $authId
        );

        $rows[] = $item;
    }

    $stmt->close();
    return $rows;
}
