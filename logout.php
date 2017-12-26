<?php 
    session_start();
	
	define('title','Logged Out');
	
	session_unset();
	session_destroy();
	
	/*if (!$_SESSION['loggedIn']) {
		header("location: index.php");
	}*/
	
	include 'includes/header.php';
?>

	<h1>You've Logged Out</h1>
	<p class="lead">You're logged out of using the application.</p>
	<a href="index.php">Click here to login.</a>

<?php 
	include 'includes/footer.php';
?>