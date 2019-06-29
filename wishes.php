<?php
include ('include/connection.php');
	session_start();
	$mywishes = array();
	if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
	if (isset($_SESSION['loggedInUser'])) {
		$ID=$_SESSION['logInId'];
	$qu="SELECT user_id FROM seller WHERE user_id= '$ID'";
	
	$q=mysqli_query($conn,$qu);
	if (mysqli_num_rows($q)>0) {
		while ($row = mysqli_fetch_assoc($q)) {
			$id=$row['user_id'];
			if (isset($id)) {
		echo "Not allowed";
			header("Location: GrouBuy.php");
			}
		}		
	}
		
}
	
	include ('include/functions.php');

		$alertMessage="";

	$query = "SELECT * FROM wish ";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)) {
            $qu="SELECT user_firstname FROM user WHERE user_id= ".$row['user_id'];
            $res = mysqli_query($conn, $qu);
            $row1= mysqli_fetch_assoc($res);
            $row['user']=array_values($row1);
			$mywishes[]=$row;
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='wishes.php'>Head back</a></div>";
	}
	

	
	mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Wishes</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body ng-app="ngStore" ng-controller="storeController">
    <?php echo $alertMessage; ?>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Wishes</a>
            </div>
            <div>
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" name="searchText" class="form-control" placeholder="Search site...">
                    </div>
                    <button type="submit" name="search" class="btn btn-primary">Go!</button>
                </form>
                <a class="navbar-brand navbar-right"  href="GrouBuy.php">Home</a>
                <a class="navbar-brand navbar-right" href="logout.php">Logout??</a>
                <a class="navbar-brand navbar-right" href="#"><?php 

					echo isset($_SESSION['loggedInUser'])?$_SESSION['loggedInUser']:' ';

					?></a>
            </div>
        </div>
    </nav>
	<form method="post" >
    <div class="container">
        <div class="col-sm-12 price-form">
	
		<a href="addwish.php" class="btn btn-primary" ng-click="addListing = !addListing" ng-show="!addListing" id="add">Add Listing</a>
		
		<button class="btn btn-danger" ng-click="addListing = !addListing" ng-show="addListing">Close</button>

            
        </div>
    </div>
	</form>
    <?php 
		foreach ($mywishes as $val) {
	?>
    <div class="container">
        <div class="col-sm-4">
            <div class="thumbnail">

                <div class="caption">

                    <div ng-hide="showDetails === true">

                        <p class="label label-primary label-sm">Name: <?php echo $val['user'][0] ?></p>
                        <p class="label label-primary label-sm">Wish Name: <?php echo $val['wishname']; ?></p>
                        <p class="label label-primary label-sm">Discription: <?php echo $val['discrption']; ?></p>
                        </h4>
                    </div>
					<br>
                    <button class="btn btn-xs btn-success" ng-hide="showDetails === true"
                        ng-click="showDetails = !showDetails">
                        Details
                    </button>
				   <a  href="wishcounter.php?wishid=<?php echo $val['wish_id']?>&counter=<?php echo $val['counter']?>" class="btn btn-success" ng-show="showDetails" name="counter">Add to counter</a>
                    <button class="btn btn-xs btn-danger" ng-show="showDetails === true"
                        ng-click="showDetails = !showDetails">
                        Close
                    </button>

                    <div class="details" ng-show="showDetails ===true">
                        <h4>

                            <span class="label label-primary">Publish Date:<?php echo $val['publishdate']; ?></span>
                            <span class="label label-primary">CAncle Date:<?php echo $val['cancel_date']; ?></span>
                            <br>
                            <span class="label label-primary">Number of People:<?php echo $val['counter']; ?></span>
                            <span class="label label-primary">Status:<?php echo $val['status']; ?></span>
							<br><br>
							<a href="editwish.php?wishid=<?php echo $val['wish_id']?>" class="btn btn-success" ng-show="showDetails" ng-click="editOffer(offer)">Edit</a>
							
							<a href="canclewish.php?wishid=<?php echo $val['wish_id']?>" class="btn btn-danger listing-button" ng-click="deleteOffer(existingListing)" ng-show="showDetails" id="delete" name="delete">cancle your wish</a>
                        </h4>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
		}
	?>

</body>
<script src="scripts/angular.min.js"></script>
<script src="scripts/ui-bootstrap.min.js"></script>
<script src="scripts/ui-bootstrap-tpls.min.js"></script>
<script src="app.js"></script>
<script src="scripts/storeController.js"></script>
<script src="scripts/storeFactory.js"></script>
<script src="scripts/storeFilter.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</html>