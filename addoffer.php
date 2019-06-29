<?php
    include ('include/connection.php');
	session_start();
	if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
    include ('include/functions.php');
    $priceError=$enddateError=$categoryError=$discountError=$quantityError=$offerNameError=$productNoError=$startdateError=$discriptionError=$alertMessage="";
	if (isset($_POST['add']))
	{
		$discount = $startDate = $endDate =$quantity=$description=$price=$category=$offername=$productNumber="";
		if (!$_POST["discount"]) {
			$discountError="Please the discount <br>";
		}else{
            
			$discount=floatval(validateFormData($_POST["discount"])) ;
        }
        if (!$_POST["image"]) {
			$imageError="Please enter image name <br>";
		}else{
			$image=validateFormData($_POST["image"]);
		}
   	 	if (!$_POST["start"]) {
			$startdateError="Please enter a startDate <br>";
		}else{
			$startDate=validateFormData($_POST["start"]);
		}
		if (!$_POST["end"]) {
			$enddateError="Please enter an endDate <br>";
		}else{
			$endDate=validateFormData($_POST["end"]);
		}
		
        if (!$_POST["offerName"]) 
        {
			$offerNameError="Please enter the name of the offer <br>";
		}else{
			$offerName=validateFormData($_POST["offerName"]);
		}

        if ($discount && $startDate && $endDate && $image && $offerName)
        {
		      $userID=$_SESSION['logInId'];
		      $query2="INSERT INTO offer (`offer_name`, `discount`, `image`, `start_date`, `end_date`, `user_id`) VALUES ('$offerName' ,'$discount','$image','$startDate','$endDate','$userID')";
		      $result2 = mysqli_query($conn, $query2);
              if (mysqli_affected_rows($conn) > 0) 
              {
						header("Location: storeSeller.php?alert=success");	
			  }else{
                echo "Error: ".$query2."<br>".mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

                        <div class="col-sm-4">
                            <div class="input-group" id="offerName">
                                <span class="input-group-addon">Offer Name <?php echo $offerNameError; ?></span>
                                <input type="text" name="offerName" placeholder="Enter the offer name"
                                    class="form-control" ng-model="newListing.offerName">
                            </div>
                        </div>
                        <br>

                        <div class="col-sm-4">
                            <div class="input-group" id="discount">
                                <span class="input-group-addon">Discount <?php echo $discountError; ?></span>
                                <input type="text" name="discount" placeholder="Enter the price of the offer"
                                    class="form-control" ng-model="newListing.discount">
                            </div>
                        </div>
                        <br>

                        <div class="col-sm-4">
                            <div class="input-group" id="start">
                                <span class="input-group-addon">Start date <?php echo $startdateError; ?></span>
                                <input type="text" name="start" placeholder="Enter the start date" class="form-control"
                                    ng-model="newListing.start">
                            </div>
                        </div>
                        <br>

                        <div class="col-sm-4">
                            <div class="input-group" id="end">
                                <span class="input-group-addon">End date <?php echo $enddateError; ?></span>
                                <input type="text" name="end" placeholder="Enter the end date" class="form-control"
                                    ng-model="newListing.end">
                            </div>
                        </div>
                        <br>

                        <div class="col-sm-4">
                            <div class="input-group" id="image">
                                <span class="input-group-addon">Image</span>
                                <input type="text" name="image" placeholder="image" class="form-control" ng-model="newListing.image">
                                <br>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-primary listing-button" name="add" ng-click="addOffer(newListing)"
                            ng-show="addListing">Add</button>
                       
                    </form>
                    </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>