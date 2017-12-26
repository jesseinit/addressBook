<?php
	session_start();

	define('title','Login');
	
	include 'includes/header.php';
	
	if ($_SESSION['loggedIn']) {
		header("location: client.php");
	}

	if (isset( $_POST['login'] ) ) {

		include 'includes/functions.php';
		
		$formEmail = validateFormData($_POST['login-email']);
		$formPass = validateFormData($_POST['login-password']);
		
		include 'includes/connection.php';

		// Query
		$sql = "SELECT * FROM users WHERE email = '$formEmail'";
		$result = mysqli_query($conn, $sql);

		// Check no of rows
		if (mysqli_num_rows($result) == 1) {
			//Store what the results returns
			while ( $row = mysqli_fetch_assoc($result) ) {
				$name = $row['name'];
				$pass = $row['password'];
				$email = $row['email'];
			}
			if ($formPass === $pass) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['user'] = $name;
				$_SESSION['email'] = $email;
				header("location: client.php");
			} else {
				$loginErr = "<div class='alert alert-danger'>Login Failed!<a class='close' data-dismiss='alert'>&times;</a></div>";
			}
		} else {
			$loginErr = "<div class='alert alert-danger'>Login Failed! <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
		//Close connection
		mysqli_close($conn);
	}

?>
	<h1 class="text-center">Client's Address Book</h1>
	<p class="text-center text-primary lead">A web-based tiny tool used to store addresses and information of your clients <br> and stay productive and organized as possible.</p>
	<h3 class="lead text-center">Log in to your account.</h3>
	<div class="form-container">
		<?php echo $loginErr; ?>
		<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<div class="form-group">
				<label for="login-email">Email:</label>
				<input type="text" class="form-control input-lg" id="login-email" name="login-email" placeholder="E-mail" required>
			</div>
			<div class="form-group">
				<label for="login-password">Password:</label>
				<input type="password" class="form-control input-lg" id="login-password" name="login-password" placeholder="Password" required>
			</div>
			<button type="submit" class="btn btn-primary btn-lg pull-right" name="login">Login</button>
		</form>
		<a href="signup.php" style="margin-top: 20px;" class="text-center">Don't an Account? SignUp Here</a>
	</div>
<?php 
	include 'includes/footer.php';
?>