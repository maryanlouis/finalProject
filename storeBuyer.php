<?php
include ('include/connection.php');
	session_start();
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
	if (!$_SESSION['loggedInUser']) {
		header("Location: GrouBuy.php");
	}
	
	include ('include/functions.php');
	$myoffer = array();
$query=mysqli_query($conn, "SELECT * FROM offer WHERE deleted=0");
if (mysqli_num_rows($query) > 0){
	while ($row = mysqli_fetch_assoc($query)) {
		$query2="SELECT user_firstname, user_lastname FROM user WHERE user_id=".$row['user_id'];
		 $result2 = mysqli_query($conn, $query2);
		 $row2 = mysqli_fetch_assoc($result2);
		 $row['user']=array_values($row2);
		$myoffers[]= $row;
		
	}

 }
	 else{
	$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
	}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Store</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body ng-app="ngStore" ng-controller="storeController">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Store</a>
            </div>
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
        </div>
    </div>
    <!--<button class="btn btn-primary listing-button" ng-click="saveOfferEdit()" ng-show="editListing" id="edit">Save</button>

			<button class="btn btn-danger listing-button" ng-click="deleteOffer(existingListing)" ng-show="editListing" id="delete">Delete</button>-->

    <div class="container">
        <!-- <div class="col-sm-12"> -->
        <?php
	foreach ($myoffers as $val) {
?>
        <div class="thumbnail col-lg-3">
            <a href="offer_linesbuy.php?offer_number=<?php echo $val['offer_number']?>"><img
                    ng-src="images/<?php echo $val['image']; ?>.jpg" alt="" /></a>
            <div class="caption">

                <div ng-hide="showDetails === true">
                    <h3><i class="glyphicon glyphicon-tag"></i><?php echo $val['discount']; ?> </h3>
                    <br>
                    <p class="label label-primary label-sm">Seller Name:
                        <?php echo $val['user'][0]; echo $val['user'][1] ;?> </p>
                    <br>
                    <p class="label label-primary label-sm">Offer Name: <?php echo $val['offer_name']; ?> </p>
                    <br>

                </div>

                <a href="order_line_quantity.php?offerid=<?php echo $val['offer_number'];?>" role="button"
                    name="addToCard" class="btn btn-info btn-xs">Add to card?</a>

                <button class="btn btn-xs btn-success" ng-hide="showDetails === true"
                    ng-click="showDetails = !showDetails">
                    Details
                </button>

                <button class="btn btn-xs btn-danger" ng-show="showDetails === true"
                    ng-click="showDetails = !showDetails">
                    Close
                </button>

                <div class="details" ng-show="showDetails ===true">
                    <h4>
                        <a href="order.php?offerid=<?php echo $val['offer_number'];?>&userid=<?php echo $val['user_id'];?>"
                            role="button" name="finish" class="btn btn-info btn-xs">finish an order</a>

                        <p class="label label-primary label-sm">Start Date: <?php echo $val['start_date']; ?> </p>
                        <br>
                        <p class="label label-primary label-sm">End Date: <?php echo $val['end_date']; ?> </p>
                    </h4>

                </div>
            </div>
        </div>
        <?php
	}
?>
        <!-- </div> -->
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