<?php
// Allow the user to Auth by starting a session
Session_start();

// include DB connection file
require_once "api/conn.php";

// check if i am Auth
if (isset($_SESSION["AuthID"])) {
    header("location: profile.php");
    exit;
}
$payload = new stdClass();
$payload->errs = "";
$payload->step = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Post Request
    try {
        $email = $password = "";
        extract($_POST); // Extract data from the post assoc array 
        $email = cleanSQLInput($email);
        $password = cleanSQLInput($password);

        $payload->errs = "Incorrect email and Password";

        if (!empty($email) || !empty($password)) {
            $findaUserSQI = $conn->prepare("SELECT id, name, password, created_at FROM cmp204_users WHERE email = ? LIMIT 1");
            $findaUserSQI->bind_param("s", $email);
            $findaUserSQI->execute();
            $userDataRS = $findaUserSQI->get_result();
            if ($userDataRS->num_rows == 1) { // Emails are always unique
                // Found user data, now check if the password is correct
                $userData = $userDataRS->fetch_object();
                // print_r($userData);
                if (password_verify($password, $userData->password)) {
                    // Correct Password Login the User!
                    Session_start();
                    $_SESSION["AuthID"] = $userData->id;
                    $_SESSION["name"] = $userData->name;
                    $_SESSION["joinDate"] = $userData->created_at;
                    $findaUserSQI->close();
                    header("location: profile.php");
                    // exit;
                }
            }
        }
        $conn->close();
        // No user Found with that email or wrong password, throw errors
        throw new Exception($payload->errs);
    } catch (Exception $e) {
        $payload->errs = $e->getMessage();
    }
}

?>
<!doctype html>

<html lang="en">

<head>
    <?php include "components/sharedheader.html" ?>
    <link rel="stylesheet" href="./css/authPage.css">
</head>


<body>
    <?php include "components/navbar.php" ?>
    <section class="legend coverScreen">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs justify-content-center">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item">

                        <button class="nav-link" id="sign-tab" data-bs-toggle="tab" data-bs-target="#sign" type="button" role="tab" aria-controls="sign" aria-selected="false">Sign up</button>

                    </li>
                </ul>
            </div>
            <div class="card-body tab-content">
                <!-- Login Section -->
                <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <!-- Post to this file -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-end">
                            <label for="email" class="form-label me-md-1 text-md-end">Email:</label>
                            <input type="email" class="form-control flex-grow-1" id="email" maxlength="200" name="email" required>
                            <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                        </div>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-end">
                            <label for="password" class="form-label me-md-1 text-md-end">Password:</label>
                            <input type="password" class="form-control flex-grow-1" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <!-- TODO: Use Ajax to login and use some Jqurery to show the status of the request -->
                    </form>
                </div>
                <!-- Sign up Section -->
                <div class="tab-pane fade " id="sign" role="tabpanel" aria-labelledby="sign-tab">
                    <h5 class="mb-4">Create an account</h5>
                    <form>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-end">
                            <label for="name" class="form-label me-md-2 text-md-end">Name:</label>
                            <input type="text" class="form-control flex-grow-1" id="create-name" placeholder="John Doe" maxlength="200" required pattern="^[a-zA-Z-']*$" title="Only letters in the name are allowed." oninvalid="showStatusToast('Only letters in the name are allowed. ', 'error')">
                        </div>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-end">
                            <label for="email" class="form-label me-md-2 text-md-end">Email:</label>
                            <input type="email" class="form-control flex-grow-1" id="create-email" placeholder="example@example.com" maxlength="200" required>
                        </div>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-end">
                            <label for="password" class="form-label me-md-2 text-md-end">Password:</label>
                            <input type="password" class="form-control flex-grow-1" id="create-password" placeholder="Password" minlength="6" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$" title="Password must contain uppercase, lowercase, numeric and be more than five characters in length" required oninvalid="showStatusToast('Password must contain uppercase, lowercase, numeric and be more than five characters in length', 'error')">
                        </div>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-end">
                            <label for="confirm-password" class="form-label me-md-2 text-md-end">Confirm Password:</label>
                            <input type="password" class="form-control flex-grow-1" id="create-confirm-password" placeholder="Confirm Password" minlength="6">
                        </div>
                        <div class="fields mb-3 d-md-flex align-items-md-center flex-sm-column flex-md-row justify-content-md-start justify-content-sm-center">
                            <label for="privacyAcc" class="form-label me-md-2 text-md-end text-break" style="flex-basis: 76px;">Accept <a href="privacypolicy.php" target="_blank">T&C's</a>:</label>
                            <input type="checkbox" class="form-control form-check-input mx-auto " id="create-privacyAcc" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                        <button class="btn btn-primary visually-hidden" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <!-- Use Ajax to login and use some Jquery to show the status of the request -->
                    </form>
                </div>

            </div>
        </div>
    </section>
    <?php include "components/footer.html" ?>
    <?php include "components/cookietoast.html" ?>
    <?php include "components/statustoast.html" ?>
    <script deferred src="js/index.js"></script>
    <script deferred src="js/auth.js">
    </script>
    <script deferred>
        $(document).ready(function() {
            if (<?php echo empty($payload->errs) ? "false" : "true"; ?>) {
                showStatusToast("<?php echo $payload->errs; ?>", "error");
            }
            if (<?php echo isset($logged_out) ? "true" : "false"; ?>) {
                showStatusToast("Logged out!", "success");
            }
        })
    </script>

</body>

</html>