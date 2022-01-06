<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Post Request
    require "authGuard.php";
    // include DB connection file
    require_once "conn.php";
    try {
        $songID = cleanSQLInput($_POST['id']);
        $userID = cleanSQLInput($_SESSION['AuthID']);
        // Check user's current like status for this song
        $likes = getLikedSongs($conn, $userID, $songID);

        // start transaction
        $conn->begin_transaction();
        // print_r($likes);
        if (isset($likes)) {
            // This song is liked, So unlike it
            $updateSongLikesCountSubSQI = $conn->prepare("UPDATE cmp204_songs SET likes = likes - 1 WHERE songID = ?;");
            $updateSongLikesCountSubSQI->bind_param("i", $songID);
            $deleteLikeRefSQI = $conn->prepare("DELETE FROM cmp204_liked WHERE likeID = ?;");
            $deleteLikeRefSQI->bind_param("i", $likes[0][0]);
            if ($updateSongLikesCountSubSQI->execute() && $deleteLikeRefSQI->execute()) {
                echo "Successfully Unliked";
            }
        } else {
            // This song is not liked, So like it
            $updateSongLikesCountAddSQI = $conn->prepare("UPDATE cmp204_songs SET likes = likes + 1 WHERE songID = ?;");
            $updateSongLikesCountAddSQI->bind_param("i", $songID);
            $addLikeRefSQI = $conn->prepare("INSERT INTO cmp204_liked (songID, userID) VALUES (?, ?);");
            $addLikeRefSQI->bind_param("ii", $songID, $userID);
            if ($updateSongLikesCountAddSQI->execute() && $addLikeRefSQI->execute()) {
                echo "Successfully Liked";
            }
        }
        $conn->commit();
    } catch (mysqli_sql_exception $e) {
        // Didnt do all the changes, restore changes
        $conn->rollback();
        die($e->getMessage());
    } catch (Exception $e) {
        // error
        die($e->getMessage());
    }
}

// get all the songs this user liked
function getLikedSongs(&$conn, &$userID, $id = FALSE)
{
    if ($id != FALSE) {
        $getLikedSongsSQI = $conn->prepare("SELECT likeID, songID FROM cmp204_liked WHERE userID = ? AND songID = ? LIMIT 1");
        $getLikedSongsSQI->bind_param("si", $userID, $id);
    } else {
        $getLikedSongsSQI = $conn->prepare("SELECT likeID, songID FROM cmp204_liked WHERE userID = ?");
        $getLikedSongsSQI->bind_param("s", $userID);
    }
    if ($getLikedSongsSQI->execute()) {
        $getLikedSongsRS = $getLikedSongsSQI->get_result();
        $likes = mysqli_fetch_all($getLikedSongsRS);
        if (!empty($likes)) {
            return $likes;
        } else {
            // nothing found
            return;
        }
    }
}
exit;
