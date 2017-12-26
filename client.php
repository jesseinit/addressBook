<?php 
	session_start();
	
	define('title','My Dashboard');
	
	if (!$_SESSION['loggedIn']) {
		header("location: index.php");
	}

	include 'includes/connection.php';
	$userID = $_SESSION['email'];
	$sql = "SELECT * from clients where user='$userID'";
	$result = mysqli_query($conn, $sql);

	if (isset($_GET['alert'])) {
		if ($_GET['alert'] === "success") {
			$alertMessage = "<div class='alert alert-success'>New Client Added! <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
		if ($_GET['alert'] === "updated") {
			$alertMessage = "<div class='alert alert-success'>Client Info Updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
		if ($_GET['alert'] === "deleted") {
			$alertMessage = "<div class='alert alert-danger'>Client Deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
	}

	include 'includes/header.php';
?>

	<h1>Clients Address Book</h1>
	<?php echo $alertMessage; ?>

	<table class="table table-striped table-bordered">
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>Phone</th>
			<th>Address</th>
			<th>Company</th>
			<th>Notes</th>
			<th>Action</th>
		</tr>
		<?php 
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>".$row['name']."</td>"."<td>".$row['email']."</td>"."<td>".$row['phone']."</td>"."<td>".$row['address']."</td>";
					echo '<td>'.$row['company']."</td>"."<td>".$row['notes']."</td>";
					echo '<td><a href="edit.php?id='.$row['id'].'" type="button" class="btn btn-default btn-primary btn-sm">Edit</a></td>'; 
					echo "</tr>";
				}
			} else {
				echo "<div class='alert alert-warning'>No Record of Clients Present!</div>";
			}
			mysqli_close($conn);
		?>
		<tr>
			<td colspan="8">
				<div class="text-center"><a href="add.php" type="button" class="btn btn-default btn-success btn-lg">Add Clients</a></div>
			</td>
		</tr>
	</table>

<?php 
	include 'includes/footer.php';
?>