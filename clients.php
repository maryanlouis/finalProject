<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
	header("Location: GrouBuy.php");
}

include ('includes/connection.php'); 

$query="SELECT * FROM clients";
$result = mysqli_query($conn, $query);
if (isset($_GET['alert'])) {
	if ($_GET['alert']=='success') {
		$alertMessage = "<div class='alert alert-success'>New client added!<a class='close' data-dismiss='alert'>&times;</a></div>";
	}elseif ($_GET['alert'] == 'updatesuccess') {
		$alertMessage = "<div class='alert alert-success'>Client updated!<a class='close' data-dismiss='alert'>&times;</a></div>";
	}elseif ($_GET['alert'] == 'deleted') {
		$alertMessage = "<div class='alert alert-success'>Client deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
}
mysqli_close($conn);
//include ('includes/header.php'); 

?>

<h1>Client Address Book</h1>

<?php echo $alertMessage; ?>
<table class="table table-striped table-bordered">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Company</th>
		<th>Note</th>
		<th>Edit</th>
	</tr>
	<?php 
		if (mysqli_num_rows($result)>0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>".$row['user_firstname']."</td><td>".$row['user_email']."</td><td>".$row['address']."</td>";

				echo '<td><a href="edit.php?id='.$row['id'].'" type="button" class="btn btn-primary btn-sm">
				<span class="glyphicon glyphicon-edit"></span>
				</a></td>';
				echo "</tr>";
			}
		}else{
			echo "<div class='alert alert-warning'>You have no clients!</div>";
		}

		mysqli_close($conn);
	?>
	<tr>
		<!--<td>John</td>
		<td>john@doe.com</td>
		<td>(123) 456-7890</td>
		<td>111 Address Street, Calgary, AB TIG 2KY</td>
		<td>Brighside Studios Inc.</td>
		<td>Usually pays early. He's awesome.</td>
		<td><a href="edit.php" type="button" class="btn btn-default btn-primary btn-sm"></a></td>
		<td><span class="glyphicon glyphicon-edit"></span></td>
	</tr>
	<tr>
		<td>Jane</td>
		<td>janen@doe.com</td>
		<td>(123) 456-7890</td>
		<td>111 Address Street, Calgary, AB TIG 2KY</td>
		<td>Brighside Studios Inc.</td>
		<td>Usually pays early. He's awesome.</td>
		<td><a href="edit.php" type="button" class="btn btn-default btn-primary btn-sm"></a></td>
		<td><span class="glyphicon glyphicon-edit"></span></td>-->
		<td class="?"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus">Add Client</span></a></div></td>
	</tr>
</table>

<?php include ('includes/footer.php'); ?>