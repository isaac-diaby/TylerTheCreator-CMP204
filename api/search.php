<?php
require "authGuard.php";
// include DB connection file
require_once "conn.php";

// get the search string and clean it 
$searchString = "%" . cleanSQLInput($_GET['s']) . "%";

try {
    // get like terms from the DB and create the html template to send to the client
    //  . cleanSQLInput($_SESSION['AuthID']) . " ORDER BY likes DESC"
    $getSearchedSongsSQI = $conn->prepare("SELECT cmp204_songs.songID, cmp204_songs.title, cmp204_songs.album, cmp204_songs.likes, cmp204_songs.src, cmp204_liked.likeID AS liked FROM cmp204_songs left JOIN cmp204_liked ON cmp204_songs.songID = cmp204_liked.songID AND cmp204_liked.userID = " . cleanSQLInput($_SESSION['AuthID']) . " WHERE title LIKE ? OR album LIKE ? ORDER BY likes DESC");
    $getSearchedSongsSQI->bind_param("ss", $searchString, $searchString);
    if ($getSearchedSongsSQI->execute()) {
        $getSearchedSongsRS = $getSearchedSongsSQI->get_result();
        http_response_code(200);
        while ($song = mysqli_fetch_assoc($getSearchedSongsRS)) {
            include "../components/songCard.php";
        };
    } else {
        // ERR
        http_response_code(422);
    }
} catch (Exception $e) {
    die($e->getMessage());
}
exit;
