<?php
require "api/authGuard.php";
// include DB connection file
require_once "api/conn.php";

function loadMyLikedSongs(&$conn)
{
    try {
        // get all the songs that the user liked
        $getAllLikedSongsSQI = "SELECT cmp204_songs.title, cmp204_songs.album, cmp204_songs.src FROM cmp204_songs INNER JOIN cmp204_liked ON cmp204_songs.songID = cmp204_liked.songID WHERE cmp204_liked.userID = " . cleanSQLInput($_SESSION['AuthID']) . " ORDER BY likes DESC";
        $getAllLikedSongsRS = mysqli_query($conn, $getAllLikedSongsSQI);
        while ($song = mysqli_fetch_assoc($getAllLikedSongsRS)) {
            // populate the page liked components
            include "components/profileLikes.php";
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
    <link rel="stylesheet" href="./css/profile.css">
</head>

<body>
    <?php include "components/navbar.php" ?>
    <section class="legend coverScreen container">
        <div class="text-dark">
            <!-- Account info section + controls -->
            <div id="mainCard" class="card text-center border-dark">
                <div class="card-body ">
                    <h5 class="card-title">Hello <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "NULL"; ?> </h5>
                    <p class="card-text">
                        This is your personal page, you can see the songs you liked
                    </p>
                    <a href="songs.php" class="btn btn-primary mb-3">Go To Songs</a>
                    <!-- NAV: liked songs and settings -->
                    <ul class="nav nav-tabs card-header-tabs justify-content-center">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="likes-tab" data-bs-toggle="tab" data-bs-target="#likes" type="button" role="tab" aria-controls="likes" aria-selected="true">Likes</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Settings</button>
                        </li>
                    </ul>
                    <div class="tab-content mt-3">
                        <!-- User Likes Section -->
                        <div class="tab-pane fade show active" id="likes" role="tabpanel" aria-labelledby="likes-tab">
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <p class="col"><strong> Titile </strong></p>
                                            <p class="col"><strong> Album </strong></p>
                                            <p class="col"><strong> Action </strong></p>

                                        </div>
                                    </li>
                                    <?php loadMyLikedSongs($conn) ?>

                                </ul>
                            </div>
                            <?php // loadLikedSongs($conn);
                            ?>
                        </div>
                        <!-- User Settings Section -->
                        <div class="tab-pane fade " id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h4>Account Settings</h4>
                            <div class="actions">
                                <a href="api/logout.php" class="btn btn-danger mb-3">Log Out</a>
                                <a href="api/deleteaccount.php" class="btn btn-danger mb-3">Delete Account</a>
                            </div>

                        </div>
                    </div>




                </div>
                <div class="card-footer">
                    <small class="mb-0 text-muted"> Joind Date: <?php echo isset($_SESSION["joinDate"]) ? $_SESSION["joinDate"] : "NULL"; ?></p>
                </div>
            </div>

        </div>
    </section>
    <?php include "components/cookietoast.html" ?>
    <?php include "components/footer.html" ?>
    <script deferred src="js/index.js"></script>

</body>

</html>