<!doctype html>

<html lang="en">

<head>
	<?php include "components/sharedheader.html" ?>
	<link rel="stylesheet" href="./css/home.css">
</head>

<body>
	<?php include "components/navbar.php" ?>
	<section class="container legend">
		<article class="headline mt-lg-5 pt-lg-5 mt-md-4 mt-sm-4 mt-xl-5 pt-xl-5">
			<h1>Tyler: The Creator</h1>
			<p>Welcome to a <strong>OFWGKTA</strong> fan project. This site is a fan app that allows people to rate their favorite songs by Tyler: The Creator!</p>
			<p>Also know as: Tyler Gregory Okonma, Wolf Haley, Goblin, Bucket Hat T, Gap Tooth T</p>
		</article>
		<article class="d-none d-sm-block">
			<img src="./img/legend_tyler.png" class="img-fluid" alt="Image of Tyler in a cartoon art style">
		</article>
	</section>
	<section class="container mt-lg-5  mt-md-4 mt-sm-5 mt-5">
		<h1 class="text-center mb-4">How Does It Work?</h1>
		<div class="steps text-black row row-cols-lg-3 row-cols-md-2 row-cols-sm-1">
			<!--  Steps to use the app-->
			<div class="step">
				<div class="card bg-dark text-white">
					<div class="card-header text-center">
						Step 1
					</div>
					<img src="img/createAcc.png" class="card-img-top img-fluid" alt="Register form">
					<div class="card-body">
						<h5 class="card-title"> Create an Account</h5>
						<p class="card-text">Begin by create an account so you can have access to the full platform.</p>
						<a href="login.php" class="btn btn-success">Create Account</a>
					</div>
				</div>
			</div>
			<div class="step">
				<div class="card bg-dark text-white">
					<div class="card-header text-center">
						Step 2
					</div>
					<img src="img/loginAcc.png" class="card-img-top img-fluid" alt="Login form">
					<div class="card-body">
						<h5 class="card-title">Login</h5>
						<p class="card-text">Authenticate yourself by logging into the platform with your credentials, or with the test account: E: "test@test.com", P: "Test12".</p>
						<a href="login.php" class="btn btn-success">Login</a>
					</div>
				</div>
			</div>
			<div class="step">
				<div class="card bg-dark text-white">
					<div class="card-header text-center">
						Step 3
					</div>
					<img src="img/searchSongs.png" class="card-img-top img-fluid" alt="Search songs page">
					<div class="card-body">
						<h5 class="card-title">Go To Songs</h5>
						<p class="card-text"> Your all set, how you can search your for a song by Tyler: The Creator and add your favorites to your library.</p>
						<a href="songs.php" class="btn btn-success">Find Songs</a>
					</div>
				</div>
			</div>
			<div class="step">
				<div class="card bg-dark text-white">
					<div class="card-header text-center">
						Step 4
					</div>
					<img src="img/settingsAcc.png" class="card-img-top img-fluid" alt="Accountpage">
					<div class="card-body">
						<h5 class="card-title">Account Page</h5>
						<p class="card-text">When you Done you can log out or delete your account.</p>
						<a href="songs.php" class="btn btn-success">My Profile</a>
					</div>
				</div>
			</div>
		</div>

	</section>


	<?php include "components/footer.html" ?>
	<?php include "components/cookietoast.html" ?>
	<script deferred src="js/index.js"></script>

</body>

</html>