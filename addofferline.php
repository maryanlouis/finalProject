<?php
    include ('include/connection.php');
	session_start();
	if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
    include ('include/functions.php');
    $offer_number=$_SESSION['offer_number'];
    $productid=0;
    $priceError=$quantityError=$alertMessage=" ";
	if (isset($_POST['add']))
	{ $productid=$_GET['productid'] ;

		$price=$quantity="";
		if (!$_POST["price"]) {
			$priceError="Please the price  <br>";
		}else{
            
			$price=floatval(validateFormData($_POST["price"])) ;
        }
        if (!$_POST["quantity"]) {
			$quantityError="Please enter the quantity <br>";
		}else{
			$quantity=validateFormData($_POST["quantity"]);
		}
        if (!$productid) {
			$productError="You must choose a product<br>";
		}
        if ($price&&$quantity)
        {
		      $query="INSERT INTO offer_line ( quantity ,price,offer_number,product_id) VALUES ('$quantity' ,'$price','$offer_number','$productid')";
		      $result = mysqli_query($conn, $query);
              if (mysqli_affected_rows($conn) > 0) 
              {
						header("Location: offer_lines.php?alert=success&offer_number=".$_SESSION['offer_number']);	
			  }else{
                echo "Error: ".$query."<br>".mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn);
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
            <form method="post">
            <br><br>
                        <div class="col-sm-4">

                            <div class="input-group" id="discount">
                                
                                <span class="input-group-addon">Price <?php echo $priceError; ?></span>
                                <input type="text" name="price" placeholder="Enter the price of the item"
                                    class="form-control" ng-model="newListing.discount">
                            </div>
                        </div>
                        <br>

                        <div class="col-sm-4">
                            <div class="input-group" id="quantity">
                                <span class="input-group-addon">Quantity <?php echo $quantityError; ?></span>
                                <input type="text" name="quantity" placeholder="Enter the quantity" class="form-control"
                                    ng-model="newListing.start">
                            </div>
                        </div>
                        <br>
                        <br>
                        <a class="btn btn-primary listing-button" href="products.php">Choose an existing product </a>
                        <a class="btn btn-primary listing-button" href="addproduct.php">ADD a new product</a>
                        <br>
                        <button class="btn btn-primary listing-button" name="add" ng-click="addOffer(newListing)" ng-show="addListing">Submit</button>     
            </form>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>