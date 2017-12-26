<?php 
	session_start();
	define('title','Add Clients');
	if (!$_SESSION['loggedIn']) {
		header("location: index.php");
	}
	include 'includes/connection.php';
	include 'includes/functions.php';

	$userID = $_SESSION['email'];
	
	if (isset($_POST['add'])) {

		$clientName = $clientEmail = $clientPhone = $clientAddress = $clientCompany = $clientNote = "";
		
		if ( !$_POST['clientName'] ) {
			$nameErr = "<div class='alert alert-warning'>Please enter a Valid Name</div>";} else {$clientName = validateFormData( ucwords($_POST['clientName']) );}
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
			$sql = "INSERT into clients (id,name,email,phone,address,company,notes,date_added,user) VALUES 
			(null, '$clientName', '$clientEmail', '$clientPhone', '$clientAddress', '$clientCompany', '$clientNote', CURRENT_TIMESTAMP, '$userID')";
			$result = mysqli_query($conn,$sql);
			if ($result) {
				header('location: client.php?alert=success');
			} else {
				$err = "<div class='alert alert-danger'>Error - ".mysqli_error($conn).".<a class='close' data-dismiss='alert'>&times;</a></div>";
			}
		}
	}
	//Close connection
	mysqli_close($conn);
	include 'includes/header.php';
?>
	<h1>Add Clients</h1>
	<?php echo $msgErr; ?>
	<?php echo $mailErr; ?>
	<?php echo $phoneErr; ?>
	<?php echo $addressErr; ?>
	<?php echo $companyErr; ?>
	<?php echo $notesErr; ?>
	<form action="<?php echo htmlspecialchars( $_SERVER ['PHP_SELF'] ); ?>" method="post" class="row">
		<div class="form-group col-sm-6">
			<label for="client-name">Name:</label>
			<input required type="text" class="form-control input-lg" id="client-name" name="clientName" value="">
		</div>
		<div class="form-group col-sm-6">
			<label for="client-email">Email:</label>
			<input required type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="">
		</div>
		<div class="form-group col-sm-6">
			<label for="client-phone">Phone:</label>
			<input required type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="">
		</div>
		<div class="form-group col-sm-6">
			<label for="client-address">Address:</label>
			<input required type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="">
		</div>
		<div class="form-group col-sm-6">
			<label for="client-company">Company:</label>
			<input required type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="">
		</div>
		<div class="form-group col-sm-6">
			<label for="client-note">Notes:</label>
			<textarea required type="text" class="form-control input-lg" id="client-note" name="clientNote" value=""></textarea>
		</div>
		<div class="col-sm-12">
			<a href="client.php" class="btn btn-lg btn-default">Cancel</a>
			<button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
		</div>
	</form>

<?php include 'includes/footer.php'; ?>