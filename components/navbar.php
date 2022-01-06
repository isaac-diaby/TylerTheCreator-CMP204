<?php if (!isset($_SESSION)) {
    Session_start();
} ?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a href="./index.php" class="navbar-brand" aria-label="Tyler: The creator">Tyler</a>
        <!-- Mobile Drop down view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="bi bi-list" role="img" aria-label="Toggle navigation Icon"></i></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <div class="navbar-nav ml-auto mb-2 mb-lg-0">

                <a <?php if ($_SERVER['SCRIPT_NAME'] == "/index.php") { ?> class="nav-link active" aria-current="page" href="#" <?php  } else {  ?> class="nav-link" href="index.php" <?php } ?>>Home
                </a>
                <a class="nav-link" target="_blank" rel="noopener noreferrer" href="req.html">Req</a>

                <!-- IF Auth show the profile link, else show the login link -->
                <?php if (isset($_SESSION["AuthID"])) { ?>
                    <a <?php if ($_SERVER['SCRIPT_NAME'] == "/songs.php") { ?> class="nav-link active" aria-current="page" href="#" <?php  } else {  ?> class="nav-link" href="songs.php" <?php } ?>>Songs
                    </a>
                    <a <?php if ($_SERVER['SCRIPT_NAME'] == "/profile.php") { ?> class="nav-link active" aria-current="page" href="#" <?php  } else {  ?> class="nav-link" href="profile.php" <?php } ?>>Profile</a>
                <?php } else { ?>
                    <a <?php if ($_SERVER['SCRIPT_NAME'] == "/login.php") { ?> class="nav-link active" aria-current="page" href="#" <?php  } else {  ?> class="nav-link" href="login.php" <?php } ?>>Login</a>

                <?php } ?>



            </div>
        </div>
    </div>
</nav>