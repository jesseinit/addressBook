<?php 
	session_start();
	
	define('title','Edit Clients');
	
	if (!$_SESSION['loggedIn']) {
		header("location: index.php");
	}
	
	include 'includes/connection.php';
	include 'includes/functions.php';

	$clientID = $_GET['id'];
	
	$sql = "SELECT * FROM clients WHERE id='$clientID'";
	
	$result = mysqli_query($conn, $sql);

	if (isset($_POST['update'])) {
		$clientName = $clientEmail = $clientPhone = $clientAddress = $clientCompany = $clientNote = "";
		
		if ( !$_POST['clientName'] ) {
			$nameErr = "<div class='alert alert-warning'>Please enter a Valid Name</div>";} else {$clientName = validateFormData( $_POST['clientName'] );}
		if ( !filter_var( $_POST['clientEmail'], FILTER_VALIDATE_EMAIL ) ) {
			$mailErr = "<div class='alert alert-warning'>Please enter a Valid Email!</div>";} else {$clientEmail = validateFormData( $_POST['clientEmail'] );}
		if ( !is_numeric($_POST['clientPhone']) ) {
			$phoneErr = "<div class='alert alert-warning'>Please enter a Valid Phone Number</div>";} else {$clientPhone = validateFormData($_POST['clientPhone']);}
		if ( !$_POST['clientAddress'] ) {
			$addressErr = "<div class='alert alert-warning'>Please enter an Address!</div>";} else {$clientAddress = validateFormData($_POST['clientAddress']);}
		if ( !$_POST['clientCompany'] ) {
			$companyErr = "<div class='alert alert-warning'>Please enter a Valid Company Name</div>";} else {$clientCompany = validateFormData($_POST['clientCompany']);}
		if ( !$_POST['clientNote'] ) {
			$notesErr = "<div class='alert alert-warning'>Please enter an Address!</div>";} else {$clientNote = validateFormData($_POST['clientNote']);}

		if ($clientName && $clientEmail && $clientPhone && $clientAddress && $clientCompany && $clientNote ) {
			$sql = "UPDATE clients 
					SET name = '$clientName', 
					email = '$clientEmail', 
					phone = '$clientPhone', 
					address = '$clientAddress',
					company = '$clientCompany', 
					notes = '$clientNote'
					WHERE id = '$clientID'";
			$result = mysqli_query($conn,$sql);
			if ($result) {
				header('location: client.php?alert=updated');
			} else {
				$err = "<div class='alert alert-danger'>Error - ".mysqli_error($conn)."</div>";
			}
		}
	} /* End of Update Code*/

	if (isset($_POST['delete'])) {
		$deleteAlert = 
		"<div class='alert alert-danger'>
			<p>Are you sure you want to Delete this Client's Record? No Takebacks!</p><br>
			<form action='". htmlspecialchars( $_SERVER ['PHP_SELF'] ) ."?id=$clientID' method='post'>
				<input type='submit' class='btn btn-sm btn-danger' name='confirm-delete' value='Yes! Delete.'>
				<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>No, Not Yet!</a>
			</form>
		</div>";
	}
	
	if (isset( $_POST['confirm-delete'] )) {
		$sql = "DELETE FROM clients WHERE id='$clientID'";
		$result = mysqli_query($conn, $sql);
		if ($result) {
			header('location: client.php?alert=deleted');
		} else {
			$err = "<div class='alert alert-danger'>Error - ".mysqli_error($conn)."</div>";
		}
	}

	//Close connection
	mysqli_close($conn);
	include 'includes/header.php';

?>

	<h1>Edit Clients</h1>
		<?php echo $err; ?>
		<?php echo $mailErr; ?>
		<?php echo $phoneErr; ?>
		<?php echo $addressErr; ?>
		<?php echo $companyErr; ?>
		<?php echo $notesErr; ?>
		<?php echo $deleteAlert; ?>

	<?php 
		if (mysqli_num_rows($result) > 0) {
			while ( $row = mysqli_fetch_assoc($result) ) {
				$clientName = $row['name'];
				$clientEmail = $row['email'];
				$clientPhone = $row['phone'];
				$clientAddress = $row['address'];
				$clientCompany = $row['company'];
				$clientNote = $row['notes'];
			}
	?>
		<form action="<?php echo htmlspecialchars( $_SERVER ['PHP_SELF'] ); ?>?id=<?php echo $clientID; ?>" method="post" class="row">
			<div class="form-group col-sm-6">
				<label for="client-name">Name:</label>
				<input required type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $clientName; ?>">
			</div>
			<div class="form-group col-sm-6">
				<label for="client-email">Email:</label>
				<input required type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $clientEmail; ?>">
			</div>
			<div class="form-group col-sm-6">
				<label for="client-phone">Phone:</label>
				<input required type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $clientPhone; ?>">
			</div>
			<div class="form-group col-sm-6">
				<label for="client-address">Address:</label>
				<input required type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $clientAddress; ?>">
			</div>
			<div class="form-group col-sm-6">
				<label for="client-company">Company:</label>
				<input required type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $clientCompany; ?>">
			</div>
			<div class="form-group col-sm-6">
				<label for="client-note">Notes:</label>
				<textarea required type="text" class="form-control input-lg" id="client-note" name="clientNote"><?php echo $clientNote; ?></textarea>
			</div>
			<div class="col-sm-12">
				<hr>
				<button type="submit" class="btn btn-lg btn-danger" name="delete">Delete</button>
				<div class="pull-right">
					<a href="client.php" class="btn btn-lg btn-default">Cancel</a>
					<button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
				</div>
			</div>
		</form>
	<?php 
		} else { 
		$alertMessage = "<div class='alert alert-danger'>User Doesn't Exits!</div>";
		echo($alertMessage);
		}
	?>

<?php 
	include 'includes/footer.php';
?>