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
					header("Location: recommender.php?alert=success&Id='$offerNumber'");
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