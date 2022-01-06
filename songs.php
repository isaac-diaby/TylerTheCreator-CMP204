<?php
require "api/authGuard.php";

// include DB connection file
require_once "api/conn.php";

// get all the songs + if this user liked it or not
function loadTopSongs(&$conn)
{
    try {
        $getAllSongsTopSQI = "SELECT cmp204_songs.songID, cmp204_songs.title, cmp204_songs.album, cmp204_songs.likes, cmp204_songs.src, cmp204_liked.likeID AS liked FROM cmp204_songs left JOIN cmp204_liked ON cmp204_songs.songID = cmp204_liked.songID AND cmp204_liked.userID = " . cleanSQLInput($_SESSION['AuthID']) . " ORDER BY likes DESC";
        $getAllSongsTopRS = mysqli_query($conn, $getAllSongsTopSQI);
        while ($song = mysqli_fetch_assoc($getAllSongsTopRS)) {
            // print_r($song);
            // populate the songCard components
            include "components/songCard.php";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function loadLikedSongs(&$conn)
{
    try {
        // get all the songs that i liked
        //  17 ORDER BY likes DESC
        $getAllLikedSongsSQI = "SELECT cmp204_songs.songID, cmp204_songs.title, cmp204_songs.album, cmp204_songs.likes, cmp204_songs.src, cmp204_liked.likeID AS liked FROM cmp204_songs INNER JOIN cmp204_liked ON cmp204_songs.songID = cmp204_liked.songID WHERE cmp204_liked.userID = " . cleanSQLInput($_SESSION['AuthID']) . " ORDER BY likes DESC";
        $getAllLikedSongsRS = mysqli_query($conn, $getAllLikedSongsSQI);
        while ($song = mysqli_fetch_assoc($getAllLikedSongsRS)) {
            // print_r($song);
            // populate the songCard components
            include "components/songCard.php";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>
<!doctype html>

<html lang="en">

<head>
    <?php include "components/sharedheader.html" ?>
    <link rel="stylesheet" href="./css/songs.css">
    <link rel="stylesheet" href="./css/songCard.css">
</head>

<body>
    <?php include "components/navbar.php" ?>
    <section class="legend container">
        <div class="input-group my-5">
            <input id="searchInput" type="text" class="form-control" placeholder="Search Tyler, the Creator" aria-label="Search Tyler, the Creator" aria-describedby="button-addon2">
            <button id="searchBtn" class="btn btn-outline-secondary" type="button">Search</button>
        </div>
        <article id="searchResults">
            <h3>Results</h3>
            <!-- Add the search results here  -->
            <div class="spotlight"></div>
        </article>
        <article id="mostLikes">
            <h3>Most Likes</h3>
            <!-- Add the top songs here decending order -->
            <div class="spotlight">
                <?php loadTopSongs($conn) ?>
            </div>
        </article>
        <article id="songsLiked">
            <h3>Liked Songs</h3>
            <!-- Add the top songs here decending order -->
            <div class="spotlight">
                <?php loadLikedSongs($conn) ?>
            </div>
        </article>
    </section>
    <?php include "components/cookietoast.html" ?>
    <?php include "components/statustoast.html" ?>
    <?php include "components/footer.html" ?>
    <script deferred src="js/index.js"></script>
    <script deferred src="js/search.js"></script>

</body>

</html>