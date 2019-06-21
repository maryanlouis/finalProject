<?php

	include ('include/connection.php');
	session_start();

	include ('include/functions.php');
	if (isset($_POST['login'])) {
		$formEmail = validateFormData($_POST['email']);
		$formPass = validateFormData($_POST['password']);

		//include ('includes/connection.php');
		$query = "SELECT user_firstname, user_lastname, password FROM user WHERE email='$formEmail'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$firstname = $row['user_firstname'];
				$lastname = $row['user_lastname'];
				$hashedPass = $row['password'];
			}

			if (password_verify($formPass, $hashedPass)) {
				$_SESSION['loggedInUser'] = $firstName;

				header("Location: GrouBuy.php");
			}else{
				$loginError= "<div class='alert alert-danger'>Wrong username / password combination. Try again</div>";
			}

		}else{
			$loginError= "<div class='alert alert-danger'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
		}
	}
	
	mysqli_close($conn);
	//include ('includes/header.php');

	//$password = password_hash("abc123", PASSWORD_DEFAULT);
	//echo $password;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Comptible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Groubuy.com</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">	
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<a class="navbar-brand" href="GrouBuy.php">GrouBuy</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="GrouBuy.php">Home</a></li>
					<li><a data-toggle="modal" data-target="#account">Account</a></li>
					<li><a data-toggle="modal" data-target="#store">Current Offers</a></li>
					<li><a href="wishes.php">Wishes</a></li>
					<li><a href="deals.php">Deals</a></li>
					<li><a href="forum.php">Forum</a></li>
					<li><a href="info.html">Contact us</a></li>
					<?php echo $formEmail;?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="cover">
		<div class="cover-text">
			<h1>GrouBuy</h1>
			<p class="lead">We gurantee minimum cost maximum quality.</p>
			<a data-toggle="modal" data-target="#store" role="button" class="btn btn-danger btn-lg">Let's get started.</a>
		</div>
	</div>
	<form class="modal fade" id="account">
			                      <!--modal-sm-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title">User Account</h4>
					</div> 
						<div class="modal-body">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#logIn">Already have an account?</button>
							<a type="button" class="btn btn-primary" href="signUp.php">First time?</a>
						</div>
						<div class="modal-footer">
							<button type="text" class="btn btn-default" data-dismiss="modal">Cancle</button>
						</div>
				</div>
			</div>
		</form>
		<form class="modal fade" id="logIn" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
			                      <!--modal-sm-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title">Log In</h4>
						<?php echo $loginError;?>
					</div> 
						<div class="modal-body">
							<form>
								<div class="form-group" id="email">
									<label>Email</label>
									<input type="text" placeholder="name@mail.com" name="email" class="form-control">
								</div>
								<div class="form-group" id="password">
									<label>Password</label>
									<a href="PasswordChange.php" class="pass">I Forgot</a>
									<input type="password" placeholder="Your Password" name="password" class="form-control">
									
								</div>
								<div class="form-group" id="remember">
									<label>remember me</label>
									<input type="checkbox" name="remember me">
									<br>
								</div>
								<div class="form-group">
									<h4>Don't have an account?</h4><br>
									<a href="signUp.php">Create an account</a>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="text" class="btn btn-default" data-dismiss="modal">Cancle</button>
							<button type="submit" class="btn btn-primary" name="login">Go In</button>
						</div>
				</div>
			</div>
		</form>
		<form class="modal fade" id="store">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h4 class="modal-title">Shopping as</h4>
					</div>
					<div class="modal-body">
						<a type="button" class="btn btn-primary" href="storeSeller.php">A seller</a>
						<a type="button" class="btn btn-primary" href="storeBuyer.php">A buyer</a>
					</div>
				</div>
			</div>
		</form>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>