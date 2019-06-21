<?php
include ('include/connection.php');
	session_start();
    //include ('GrouBuy.php');
	//if (!$_SESSION['loggedInUser']) {
	//	header("Location: signUp.php");
	//}
	
	include ('include/functions.php');
	if (isset($_POST['finish'])) {
		$creditcard ="";
   	    
		if (!$_POST["payment"]) {
			$userError="Please choose one <br>";
		}elseif($_POST["payment"]=="creditcard"){
			$creditcard=validateFormData($_POST["creditcard"]);
			$queryCard= "SELECT credit_card,user_firstname  FROM user WHERE credit_card='$creditcard'";
			$result = mysqli_query($conn, $queryCard);
			if (!$result) {
				$cardError= "wrong number";
			}
			
		}
		elseif ($_POST["payment"]=="cash") {
			$cashConfirm="That's OK, you can pay when your order is delivered "
			
		}
		$offerNumber =$_GET['offerId'];
		include('order_line_quantity');
		$total+=$quantityOrder*$price;
		$userId=$_GET['userId'];
		if (isset($_POST["payment"])) {
			while ($offers_number>0) {
				$query1 = "INSERT INTO order(offers_number,date_current,total_price,user_id)VALUES('$offers_number',CURRENT_TIMESTAMP, '$total', '$userId');"
				$result1 = mysqli_query($conn, $query1);
				$_SESSION['orderId']=mysqli_query($conn,"SELECT LAST_INSERT_ID() FROM order");
				$row = mysqli_fetch_assoc($_SESSION['orderId']);
				$orderId=$_SESSION['order_id'];
					$query2="INSERT INTO order_line(quantity,order_id, offer_number) VALUES('$quantityOrder', '$orderId')";
			$result2 = mysqli_query($conn, $query2);
				$offers_number --;
			}
			
			if ($result1&&$result2) {
				header("Location: storeBuyer.php?alert=success");
			}else{
				echo "Error: ".$query1.$query2."<br>".mysqli_error($conn);
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
	<title>Order</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">	
</head>
<body>
<div class="container">
	<!--<a data-toggle="modal" data-target="#order"role="button" class="btn btn-danger btn-xs">make an order</a>-->
	<form id="order">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
										<h4 class="modal-title">Make order</h4>
									</div> 
									<div class="modal-body">
										<form>
											<!--<div class="form-group" id="name">
											<label for="name" class="label label-primary label-lg">name</label>
											<input type="text" name="name" id="name" placeholder="enter your name">
											</div>-->
											<!--<div class="form-group" id="address">
											<label for="address" class="label label-primary label-lg">Address</label>
											<input type="text" name="address" id="address" placeholder="enter your address">
											</div>-->
											<div class="form-group">
											<label class="label label-primary label-lg">Payment: </label>
											<br>
											<input type="radio" name="payment" id="cash" value="cash">
											<label for="cash">Cash</label>
											<br>

											<input type="radio" name="payment" id="creditCard" value="creditcard">
											<label for="creditCard">Credit Card</label>
											</div>
											<div class="form-group" id="creditcard">
											<label for="quantity" class="label label-primary label-lg">Credit Card No.</label>
											<input type="text" name="creditcard" id="creditcard" placeholder="enter the number of your card">
											</div>
											<button type="submit" class="btn btn-success" name="order">Save</button>
											<button type="text" class="btn btn-default" data-dismiss="modal">Cancle</button>
											<?php 
											   if (isset($_POST['order'])) {
											   	$name="SELECT offer_name FROM offer WHERE offer_number='$orderId'";
											   	$date="SELECT date_current FROM order";
											   	echo $name;
											   	echo $date;
											   	echo $total;
											   	echo $quantityOrder;
											   }
											?>
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