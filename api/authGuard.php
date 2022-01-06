<?php
// This is an Auth Guard: it just protect a page from being accessed if the client isn't Authenticated

if (!isset($_SESSION)) {
    Session_start();
};
// check if i am Auth
if (!isset($_SESSION["AuthID"])) {
    header("location: login.php");
    die;
};

function clearSession()
{
    // Clear session
    $_SESSION = array();
    session_destroy();

    // Redirect -> login.php
    header("location: ../login.php");
}
