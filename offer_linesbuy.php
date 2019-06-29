<?php
	include ('include/connection.php');
	session_start();
	if (!$_SESSION['loggedInUser']) 
	{
		header("Location: signUp.php");
	}
	include ('include/functions.php');
	$alertMessage="";
	$myproducts = array();
	$_SESSION['offer_number'] = $_GET['offer_number'];
	$Query = "SELECT product.*,offer_line.* FROM `offer_line` inner join product on product.product_id = offer_line.product_id WHERE offer_line.offer_number =".$_SESSION['offer_number'];
	$result = mysqli_query($conn, $Query);
	if (mysqli_affected_rows($conn) > 0  ){
	while($row = mysqli_fetch_assoc($result) ) {
		$myproducts[]=$row;
	}
}
	mysqli_close($conn);
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Offer Contents</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body ng-app="ngStore" ng-controller="storeController">
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Store</a>
			</div>
			<a class="navbar-brand navbar-right"  href="GrouBuy.php">Home</a>
			<a class="navbar-brand navbar-right" href="logout.php">Logout??</a>
			<a class="navbar-brand navbar-right" href="#"><?php 

					echo isset($_SESSION['loggedInUser'])?$_SESSION['loggedInUser']:' ';

					?></a>
		</div>
	</nav>

<div class="container">
	<div class="col-sm-12 price-form" method="post">
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
		
	<h3>Offer content</h3>

	<div class="row listing-form-row">
		<?php echo $alertMessage; ?>
	<div class="container">
	<?php 
		foreach ($myproducts as $val) {
	?>
		<div class="col-sm-4">
			<div class="thumbnail">
			<a href="#"><img ng-src="images/<?php echo $val['img']; ?>.jpg" alt="" /></a>
				<div class="caption">
					<div ng-hide="showDetails === true">
						<h3><i class="glyphicon glyphicon-tag"></i>Price:<?php echo  $val['price']; ?></i></h3>
						<p class="label label-primary label-sm">Product Name:<?php echo $val['product_name']; ?> </p>
						<p class="label label-primary label-sm">Discription:<?php echo $val['discrption']; ?></p>
						<p class="label label-primary label-sm">Quantity:<?php echo $val['quantity']; ?></p>	
					</div>
				</div>
			</div>
		</div>
		<?php
							}
						?>
	</div>
</div>
</div>


<script src="scripts/angular.min.js"></script>
    <script src="scripts/ui-bootstrap.min.js"></script>
    <script src="scripts/ui-bootstrap-tpls.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

<script src="app.js"></script>
<script src="scripts/storeController.js"></script>
<script src="scripts/storeFactory.js"></script>
<script src="scripts/storeFilter.js"></script>
</body>

</html>