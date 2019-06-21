<?php
	session_start();

	/*if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
	}*/
	include ('include/connection.php');
	include ('include/functions.php');
	if (isset($_POST['add'])) {
		$productName = $discription="";

		if (!$_POST["product"]) {
			$productError="Please enter a name of a product you wish <br>";
		}else{
			$productName=validateFormData($_POST["product"]);
		}

		if (!$_POST["discription"]) {
			$discriptionError="Please the discription of your product <br>";
		}else{
			$discription=validateFormData($_POST["discription"]); 
		}
		$counter =0;

		if ($productName && $discription) {
			$counter +=1;
			$status = "active";
			$_SESSION['user_id']=mysqli_query($conn,"SELECT LAST_INSERT_ID() as user_id FROM user");
			$row = mysqli_fetch_assoc($_SESSION['user_id']);
				$userId=$row['user_id'];
			$query = "INSERT INTO wish( wishname,discription, counter, status, publishdate, cancle_date, user_id)VALUES(NULL, '$clientName', '$clientEmail', '$clientPhone', '$clientAddress', CURRENT_TIMESTAMP, ' ', '$user_id')";

			$result = mysqli_query($conn, $query);

			if ($result) {
				header("Location: wishes.php?alert=success");
			}else{
				echo "Error: ".$query."<br>".mysqli_error($conn);
			}
		}
	}

	$wishID = $_GET['wish_id'];

	$query = "SELECT * FROM wish WHERE wish_id='$wishID'";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			$productName = $row['product_name'];
			$discription = $row['discription'];
			$counter = $row['counter'];
			$status = $row['status'];
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='wishes.php'>Head back</a></div>";
	}

	if (isset($_POST['edit'])) {
		$productName = validateFormData($_POST["productName"]);
		$discription = validateFormData($_POST["discription"]);
	
		$query="UPDATE wish
			SET wishname='$productName',
			discription='$discription',
			WHERE wish_id='$wishID'";

		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: wishes.php?alert=updatesuccess");
		}else{
			echo "Error updating record: ".mysql_error();
		}
	} 

	if (isset($_POST['delete'])) {
		$alertMessage = "<div class='alert alert-danger'><p>Are you sure you want to delete this client? No take baks!</p><br>
		<form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$clientID' method='post'>
			<input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='yes, delete!'>
			<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!S</a>
		</form>
		</div>";
	}

	if (isset($_POST['confirm-delete'])){
		 $status="canceled";
		$query = "INSERT INTO wish(cancle_date) WHERE wish_id = $wishID";
		$result = mysqli_query($conn, $query);
    $updateStatus="UPDATE wish SET status='$status'";
		if ($result&&$updateStatus) {
			header("Location: wishes.php?alert=deleted");
		}else{
			echo "Error updating record: ".mysql_error($conn);
		}
	}
	mysql_close();
	//include ('includes/header.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Wishes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body ng-app="ngStore" ng-controller="storeController">
<?php echo $alertMessage; ?>
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
				<a class="navbar-brand" href="#">Wishes</a>
			</div>
		</div>
	</nav>

<div class="container">
	<div class="col-sm-12 price-form">

		<button class="btn btn-primary" ng-click="addListing = !addListing" ng-show="!addListing" id="add">Add Listing</button>

		<button class="btn btn-danger" ng-click="addListing = !addListing" ng-show="addListing">Close</button>

		<div class="listing-form" ng-if="addListing" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
			<h3>Add a Listing</h3>

			<div class="row listing-form-row">
				<!--<div class="col-sm-4">
					<div class="input-group" id="Name">
						<span class="input-group-addon">Name</span>
						<input type="text" placeholder="Enter the name" class="form-control" ng-model="newListing.SellerName">
					</div>
				</div>-->
				<div class="col-sm-4">
					<div class="input-group" id="offerName">
						<span class="input-group-addon">Product Name</span>
						<input type="text"  placeholder="Enter the Product Name you wish" name="product" class="form-control" ng-model="newListing.offer">
					</div>
				</div>

				<div class="col-sm-4">
					<div class="input-group" id="description">
						<span class="input-group-addon">Description</span>
						<textarea type="text" placeholder="Enter the description" name="discription" class="form-control" ng-model="newListing.description"></textarea> 
					</div>
				</div>

			</div>

			<button class="btn btn-primary listing-button" ng-click="addOffer(newListing)" name="add" ng-show="addListing">Add</button>
			<pre>{{newListing | json}}</pre>
			
		</div>
		<div class="listing-form" ng-if="editListing" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?user_id=<?php echo $usertID; ?>" method="post">
	<h3>Edit Listing</h3>

	<div class="row listing-form-row">
				<!--<div class="col-sm-4">
					<div class="input-group" id="Name">
						<span class="input-group-addon">Name</span>
						<input type="text" placeholder="Enter the offer no." class="form-control" ng-model="existingListing.SellerName">
					</div>
				</div>-->

			
				<div class="col-sm-4" id="offerName">
					<div class="input-group">
						<span class="input-group-addon">Product Name</span>
						<input type="text" placeholder="Enter the Product Name" name="product" class="form-control" ng-model="existingListing.offer">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="input-group" id="description">
						<span class="input-group-addon">Description</span>
						<textarea type="text" placeholder="Enter the description" class="form-control" ng-model="existingListing.description"></textarea> 
					</div>
				</div>

				
			
			</div>


			<button class="btn btn-primary listing-button" ng-click="saveOfferEdit()" ng-show="editListing" name="edit" id="edit">Save</button>

			<button class="btn btn-danger listing-button" ng-click="deleteOffer(existingListing)" ng-show="editListing" id="delete" name="delete">Delete</button>
	</div>
</div>
	</div>
</div>

	<div class="container">
		<div class="col-sm-4" ng-repeat="offer in offers | storeFilter:priceInfo | orderBy: '-id'">
			<div class="thumbnail">
				
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						
						<p class="label label-primary label-sm">Name: {{offer.offer}}</p>
							
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

					
						<p>Description: {{offer.description}}</p>
					
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