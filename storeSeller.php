<?php
 $myoffer = array();

include ('include/connection.php');
	session_start();
	if (isset($_SESSION['loggedInUser'])) {
		$ID=$_SESSION['logInId'];
$qu="SELECT user_id FROM buyer WHERE user_id= '$ID'";

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
	
	if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
	
	include ('include/functions.php');
	
            $userId =  mysqli_query($conn,"SELECT user_id FROM seller");
            $user_id  = mysqli_fetch_assoc($userId);
            $sellerId=$user_id['user_id'];
            $query = "SELECT * FROM offer WHERE user_id='$sellerId' and deleted=0";
            $result = mysqli_query($conn, $query);
			$firstname=mysqli_query($conn,"SELECT user_firstname FROM user WHERE user_id = '$sellerId'");
            $row1 = mysqli_fetch_assoc($firstname);
            $firstName=$row1['user_firstname'];
            $lastname=mysqli_query($conn,"SELECT user_lastname FROM user WHERE user_id = '$sellerId'");
            $row2 = mysqli_fetch_assoc($lastname);
            $lastName=$row2['user_lastname'];
            if (mysqli_num_rows($result) > 0  ){
			while($row = mysqli_fetch_assoc($result) ) {
            $myoffer[]=$row;
		}
	}else{
		$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
    }
   
	mysqli_close($conn);
	//include ('includes/header.php');  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Store</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body ng-app="ngStore" ng-controller="storeController">
    <!-- navbar section -->
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
            <a class="navbar-brand navbar-right"
                href="#"><?php echo isset($_SESSION['loggedInUser'])?$_SESSION['loggedInUser']:' ';?></a>
        </div>
    </nav>
    <!-- navbar section -->

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

            <a class="btn btn-primary" href="addoffer.php" id="add">Add Listing</a>

             <a class="btn btn-info mymargin" href="deleted_offer.php?">See deleted offers?</a>
            <button class="btn btn-danger" ng-click="addListing = !addListing" ng-show="addListing">Close</button>

        </div>
    </div>

   
    <div class="container">

        <!-- <div class="row"> -->
            <!-- <div class="col-sm-4"> -->
            <?php
	    foreach ($myoffer as $val) {
        ?>
                <div class="thumbnail col-lg-3">

                    <a role="button" href="offer_lines.php?offer_number=<?php echo $val['offer_number'] ?>">

                        <img src="images/<?php echo $val['image']; ?>.jpg" alt="ahe" />

                    </a>

                    <div class="caption">

                        <div ng-hide="showDetails === true">

                            <h3><i class="glyphicon glyphicon-tag"></i><?php echo $val['discount']; ?></h3>

                            <p class="label label-primary label-sm">Seller Name:<?php echo $firstName; ?>
                                <?php echo $lastName; ?> </p>

                            <p class="label label-primary label-sm">Offer Name:<?php echo $val['offer_name']; ?></p>

                        </div>

                        <button class="btn btn-xs btn-success" ng-hide="showDetails === true"
                            ng-click="showDetails = !showDetails"> Details </button>

                            

                        <button class="btn btn-xs btn-danger" ng-show="showDetails === true"
                            ng-click="showDetails = !showDetails"> Close </button>

                        <div class="details" ng-show="showDetails ===true">
                            <h4>
                                <!--<span class="label label-primary">Image: {{offer.image}}</span>-->
                                <span class="label label-primary">Start Date:<?php echo $val['start_date']; ?></span>
                                <span class="label label-primary">End Date:<?php echo $val['end_date']; ?></span>
                                <a class="btn btn-info mymargin" href="editoffer.php?offerid=<?php echo $val['offer_number']; ?>">Edit</a>
                                <a class="btn btn-danger mymargin" href="deactivateoffer.php?offerid=<?php echo $val['offer_number']; ?>&option=1">Delete</a>
                            </h4>
                        </div>

                    </div>

                </div>
                <?php
      }
    ?>
            <!-- </div> -->
        <!-- </div> -->
    </div>
   

    <script src="scripts/angular.min.js"></script>
    <script src="scripts/ui-bootstrap.min.js"></script>
    <script src="scripts/ui-bootstrap-tpls.min.js"></script>
    <script src="app.js"></script>
    <script src="scripts/storeController.js"></script>
    <script src="scripts/storeFactory.js"></script>
    <script src="scripts/storeFilter.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>