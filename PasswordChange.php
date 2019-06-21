<?php 

	/*if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
	}*/

	//$userID = $_GET['user_id'];
	include ('include/connection.php');
	session_start();
	include ('include/functions.php');

	/*$query = "SELECT * FROM user WHERE user_id='$userID'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			$userFirstName = $row['user_firstname'];
			$userLastName = $row['user_lastname'];
			$userEmail = $row['user_email'];
			$password = $row['password'];
			$Address = $row['Address'];
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
	}*/

	if (isset($_POST['update'])) {
		//$userName = validateFormData($_POST["userName"]);
		$Email = validateFormData($_POST["email"]);
		//$clientPhone = validateFormData($_POST["clientPhone"]);
		$password_old = validateFormData($_POST["oldPassword"]);
		$password_current = validateFormData($_POST["newPassword"]);
		$passwordHash = password_hash($password_current,PASSWORD_DEFAULT);
		//$clientNotes = validateFormData($_POST["clientNotes"]);

		if ($password_old== $password_current) {
			$error="the new password cant be as the old one";
		}else{
			$_SESSION['userEmail']=$result = mysqli_query($conn,"SELECT user_email FROM user");
			$row = mysqli_fetch_assoc($_SESSION['userEmail']);
			$userEmail=$row['user_email'];
				$query="UPDATE user
			SET password='$passwordHash'
			WHERE user_email='$userEmail'";
					$result = mysqli_query($conn, $query);	
					if ($result) {
				header("Location: GrouBuy.php?alert=updatesuccess");
				//echo "password is updated";
			}else{
				echo "Error updating record: ".mysql_error();
			}
		}
		
	}
		mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Comptible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Password Change</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">	
</head>
<body>
<div class="container">
	<!--<a data-toggle="modal" data-target="#order"role="button" class="btn btn-danger btn-xs">make an order</a>-->
	<form id="PasswordChange" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		
		<?php echo $error; ?>
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
										<h4 class="modal-title">Change your password</h4>
									</div> 
									<div class="modal-body">
										<form>
											<div class="form-group" id="email">
											<label for="email" class="label label-primary label-medium">Email</label>
											<input type="email" name="email" id="email" placeholder="enter your email">
											</div>
											<div class="form-group" id="oldPassword">
											<label for="oldPassword" class="label label-primary">Old Password</label>
											<input type="password" name="oldPassword" id="oldPassword" placeholder="enter the old password">
											</div>
											<div class="form-group" id="newPassword">
											<label for="newPassword" class="label label-primary">New Password</label>
											<input type="password" name="newPassword" id="newPassword" placeholder="enter your new password">
											</div>
											<button type="submit" class="btn btn-success" name="update">Save</button>
											<button type="text" class="btn btn-default" data-dismiss="modal">Cancle</button>
										</form>
									</div>
								</div>
							</div>
	</form>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</html>