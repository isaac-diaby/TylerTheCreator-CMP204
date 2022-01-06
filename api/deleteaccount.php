<?php
require "authGuard.php";
// include DB connection file
require_once "conn.php";
try {
    $cleanID = mysqli_real_escape_string($conn, $_SESSION["AuthID"]);
    // Get the currently Auth user ID and delete it from the database + all liked songs by the user + cleaning the session
    $deleteAccountLikedSongsSQI = "DELETE FROM cmp204_liked WHERE userID = " . $cleanID;
    mysqli_query($conn, $deleteAccountLikedSongsSQI);
    $deleteAccountSQI = $conn->prepare("DELETE FROM cmp204_users WHERE id = ?");
    $deleteAccountSQI->bind_param("s", $cleanID);
    if ($deleteAccountSQI->execute()) {
        http_response_code(200);
        clearSession();
    } else {
        die($deleteAccountSQI->error_get_last);
    }
} catch (Exception $e) {
    die($e->getMessage());
}


exit;
