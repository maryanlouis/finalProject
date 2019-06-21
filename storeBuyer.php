<?php
include ('include/connection.php');
	session_start();
    //include ('GrouBuy.php');
	//if (!$_SESSION['loggedInUser']) {
	//	header("Location: signUp.php");
	//}
	
	include ('include/functions.php');
$_SESSION['category']=mysqli_query($conn, "SELECT category_name FROM category");
$row = mysqli_fetch_assoc($_SESSION['category']);
$categoryName=$row['category_name'];
$_SESSION['discount']=mysqli_query($conn, "SELECT discount FROM offer");
$row = mysqli_fetch_assoc($_SESSION['discount']);
$discount=$row['discount'];
$_SESSION['start']=mysqli_query($conn, "SELECT start_date FROM offer");
$row = mysqli_fetch_assoc($_SESSION['start']);
$startDate=$row['start_date'];
$_SESSION['end']=mysqli_query($conn, "SELECT end_date FROM offer");
$row = mysqli_fetch_assoc($_SESSION['end']);
$endDate=$row['end_date'];
$_SESSION['offerName']=mysqli_query($conn, "SELECT offer_name FROM offer");
$row = mysqli_fetch_assoc($_SESSION['offerName']);
$offerName=$row['offer_name'];
$_SESSION['userId']=mysqli_query($conn, "SELECT user_id FROM seller");
$row = mysqli_fetch_assoc($_SESSION['userId']);
$userID=$row['user_id'];
$_SESSION['sellerName']=mysqli_query($conn, "SELECT user_first_name, user_last_name FROM user WHERE user_id=userID");
$row = mysqli_fetch_assoc($_SESSION['sellerName']);
$sellerName=$row['user_first_name', 'user_last_name'];
mysqli_close($conn);
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
	<div class="col-sm-12 price-form">
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

			<!--<button class="btn btn-primary listing-button" ng-click="saveOfferEdit()" ng-show="editListing" id="edit">Save</button>

			<button class="btn btn-danger listing-button" ng-click="deleteOffer(existingListing)" ng-show="editListing" id="delete">Delete</button>-->

</div>
	</div>


	<a href="products.php"><div class="container">
		<div class="col-sm-4" ng-repeat="offer in offers | storeFilter:priceInfo | orderBy: '-id'">
			<div class="thumbnail">
				<img ng-src="images/{{offer.image}}.jpg" alt="" />
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						<h3><i class="glyphicon glyphicon-tag"></i>{{ offer.discount | currency}}<?php echo $discount; ?> </h3>
						<p class="label label-primary label-sm">Seller Name: {{offer.SellerName}} <?php echo $sellerName ; ?> </p>
						<p class="label label-primary label-sm">Offer Name: {{offer.offer}} <?php echo $offerName ?> </p>
							<span class="label label-primary label-sm">Category: {{ offer.type }} <?php echo $categoryName; ?> </span>
						</h4>
					</div>
					
					<a href="order_line_quantity.php" role="button" name="addToCard" class="btn btn-info btn-xs" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> ?offerid=<?php echo $offerID; ?>" method="post">Add to card?</a>

					<button class="btn btn-xs btn-success"
									ng-hide="showDetails === true"
									ng-click="showDetails = !showDetails">
										Details
					</button>

<!--					<button class="btn btn-success" ng-show="showDetails" ng-click="editOffer(offer)">Edit</button>-->

					<button class="btn btn-xs btn-danger"
									ng-show="showDetails === true"
									ng-click="showDetails = !showDetails">
										Close
					</button>

					<div class="details" ng-show="showDetails ===true">
						<h4>
							<a href="order.php" role="button" name="finish" class="btn btn-info btn-lg" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?offerid=<?php echo $offerID; ?> ?>?userid=<?php echo $userID; ?>" method="post">finish an order</a>
							<!--<span class="label label-primary">Image: {{offer.image}}</span>-->
							
							<p class="label label-primary label-sm">Start Date: {{offer.start}} <?php echo $startDate; ?> </p>
						<p class="label label-primary label-sm">End Date: {{offer.start}} <?php echo $endDate; ?> </p>
						</h4>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</a>
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