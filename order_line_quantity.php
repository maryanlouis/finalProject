<?php 
include ('include/connection.php');
	session_start();
	include ('include/functions.php');
	// if (!$_SESSION['loggedInUser']) {
	// 	header("Location: GrouBuy.php");
	// }
	$_SESSION['offers_number']=0;
	$_SESSION['quantityOrder'] = 0;
	$offerNumber =$_GET['offerid'];
	if (isset($_POST['addToCard'])) {
		$_SESSION['offers_number']=$_SESSION['offers_number'] +1;
			if (!isset($_POST["quantityOrder"])) {
			$quantityError="Please enter a quantity <br>";
		}else{
			$_SESSION['quantityOrder']= $_SESSION['quantityOrder']+validateFormData($_POST["quantityOrder"]);
		}
				
				//$offerIdNo=mysqli_query($conn, "SELECT offer_number FROM offer");
				
				//$offerId=$row['offer_number'];			
				//if (mysqli_num_rows($offerIdNo) > 0){
				//	while ($row = mysqli_fetch_assoc($offerIdNo)) {
				$priceQuery = "SELECT SUM(price) as price FROM offer_line WHERE offer_number='$offerNumber'";
				$resultPrice=mysqli_query($conn,$priceQuery);
				$row = mysqli_fetch_assoc($resultPrice);
				$_SESSION['price']=$row['price'];
				//$row = mysqli_fetch_assoc($resultPrice);
				//$row['offer_line']=array_values($row);
				//$offerlines[]= $row;
				if ($_SESSION['price']) {
					header("Location: storeBuyer.php?alert=success&Id='$offerNumber'");
				}
				
			//}
		//}
			// if ($price&&$offerId) {
			else{
				echo "Error: ".$priceQuery."<br>".mysqli_error($conn);
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
	<title>order line</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">	
</head>
<body>
	<div class="container">
	<form id="quantityOrder" method="post">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						<h3>Add the quantity you want</h3>
					</div>
						<div class="modal-body" id="quantityOrder">
											<label for="quantity" class="label label-primary label-lg">quantity</label>
											<input type="text" name="quantityOrder" id="quantity" placeholder="enter the quantity of the product you want">
						</div>
						<button type="submit" class="btn btn-primary" name="addToCard">Save</button>
				</div>
			</div>
		</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

    
</html>