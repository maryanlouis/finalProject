<?php
	session_start();

	/*if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
	}*/
	include ('include/connection.php');
	include ('include/functions.php');
	if (isset($_POST['add'])) {
		$comment="";
    $userID=$_GET["user_id"];
		$comment=validateFormData($_POST["comment"]);
		$name="SELECT user_firstname FROM user WHERE user_id='$userID'";

		if ($comment) {
			$query1 = "INSERT INTO comment(datenow,commentText)VALUES(CURRENT_TIMESTAMP,'$comment');";
		$_SESSION["parent"]=mysqli_query($conn, "SELECT LAST_INSERT_ID() FROM comment");
		$row = mysqli_fetch_assoc($_SESSION["parent"]);
    $parent=$row['comment_id'];
		$_SESSION["userID"]=mysqli_query($conn,"SELECT LAST_INSERT_ID() FROM user");
		$row = mysqli_fetch_assoc($_SESSION["userID"]);
    $userId=$row['user-id'];
		$_SESSION["offerId"]=mysqli_query($conn, "SELECT LAST_INSERT_ID() FROM offer");
		$row = mysqli_fetch_assoc($_SESSION["offerId"]);
    $userId=$row['offer_number'];
		$query2= "INSERT INTO comment(parent, user_id, offer_number)VALUES('$parent','$userID','$offerId')";
			$result1 = mysqli_query($conn, $query1);
			$result2 = mysqli_query($conn, $query2);
			if ($result) {
				header("Location: forum.php?alert=success");
			}else{
				echo "Error: ".$query."<br>".mysqli_error($conn);
			}
		}
	}
		$query = "SELECT * FROM comment WHERE user_id='$userID'; SELECT * FROM user WHERE user_id=$userID";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0){
		while ($row = mysqli_fetch_assoc($result)) {
			$Name = $row['user_firstname'];
			$commentText = $row['commentText'];
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
	}

	if (isset($_POST['edit'])) {
		$commentText = validateFormData($_POST["comment"]);

		$query="UPDATE comment
			SET commentText
			WHERE id='$userID'";

		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: forum.php?alert=updatesuccess");
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

			header("Location: forum.php?alert=deleted");
	}


	mysql_close();
	//include ('includes/header.php'); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Forum</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body ng-app="ngChat" ng-controller="chatController">

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
				<a class="navbar-brand" href="#">Chat</a>
			</div>
		</div>
	</nav>

<div class="container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $userID; ?>" method="post">

		<div class="listing-form">
			<h3>Chat</h3>

			<div class="row listing-form-row">
				<!--<div class="col-sm-4">
					<div class="input-group" id="name">
						<span class="input-group-addon">Name</span>
						<input type="text" placeholder="Enter the name" class="form-control" ng-model="newListing.name">
					</div>
				</div>-->

				<div clask2s="col-sm-4">
					<div class="input-group" id="comment">
						
						<textarea type="text" placeholder="Enter what you think about" name="comment" class="form-control" ng-model="newListing.comment"></textarea>
					</div>
				</div>
					
			<button class="btn btn-primary listing-button" ng-click="addComment(newListing)" name="add">Send</button>
			<pre>{{newListing | json}}</pre>
			
		</div>
	</div>
</div>
		<div class="listing-form" ng-if="editListing" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $userID; ?>" method="post">
	<h3>Edit Listing</h3>

	<div class="row listing-form-row">
				<!--<div class="col-sm-4">
					<div class="input-group" id="name">
						<span class="input-group-addon">Name</span>
						<input type="text" placeholder="Enter the name" class="form-control" ng-model="existingListing.name">
					</div>
				</div>-->

				<div class="col-sm-4">
					<div class="input-group" id="comment">
						<textarea type="text" placeholder="edit your post" class="form-control" ng-model="existingListing.comment" name="comment"></textarea>
					</div>
				</div>

			<button class="btn btn-primary listing-button" ng-click="saveCommentEdit()" ng-show="editListing" id="edit" name="edit">Save</button>

			<button class="btn btn-danger listing-button" ng-click="deleteComment(existingListing)" ng-show="editListing" id="delete" name="delete">Delete</button>
	</div>
</div>

	<div class="container">
		<div class="col-sm-4" ng-repeat="comment in comments | orderBy: '-id'">
			<div class="thumbnail">
				<div class="caption">
					<!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
					<div ng-hide="showDetails === true">
						<h4>
						<p class="label label-primary label-sm">Name: {{comment.name}}</p>
						<p class="label label-primary label-sm">Comments: {{comment.comment}}</p>
						</h4>
					</div>

					<button class="btn btn-xs btn-success"
									ng-hide="showDetails === true"
									ng-click="showDetails = !showDetails">
										Details
					</button>

					<button class="btn btn-success" ng-show="showDetails" ng-click="editComment(comment)">Edit</button>

					<button class="btn btn-xs btn-danger"
									ng-show="showDetails === true"
									ng-click="showDetails = !showDetails">
										Close
					</button>
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
<script src="app2.js"></script>
<script src="scripts/chatController.js"></script>
<script src="scripts/chatFactory.js"></script>
<!--<script src="scripts/chatFilter.js"></script>-->
</html>