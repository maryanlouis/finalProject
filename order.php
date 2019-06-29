<?php
include ('include/connection.php');
	session_start();
	include ('include/functions.php');
	//include ('order_line_quantity.php');
	$order = array();
	$creditcard ="";
		$offerNumber =$_GET['offerid'];
		$userId=$_SESSION['logInId'];
	if (!$_SESSION['loggedInUser']) {
		header("Location: GrouBuy.php");
	}
	if (isset($_POST['order'])) {
		
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
			$cashConfirm="That's OK, you can pay when your order is delivered ";
			
		}
		$offers_number=$_SESSION['offers_number'];
	$total=0;
		while ($offers_number>0) {
		$total=$total+($_SESSION['quantityOrder']*$_SESSION['price']);
		$offers_number--;
	}
		
		if (isset($_POST["payment"])) {
			$offers_number=$_SESSION['offers_number'];
				$quantityOrder=$_SESSION['quantityOrder'];
				$query1 = "INSERT INTO `order`(offers_number,date_current,total_price,user_id)VALUES('$offers_number',CURRENT_TIMESTAMP, '$total', '$userId')";
				$result1 = mysqli_query($conn, $query1);
				if ($result1) {
					//header("Location: storeBuyer.php?alert=success");
				
					$id =mysqli_query($conn, "SELECT LAST_INSERT_ID() as orderID");
					$row = mysqli_fetch_assoc($id);
					$orderId=$row['orderID'];
			$query2="INSERT INTO order_line(quantity,order_id, offer_number) VALUES('$quantityOrder', '$orderId','$offerNumber')";
			$result2 = mysqli_query($conn, $query2);
			
					
					if ($result2) {
						header("Location: storeBuyer.php?alert=success");
					}else{
						echo "Error: ".$query2."<br>".mysqli_error($conn);
					}
		}
	}
			$query=mysqli_query($conn,"SELECT * FROM order");
			
			if (mysqli_affected_rows($conn) > 0 ){
				while ($row = mysqli_fetch_assoc($query)) {
					$name="SELECT offer_name FROM offer WHERE offer_number= '$offerNumber'";
					$row1= mysqli_fetch_assoc($name);
					$row['offer']=array_values($row1);
					$quantity="SELECT quantity FROM order_line WHERE order_id=".$row['order_id'];
					$row2= mysqli_fetch_assoc($quantity);
					$row['order_line']=array_values($row2);
					$order[]=$row;
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
	<form id="order" method="post">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
										<h4 class="modal-title">Make order</h4>
									</div> 
									<div class="modal-body">
										<form>
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
											<?php foreach ($order as $value) {
												echo $value['offer'][0];
												echo $value['date_current'];
												echo $value['total price'];
												echo $value['order_line'][0];
											}?>
										</form>
									</div>
								</div>
							</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
    
</html>