<?php
include ('include/connection.php');
	session_start();
    //include ('GrouBuy.php');
	//if (!$_SESSION['loggedInUser']) {
	//	header("Location: signUp.php");
	//}
	
	include ('include/functions.php');
	if (isset($_POST['add'])) {
		$discount = $startDate = $endDate =$quantity=$description=$price=$category=$offername=$productNumber="";

		if (!$_POST["discount"]) {
			$discountError="Please the discount <br>";
		}else{
			$discount=validateFormData($_POST["discount"]);
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
		
		if (!$_POST["category"] ) {
			$categoryError="choose one <br>";

		}
		else{
			$category=validateFormData($_POST["category"]);
			
		}
		

		if (!$_POST["productNumber"]) {
			$productNoError="Please enter number of products <br>";
		}else{
			$productNumber=validateFormData($_POST["productNumber"]);
		}
		
		if (!$_POST["offerName"]) {
			$offerNameError="Please enter the name of the offer <br>";
		}else{
			$offername=validateFormData($_POST["offerName"]);
		}

		if (!$_POST["quantity"]) {
			$quantityError="Please enter the quantity<br>";
		}else{
			$quantity=validateFormData($_POST["quantity"]);
		}
		if (!$_POST["discrption"]) {
			$discriptionError="Please enter the discrption <br>";
		}else{
			$description=validateFormData($_POST["discrption"]);
		}
		
		if (!$_POST["price"]) {
			$priceError="Please enter the price <br>";
		}else{
			$price=validateFormData($_POST["discrption"]);
		}
		
		
		if ($discount && $startDate && $endDate && $category && $productname) {
			$query1 = "INSERT INTO category(category_name, parent)VALUES('$category','$categoryId')";
			$result1 = mysqli_query($conn, $query1);
      $_SESSION["categoryId"]= "SELECT LAST_INSERT_ID() FROM category";
      $row = mysqli_fetch_assoc($_SESSION["categoryId"]);
      $categoryId=$row['category_id'];
      $_SESSION["userId"]= "SELECT LAST_INSERT_ID() FROM user ";
      $row = mysqli_fetch_assoc($_SESSION["userId"]);
      $userId=$row['user-id'];
      $query2="INSERT INTO offer(offer_name,discount,start_date,end_date,user_id)VALUES('$offerName' '$discount','$startDate','$endDate','$userId')";
      $result2 = mysqli_query($conn, $query2);
      $_SESSION["offerNumber"]=mysqli_query($conn, "SELECT LAST_INSERT_ID() FROM offer");
      $row = mysqli_fetch_assoc($_SESSION["offerNumber"]);
      $offerNumber=$row['offer_number'];
			$query3=" INSERT INTO product(product_name, discrption,category_id)VALUES('$productname','$description', '$categoryId')";
			$result3 = mysqli_query($conn, $query3);
			$_SESSION["productId"]=mysqli_query($conn,"SELECT LAST_INSERT_ID() FROM product");
			$row = mysqli_fetch_assoc($_SESSION["productId"]);
      $productId=$row['product_id'];
			while ($productNumber>0) {
			$query4= "INSERT INTO offer_line(quantity,price,offer_number,product_id)VALUES('$quantity', '$price','$offerNumber','$productId')";
			$result4 = mysqli_query($conn, $query4);
			$productNumber --;
		}
			if ($result1&&$result2&&$result3&&$result4) {
				header("Location: storeSeller.php?alert=success");
			}else{
				echo "Error: ".$query1.$query2.$query3.$query4."<br>".mysqli_error($conn);
			}
		}
	}
			$category_id = $_GET['category_id'];
			$offer_id = $_GET['offer_number'];
			$product_id = $_GET['product_id'];
			$offerLine_id = $_GET['offer_line_id'];
			$user_id = $_GET['user_id'];
			$query = "SELECT * FROM category WHERE category_id='$category_id';
			SELECT * FROM offer WHERE offer_number= '$offer_id';
			SELECT * FROM product WHERE product_id = '$product_id';
			SELECT * FROM offer_line WHERE offer_line_id= '$offerLine_id';
			SELECT * FROM user(user_firstname, user_lastname) WHERE user_id= '$user_id'";
			$result = mysqli_query($conn, $query);
			if (mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			$discount = $row['discount'];
			$startDate = $row['start_date'];
			$endDate = $row['end_date'];
			$quantity = $row['quantity'];
			$discrption = $row['discrption'];
			$price = $row['price'];
			$category = $row['category_name'];
			$offername= $row['offer_name'];
			$name = $row['user_firstname'] + $row['user_lastname'];
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
	}

	if (isset($_POST['edit'])) {
		$discount=validateFormData($_POST["discount"]);
		$startDate=validateFormData($_POST["start"]);
		$endDate=validateFormData($_POST["end"]);
		$quantity=validateFormData($_POST["quantity"]);
		$price=validateFormData($_POST["price"]);
		$category=validateFormData($_POST["category"]);
		$offerName=validateFormData($_POST["offerName"]);

		$query="UPDATE category SET category_name='$category'WHERE category_id='$category_id';
		UPDATE offer SET offer_name='$offerName' discount= '$discount',start_date= '$startDate',end_date='$endDate' WHERE offer_number='$offer_id';
	  UPDATE product SET product_name='$productname', discrption='$description' WHERE product_id= '$product_id';
	  UPDATE offer_line SET quantity='$quantity',price = '$price' WHERE offer_line_id='$offerLine_id'
		";

		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: storeSeller.php?alert=updatesuccess");
		}else{
			echo "Error updating record: ".mysql_error();
		}
	} 

	if (isset($_POST['delete'])) {
		$alertMessage = "<div class='alert alert-danger'><p>Are you sure you want to delete this client? No take baks!</p><br>
		<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post'>
			<input type='submit' class='btn btn-danger btn-sm' on-click='deleteOffer(existingListing)' name='confirm-delete' value='yes, delete!'>
			<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!S</a>
		</form>
		</div>";
	}

	if (isset($_POST['confirm-delete'])){
		
			header("Location: storeSeller.php?alert=deleted");
		
	}

	
	mysqli_close($conn);
	//include ('includes/header.php');  
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Store</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body ng-app="ngStore" ng-controller="storeController">

	<!--<button ng-click="sayHello()">Say Hello</button>-->
	<!--<button ng-click="showMessage = true">Show Message</button>

	<button ng-click="showMessage = false">Hide Message</button>-->
	<!--<button ng-click="showMessage = !showMessage">Toggle Message</button>

	<h2 ng-show="showMessage == true">Secret Message</h2>
	<input type="text" placeholder="Leave a message" ng-model="message">
	<h2>{{message}}</h2>-->
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Store</a>
			</div>
		</div>
	</nav>

<div class="container">
	<div class="col-sm-12 price-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		<div class="row price-form-row" ng-if="!addListing">
		<div class="col-sm-6">
			<div class="input-group">
				<span class="input-group-addon">Min Price</span>
				<select name="minPrice" id="minPrice" ng-model="priceInfo.min" class="form-control">
					<option value="100000">$100,000</option>
					<option value="200000">$200,000</option>
					<option value="300000">$300,000</option>
					<option value="400000">$400,000</option>
					<option value="500000">$500,000</option>
					<option value="600000">$600,000</option>
					<option value="700000">$700,000</option>
					<option value="800000">$800,000</option>
					<option value="900000">$900,000</option>
					<option value="1000000">$1,000,000</option>
				</select>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="input-group">
				<span class="input-group-addon">Max Price</span>
				<select name="maxPrice" id="maxPrice" ng-model="priceInfo.max" class="form-control">
					<option value="100000">$100,000</option>
					<option value="200000">$200,000</option>
					<option value="300000">$300,000</option>
					<option value="400000">$400,000</option>
					<option value="500000">$500,000</option>
					<option value="600000">$600,000</option>
					<option value="700000">$700,000</option>
					<option value="800000">$800,000</option>
					<option value="900000">$900,000</option>
					<option value="1000000">$1,000,000</option>
				</select>
			</div>
		</div>
	</div>
		<button class="btn btn-primary" ng-click="addListing = !addListing" ng-show="!addListing" id="add">Add Listing</button>

		<button class="btn btn-danger" ng-click="addListing = !addListing" ng-show="addListing">Close</button>

		<div class="listing-form" ng-if="addListing" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h3>Add a Listing</h3>

			<div class="row listing-form-row">
				<div class="col-sm-4">
					<div class="input-group" id="productNumber">
						<span class="input-group-addon">Product Number <?php echo $productNoError; ?></span>
						<input type="text" name="productNumber" placeholder="Enter the number of products" class="form-control" ng-model="newListing.productNumber">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="offerName">
						<span class="input-group-addon">Offer Name <?php echo $offerNameError; ?></span>
						<input type="text" name="offerName" placeholder="Enter the offer name" class="form-control" ng-model="newListing.offerName">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="discount">
						<span class="input-group-addon">Discount <?php echo $discountError; ?></span>
						<input type="text" name="discount" placeholder="Enter the price of the offer" class="form-control" ng-model="newListing.discount">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="start">
						<span class="input-group-addon">Start date <?php echo $startdateError; ?></span>
						<input type="text" name="start" placeholder="Enter the start date" class="form-control" ng-model="newListing.start">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="end">
						<span class="input-group-addon">End date <?php echo $enddateError; ?></span>
						<input type="text" name="end" placeholder="Enter the end date" class="form-control" ng-model="newListing.end">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="quantity">
						<span class="input-group-addon">Quantity <?php echo $quantityError; ?></span>
						<input type="text" name="quantity" placeholder="Enter the quantity" class="form-control" ng-model="newListing.quantity">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="description">
						<span class="input-group-addon">Description  <?php echo $discriptionError; ?></span>
						<textarea type="text" name="description" placeholder="Enter the description" class="form-control" ng-model="newListing.description"></textarea> 
						<br>
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="price">
						<span class="input-group-addon">Price <?php echo $priceError; ?></span>
						<input type="text" name="price" placeholder="Enter the price of the offer" class="form-control" ng-model="newListing.price">
					</div>
				</div>
				<br>
				
				<div class="col-sm-4">
					<div class="input-group" id="image">
						<span class="input-group-addon">Image</span>
						<input type="text" placeholder="image" class="form-control" ng-model="newListing.image">
						<br>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="input-group" id="type">
						<span class="input-group-addon">Property Type <?php echo $categoryError; ?></span>
						<select type="select" name="category" id="propertyType" class="form-control" ng-model="newListing.type">
							<option value="Electrontics">Electrontics</option>
							<option value="Sports">Sports</option>
							<option value="Kitchen">Kitchen</option>
							<option value="Clothes">Clothes</option>
						</select>
					</div>
				</div>
				<br>
			</div>

			<button class="btn btn-primary listing-button" ng-click="addOffer(newListing)" ng-show="addListing" name="add">Add</button>
			<pre>{{newListing | json}}</pre>
			
		</div>
		<div class="listing-form" ng-if="editListing">
	<h3>Edit Listing</h3>

	<div class="row listing-form-row" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?offer_number=<?php echo $offer_id; ?> ?category_id=<?php echo $category_id; ?> ?product_id=<?php echo $product_id; ?> ?offer_line_id=<?php echo $offerLine_id; ?> ?user_id=<?php echo $user_id; ?>  " method="post">
		<?php echo $alertMessage; ?>
				<!--<div class="col-sm-4">
					<div class="input-group" id="SellerName">
						<span class="input-group-addon">Seller Name</span>
						<input type="text" name="sellerName" placeholder="Enter the offer no." class="form-control" ng-model="existingListing.SellerName">
					</div>
				</div>-->

				<div class="col-sm-4">
					<div class="input-group" id="productNumber">
						<span class="input-group-addon">Product Number</span>
						<input type="text" name="productNumber" placeholder="Enter the offer no." class="form-control" ng-model="existingListing.productNumber">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="offerName">
						<span class="input-group-addon">Offer Name</span>
						<input type="text" name="offername" placeholder="Enter the Offer Name" class="form-control" ng-model="existingListing.offer">
					</div>
				</div>
				<br>	

				<div class="col-sm-4">
					<div class="input-group" id="discount">
						<span class="input-group-addon">Discount</span>
						<input type="text" name="discount" placeholder="Enter the price of the offer" class="form-control" ng-model="existingListing.discount">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="start">
						<span class="input-group-addon">Start date</span>
						<input type="text" name="start" placeholder="Enter the start date" class="form-control" ng-model="existingListing.start">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="end">
						<span class="input-group-addon">End date</span>
						<input type="text" name="end" placeholder="Enter the end date" class="form-control" ng-model="existingListing.end">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="quantity">
						<span class="input-group-addon">Quantity</span>
						<input type="text" name="quantity" placeholder="Enter the quantity" class="form-control" ng-model="existingListing.quantity">
					</div>
				</div>
				<br>

					<div class="col-sm-4">
					<div class="input-group" id="description">
						<span class="input-group-addon">Description</span>
						<textarea type="text" name="description" placeholder="Enter the description" class="form-control" ng-model="existingListing.description"></textarea> 
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="price">
						<span class="input-group-addon">Price</span>
						<input type="text" name="price" placeholder="Enter the price of the offer" class="form-control" ng-model="existingListing.price">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="image">
						<span class="input-group-addon">Image</span>
						<input type="text" placeholder="image" class="form-control" ng-model="existingListing.image">
					</div>
				</div>
				<br>

				<div class="col-sm-4">
					<div class="input-group" id="type">
						<span class="input-group-addon">Property Type</span>
						<select type="select" name="category" id="propertyType" class="form-control" ng-model="existingListing.type">
							<option value="Electrontics">Electrontics</option>
							<option value="Sports">Sports</option>
							<option value="Kitchen">Kitchen</option>
							<option value="Clothes">Clothes</option>
						</select>
					</div>
					<br>
				</div>
			</div>
			<button class="btn btn-primary listing-button" ng-click="saveOfferEdit()" ng-show="editListing" id="edit" name="edit">Save</button>

			<button class="btn btn-danger listing-button"  ng-show="editListing" id="delete" name="delete">Delete</button>
	</div>
</div>
	</div>
</div>

	<a href="products.php" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"><div class="container">
		<div class="col-sm-4" ng-repeat="offer in offers | storeFilter:priceInfo | orderBy: '-id'">
			<div class="thumbnail">
				<img ng-src="images/{{offer.image}}.jpg" alt="" />
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						<h3><i class="glyphicon glyphicon-tag"></i><?php echo $discount; ?></h3>
						<p class="label label-primary label-sm">Seller Name:<?php echo $name; ?> </p>
						<p class="label label-primary label-sm">Offer Name:<?php echo $offername; ?></p>

							<span class="label label-primary label-sm"><?php echo $category; ?></span>
						</h4>
					</div>

					<button class="btn btn-xs btn-success"
									ng-hide="showDetails === true"
									ng-click="showDetails = !showDetails">
										Details
					</button>

					<button class="btn btn-success" ng-show="showDetails" ng-click="editOffer(offer)">Edit</button>

					<button class="btn btn-xs btn-danger"
									ng-show="showDetails === true"
									ng-click="showDetails = !showDetails">
										Close
					</button>

					<div class="details" ng-show="showDetails ===true">
						<h4>
							<!--<span class="label label-primary">Image: {{offer.image}}</span>-->
							<span class="label label-primary">Start Date:<?php echo $startDate; ?></span>
							<span class="label label-primary">End Date:<?php echo $endDate; ?></span>
						</h4>

					</div>
				</div>
			</div>
		</a>
		</div>
	</div>

	<!--<div class="well" ng-repeat="crib in cribs">
		<h3>{{ crib.address }}</h3>
		<p><strong>Type:</strong>{{ crib.type }}</p>
		<p><strong>Description:</strong>{{ crib.description}}</p>
		<p><strong>Price:</strong>{{ crib.price | currency}}</p>
	</div>-->
	<!--<h1>Hello ng-cribs</h1>-->
	<!--<h1>{{ hello }}</h1>-->
	<!--<h1>{{ 5+7 }}</h1>-->
	<!--<h1>{{ hello + ' How are you?'}}</h1>-->
	<!--<pre>{{ cribs | json }}</pre>-->
	<!--<div ng-app="ngCribs"></div>-->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.4/ui-bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.4/ui-bootstrap-tpls.min.js"></script>
<script src="app.js"></script>
<script src="scripts/storeController.js"></script>
<script src="scripts/storeFactory.js"></script>
<script src="scripts/storeFilter.js"></script>
</html>