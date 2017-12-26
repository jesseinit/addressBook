<?php
	session_start();

	define('title','Sign Up');
	session_destroy();

	include 'includes/connection.php';
	include 'includes/functions.php';

	if (isset($_POST['signup'])) {

		//Validate Form
		$sName = $sEmail = $sPassword = $sConfirmPassword = "";
		if ( !$_POST['signup-name'] )
		{
			$nameErr = "<div class='alert alert-warning'>Please enter a Valid Name <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
		else
		{
			$sName = validateFormData( ucwords( $_POST['signup-name'] ) );
		}

		if ( !filter_var( $_POST['signup-email'], FILTER_VALIDATE_EMAIL ) ) {
			$mailErr = "<div class='alert alert-warning'>Please enter a Valid Email! <a class='close' data-dismiss='alert'>&times;</a></div>";
		} else {$sEmail = validateFormData($_POST['signup-email'] ); }

		if ( !$_POST['signup-password'] ) {
			$passErr = "<div class='alert alert-warning'>Please enter an Password! <a class='close' data-dismiss='alert'>&times;</a></div>";
		} else {$sPassword = validateFormData($_POST['signup-password']);}

		if ( !$_POST['signup-confrimPassword'] ) {
			$passErr = "<div class='alert alert-warning'>Verify Password Cant Be Empty <a class='close' data-dismiss='alert'>&times;</a></div>";
		} else {$sConfirmPassword = validateFormData($_POST['signup-confrimPassword']);}

		if ($sName && $sEmail && $sPassword && $sConfirmPassword ) {
			// Confirming passwords match
			if ($sPassword === $sConfirmPassword) {
				//Checking to see if email exists in the db
				$sql = "SELECT * FROM users where email = '$sEmail'";
				$result = mysqli_query($conn, $sql);
					//Query db to find number of users with specified email
					if (mysqli_num_rows($result) == 0) {
						//Email doesn't exists so create new user
						$sql = "INSERT INTO users (id,email,password,name) VALUES (null,'$sEmail', '$sConfirmPassword', '$sName')";
						$result = mysqli_query($conn, $sql);
						if ($result) {
							header('location: signup.php?alert=success');
							$signupErr = "<div class='alert alert-success'>User has been Created Successfully! <a class='close' data-dismiss='alert'>&times;</a></div>";
						} else {
							$signupErr = "<div class='alert alert-danger'>Error - ".mysqli_error($conn).".<a class='close' data-dismiss='alert'>&times;</a></div>";
						}
					} else {
						//Email already exist so you cant proceede.
						$signupErr = "<div class='alert alert-danger'>User with such Email Exists! <a class='close' data-dismiss='alert'>&times;</a></div>";
					}
			} else {
				$signupErr = "<div class='alert alert-danger'>Passwords doesn't Match Up. <a class='close' data-dismiss='alert'>&times;</a></div>";
			}
		}
	}

	include 'includes/header.php';
?>
	<h1 class="text-center">Client's Address Book</h1>
	<p class="lead text-center">Want to stay organised? Sign up for an account.</p>
	<div class="form-container">
		<?php echo $nameErr; ?>
		<?php echo $mailErr; ?>
		<?php echo $passErr; ?>
		<?php
			if (!isset($_GET['alert'])) {
		?>
		<form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<div class="form-group">
				<label for="signup-name">Name:</label>
				<input type="text" class="form-control" id="signup-name" name="signup-name" placeholder="Enter your Name" required>
			</div>
			<div class="form-group">
				<label for="signup-email">Email:</label>
				<input type="text" class="form-control" id="signup-email" name="signup-email" placeholder="E-mail" required>
			</div>
			<div class="form-group">
				<label for="signup-password">Password:</label>
				<input type="password" class="form-control" id="signup-password" name="signup-password" placeholder="Password" required>
			</div>
			<div class="form-group">
				<label for="signup-password">Confirm Password:</label>
				<input type="password" class="form-control" id="signup-password" name="signup-confrimPassword" placeholder="Verify Password" required>
			</div>
			<button type="submit" class="btn btn-primary pull-right" name="signup">Create Account</button>
		</form>
		<a href="index.php" style="margin-top: 20px;" class="text-center">Already have an Account? Login Here</a>
		<?php
			} else {
				if ($_GET['alert'] === "success") {
					$signupErr = "<div class='alert alert-success text-center'>User has been Created Successfully!</div>";
					$a = "<a href='index.php' style='margin-top: 20px;' class='text-center'>Login Here</a>";
					echo $signupErr;
					echo $a;
				}
			}
		?>
	</div>


<?php include 'includes/footer.php'; ?>
