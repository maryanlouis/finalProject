<?php 
include ('include/connection.php');
	session_start();
    //include ('GrouBuy.php');
	//if (!$_SESSION['loggedInUser']) {
	//	header("Location: signUp.php");
	//}
	
	include ('include/functions.php');
	$offers_number=0;
	$quantityOrder = " ";
	while (isset($_POST['addToCard'])) {
		$offers_number ++;
			if (!$_POST["quantityOrder"]) {
			$quantityError="Please enter a quantity <br>";
		}else{
			$quantityOrder=validateFormData($_POST["quantityOrder"]);
		}
				$offerNumber =$_GET['offerId'];
				$_SESSION['offerIdNo']=mysqli_query($conn, "SELECT offer_number FROM offer WHERE offer_number=$offerNumber");
				$row = mysqli_fetch_assoc($_SESSION['offerIdNo']);
				$offerId=$row['offer_number'];
				$priceQuery = "SELECT price FROM offer_line WHERE offer_number= offerId";
				$resultPrice=mysqli_query($conn,$priceQuery);
				$row = mysqli_fetch_assoc($resultPrice);
				$price=$row['price'];
			if ($price&&$offerId) {

				header("Location: signUp.php?alert=success&Id=".$offerId);
			}else{
				echo "Error: ".$price."<br>".mysqli_error($conn);
			}
	}
	mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<title>order line</title>
</head>
<body>
						<div class="form-group" id="quantityOrder">
											<label for="quantity" class="label label-primary label-lg">quantity</label>
											<input type="text" name="quantityOrder" id="quantity" placeholder="enter the quantity of the product you want">
											</div>
</body>
</html>