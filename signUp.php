<?php
	include ('include/connection.php');
	session_start();
  
		
	include ('include/functions.php');
	$fnameError=$lnameError=$EmailError=$passwordError=$userError=$creditcardError=$taxcardError=$bankaccountError=$creditcardError=$registerError="";
	if (isset($_POST['add'])) {
		$firstName = $lastName = $clientEmail =$password=$Address=$creditcard=$bankaccount=$taxcard=$register="";

		if (!$_POST["firstName"]) {
			$fnameError="Please enter a name <br>";
		}else{
			$firstName=validateFormData($_POST["firstName"]);
		}
   	    if (!$_POST["lastName"]) {
			$lnameError="Please enter a name <br>";
		}else{
			$lastName=validateFormData($_POST["lastName"]);
		}
		if (!$_POST["formEmail"]) {
			$EmailError="Please enter an email <br>";
		}else{
			$clientEmail=validateFormData($_POST["formEmail"]);
		}
		if (!$_POST["loginPassword"]) {
			$passwordError="Please enter a password <br>";
		}else{
			$password=validateFormData($_POST["loginPassword"]);
			$passwordHash = password_hash($password,PASSWORD_DEFAULT);
		}
		if (!$_POST["user"]) {
			$userError="Please choose one <br>";
		}elseif($_POST["user"]=="buyer"){
			$creditcard=validateFormData($_POST["creditcard"]);
			
		}
		elseif ($_POST["user"]=="seller") {
			$bankaccount=validateFormData($_POST["bankaccount"]);
			$taxcard=validateFormData($_POST["taxcard"]);
			$register=validateFormData($_POST["register"]);
			
		}
		if ($_POST["user"]=="buyer" && $_POST["taxcard"] ) {
			$taxcardError="Not allowed <br>";
		}
		if ($_POST["user"]=="buyer"&& $_POST["register"]) {
			$registerError="Not allowed <br>";
		}
		if ($_POST["user"]=="buyer"&& $_POST["bankaccount"]) {
			$bankaccountError="Not allowed <br>";
		}

		if ($_POST['user']=="seller" && $creditcard!=" ") {
		   $creditcardError="Not allowed <br>";
		}

		$Address=validateFormData($_POST["address"]);
		


		if ($firstName && $lastName && $clientEmail) {
		
			$query1 = "INSERT INTO user(user_firstname, user_lastname,user_email, password, Address)VALUES('$firstName', '$lastName', '$clientEmail', '$passwordHash', '$Address');";
				$result1 = mysqli_query($conn, $query1);
				$id =mysqli_query($conn, "SELECT LAST_INSERT_ID() as UserID");
				$row = mysqli_fetch_assoc($id);
				$userId=$row['UserID'];
				if ($_POST["user"]=="buyer") {
					$query2= "INSERT INTO buyer(credit_card, user_id)VALUES('$creditcard','$userId')" ;
					$result2 = mysqli_query($conn, $query2);
				}
				if ($_POST["user"]=="seller") {
					$query3="INSERT INTO seller(bank_account, tax_card, commercial_register, user_id)VALUES('$bankaccount','$taxcard', '$register','$userId')";
					$result3 = mysqli_query($conn, $query3);
					}
		

			if ($result1) {

				header("Location: signUp.php?alert=success&Id=".$userId);
			}else{
				echo "Error: ".$query1."<br>".mysqli_error($conn);
			}
		}
	}
	mysqli_close($conn);
	//include ('includes/header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bootstrap Forms</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link href="style.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Sign Up</h1>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
											<!--has-success-->
											<!--has-warning-->
					<div class="form-group" id="1stName">
						<label for="firstName">First name</label>
						<input type="text" id="firstName" name="firstName" class="form-control" placeholder="Your first name" value="">
						<?php echo $fnameError;?>
					</div>
					<div class="form-group" id="lastName">
						<label for="lastName">Last name</label>
						<input type="text" id="lastName" name="lastName" class="form-control" placeholder="Your last name" value="">
						<?php echo $lnameError;?>
					</div>
					<div class="form-group" id="email">
						<label for="formEmail">Email address</label>
						<input type="email" id="formEmail" name="formEmail" class="form-control" placeholder="name@mail.com" value="">
						<?php echo $EmailError;?>
					</div>
					<div class="form-group" id="password">
						<label for="loginPassword">Password</label>
						<input type="password" id="loginPassword" name="loginPassword" class="form-control" placeholder="password" value="">
						<?php echo $passwordError;?>
					</div>
					<div class="form-group" id="address">
						<label for="address">Address</label>
						<input type="text" id="address" name="address" class="form-control" placeholder="address" value="">
					</div>
					<div class="form-group" id="buyer">
					<input type="radio" name="user" id="buyer" value="buyer">
					<label for="buyer">Buyer</label>
					<?php echo $userError;?>
					</div>
					<br>
					<div class="form-group" onclick="buyer">
						<label for="creditcard">Credit Card ID</label>
						<input type="text" id="creditcard" name="creditcard" class="form-control" placeholder="card no." value="">
						<?php echo $creditcardError;?>
					</div>
					<div class="form-group" id="seller">
					<input type="radio" name="user" id="seller" value="seller">
					<label for="seller">Seller</label>
					<?php echo $userError;?>
					</div>
					<div class="form-group" onclick="seller">
						<label for="bankaccount">Bank account</label>
						<input type="text" id="bankaccount" name="bankaccount" class="form-control" placeholder="account no." value="">
						<?php echo $bankaccountError;?>
					</div>
					<div class="form-group" onclick="seller">
						<label for="taxcard">Tax card number</label>
						<input type="text" id="taxcard" name="taxcard" class="form-control" placeholder="card no." value="">
						<?php echo $taxcardError;?>
					</div>
					<div class="form-group" onclick="seller">
						<label for="register">Commeriel register number</label>
						<input type="text" id="register" name="register" class="form-control" placeholder="register number" value="">
						<?php echo $registerError;?>
					</div>
					<button type="submit" class="btn btn-success" name="add">Create</button>
					<button type="text" class="btn btn-default" data-dismiss="modal">Cancle</button>

				</form>
			</div>
		</div>
	</div>
	

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>