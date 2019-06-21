<?php
include ('include/connection.php');
	session_start();
    //include ('GrouBuy.php');
	//if (!$_SESSION['loggedInUser']) {
	//	header("Location: signUp.php");
	//}
	
	include ('include/functions.php');
			$product_id = $_GET['product_id'];
			$offerLine_id = $_GET['offer_line_id'];
			$user_id = $_GET['user_id'];
			$_SESSION['offer_number']=mysqli_query($conn,"SELECT offer_number FROM offer");
			$row = mysqli_fetch_assoc($_SESSION['offer_number']);
			$offerId=$row['offer_number'];
			$query1 = "SELECT * FROM product WHERE product_id = '$product_id' AND offer_number= '$offerId'";
			$query2="SELECT * FROM offer_line WHERE offer_line_id= '$offerLine_id'";
			$result1 = mysqli_query($conn, $query1);
			$result2=mysqli_query($conn, $query2);
			if (mysqli_num_rows($result1) > 0 && mysqli_num_rows($result2) > 0){
		while ($row = mysqli_fetch_assoc($result1)&&$row = mysqli_fetch_assoc($result2)) {
			$quantity = $row['quantity'];
			$discrption = $row['discrption'];
			$price = $row['price'];
			$productname= $row['product_name'];
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
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
		
		</div>
		
	<h3>Products</h3>

	<div class="row listing-form-row" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?product_id=<?php echo $productID; ?> , ?offer_line_id=<?php echo $offerLineID; ?>" method="post">
		<?php echo $alertMessage; ?>
				<!--<div class="col-sm-4">
					<div class="input-group" id="SellerName">
						<span class="input-group-addon">Seller Name</span>
						<input type="text" name="sellerName" placeholder="Enter the offer no." class="form-control" ng-model="existingListing.SellerName">
					</div>
				</div>-->

				

	<div class="container">
		<div class="col-sm-4" ng-repeat="offer in offers | storeFilter:priceInfo | orderBy: '-id'">
			<div class="thumbnail">
				<img ng-src="images/{{offer.image}}.jpg" alt="" />
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						<h3><i class="glyphicon glyphicon-tag"></i> <?php echo $price; ?></h3>
						<p class="label label-primary label-sm">Product Name:<?php echo $productname; ?> </p>
						<p class="label label-primary label-sm">Discription:<?php echo $description; ?></p>
						<p class="label label-primary label-sm">Quantity:<?php echo $quantity; ?></p>
						</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
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