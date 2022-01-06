<?php
// include DB connection file
require_once "conn.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") { // MAKE SURE ITS THE RIGHT REQUST METHOD
    try {

        $name = $email = $cPassword = "";
        http_response_code(422); // start off by expecting an error but this will change to a 200 when every thing has gone through

        $json_data = json_decode(file_get_contents('php://input'), true); // get the raw json data as an array map not a stdClass
        extract($json_data); // Extract the form data into thier own variable 
        $name = cleanSQLInput($name);
        $email = cleanSQLInput($email);
        $cPassword = cleanSQLInput($cPassword);

        $payload = new stdClass();
        $payload->errs = "";

        if (!isset($name) || !preg_match("/^[a-zA-Z-']*$/", $name)) {
            $payload->errs .= "Only letters in the name are allowed. ";
        } elseif (!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $payload->errs .= "Invalid Email. ";
        } elseif ((!isset($cPassword) || !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$/", $cPassword))) {
            $payload->errs .= "Invalid Passwords. ";
        }
        if ($payload->errs == "") {
            // Everything is good try to create the account!
            $hash_salted_passw = password_hash($cPassword, PASSWORD_BCRYPT, [
                'cost' => 10,
            ]); // hash and salt

            /**
             * I could of checked if the email was already in use here, however im handling the dupli error here and on the client side too 
             */
            $createUserSQI = $conn->prepare("INSERT INTO cmp204_users (name, email, password) VALUES(?, ?, ?)");
            $createUserSQI->bind_param("sss", $name, $email, $hash_salted_passw);
            if ($createUserSQI->execute()) {
                // $_SESSION["AuthID"] = $createUserSQI;
                $payload->errs = false;
                http_response_code(200);
            } else {
                $payload->errs = $createUserSQI->error_get_last;
            }
            //  Clean up connections and statement
            $createUserSQI->close();
            mysqli_close($conn);
        } else {
            die($payload->errs);
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    http_response_code(400);
    print_r($_POST);
    echo "Error: try posting here";
}
