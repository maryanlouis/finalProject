<?php 
include ('include/connection.php');
	session_start();
	include ('include/functions.php');
$query1="SELECT quantity FROM offer_line";
$result1 = mysqli_query($conn, $query1);
$row = mysqli_fetch_assoc($result1);
$offerQuantity=$row['quantity'];
$query2="SELECT quantity FROM order_line";
$result2 = mysqli_query($conn, $query2);
$row = mysqli_fetch_assoc($result2);
$orderQuantity=$row['quantity'];
$query3="SELECT offers_number FROM order";
$result3 = mysqli_query($conn, $query3);
$row = mysqli_fetch_assoc($result3);
$noOfOffers=$row['offers_number'];
while ($noOfOffers>0) {
	if ($offerQuantity==$orderQuantity) {
		$query4="SELECT * FROM offer";
		//$query5= "SELECT * FROM offer_line";
		$query5="SELECT user_id FROM seller";
		$query6="SELECT category_name FROM category";

		$result4 = mysqli_query($conn, $query4);
		//$result5 = mysqli_query($conn, $query5);
	  $result5= mysqli_query($conn, $query5);
	  $result6 = mysqli_query($conn, $query6);
		$row = mysqli_fetch_assoc($result4);
		$offerName=$row['offer_name'];
		$discount=$row['discount'];
		$start=$row['start_date'];
		$end=$row['end_date'];
		//$row = mysqli_fetch_assoc($result5);
		//$price=$row['price'];
		$row = mysqli_fetch_assoc($result5);
		$userId=$row['user_id'];
		$query7="SELECT user_firstname , user_lastname FROM user WHERE user_id='userId'";
		$row = mysqli_fetch_assoc($result6);
		$categoryName=$row['category_name'];
		$row = mysqli_fetch_assoc($result7);
		$sellerName=$row['user_firstname' , 'user_lastname'];
	}
}
if ($offerQuantity==$orderQuantity) {
	
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Deals</title>
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
				<a class="navbar-brand" href="#">Deals</a>
			</div>
		</div>
	</nav>

<div class="container">
	<div class="col-sm-12 price-form">
		<div class="row price-form-row" ng-if="!addListing">
		<div class="col-sm-6">
			<div class="input-group">
				<span class="input-group-addon">Min Price</span>
				<textarea name="minPrice" id="minPrice" ng-model="priceInfo.min" class="form-control"></textarea> 
					
			</div>
		</div>

		<div class="col-sm-6">
			<div class="input-group">
				<span class="input-group-addon">Max Price</span>
				<textarea name="maxPrice" id="maxPrice" ng-model="priceInfo.max" class="form-control"></textarea> 
					
			</div>
		</div>
	</div>
	<div class="container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
		<div class="col-sm-4" ng-repeat="offer in offers | storeFilter:priceInfo | orderBy: '-id'">
			<div class="thumbnail">
				<img ng-src="images/{{offer.image}}.jpg" alt="" />
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						<h3><i class="glyphicon glyphicon-tag"></i>{{ offer.discount | currency}} <?php $discount ?> </h3>
						<p class="label label-primary label-sm">Seller Name: {{offer.SellerName}} <?php $sellerName ?> </p>
						<p class="label label-primary label-sm">Offer Name: {{offer.offer}} <?php $offerName ?> </p>
						<!--<p class="label label-primary label-sm">Quantity: {{offer.quantity}} <?php $offerQuantity ?></p>-->
							<span class="label label-primary label-sm">{{ offer.type }} <?php $categoryName ?> </span>
						</h4>
					</div>

					<button class="btn btn-xs btn-success"
									ng-hide="showDetails === true"
									ng-click="showDetails = !showDetails">
										Details
					</button>

					<div class="details" ng-show="showDetails ===true">
						<h4>
							<!--<span class="label label-primary">Image: {{offer.image}}</span>-->
							
							<span class="label label-primary">Start Date: {{offer.details.start}} <?php $start ?></span>
							<span class="label label-primary">End Date: {{offer.details.end}} <?php $end ?></span>
						</h4>

				
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