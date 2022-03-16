<?php

// DATABASE Creds
define('DB_HOST', 'Lochnagar.abertay.ac.uk');
define('DB_USERNAME', '********');
define('DB_PASSWORD', '********');
define('DB_NAME', 's********');

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check conn
if ($conn->connect_error) {
    die("Error: Cant connect to the DB server " . mysqli_connect_error());
} else {
    // Set up the Tables 
    $createUserSQITable = "CREATE TABLE IF NOT EXISTS cmp204_users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";
    $createSongsSQITable = "CREATE TABLE IF NOT EXISTS cmp204_songs (
    songID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    album VARCHAR(255) NOT NULL,
    likes INT UNSIGNED NOT NULL DEFAULT 0,
    src VARCHAR(255) NOT NULL
)";
    // Adding new Songs INSERT INTO `cmp204_songs` (`title`, `album`, `likes`, `src`) VALUES ('Yonkers', 'Goblin', '10000', 'https://www.youtube.com/watch?v=XSbZidsgMfw');
    $createLikedSQITable = "CREATE TABLE IF NOT EXISTS cmp204_liked (
    likeID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    songID INT NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (songID) REFERENCES cmp204_songs(songID),
    FOREIGN KEY (userID) REFERENCES cmp204_users(id)
)";
    try {
        mysqli_query($conn, $createUserSQITable);
        mysqli_query($conn, $createSongsSQITable);
        mysqli_query($conn, $createLikedSQITable);

        // echo "Database is set up";
    } catch (Exception $e) {
        echo "Skipped set up";
    }
};


/**
 * Clean the user input!
 */
function cleanSQLInput($input)
{
    $input = trim($input);
    if (empty($input)) {
        return false;
    }
    return mysqli_real_escape_string($GLOBALS['conn'], stripslashes(htmlspecialchars($input)));
};
