<?php 
$FinalDeals = array();
include ('include/connection.php');
	session_start();
	include ('include/functions.php');
$requestedOffers ="SELECT SUM(order_line.quantity) as qunant , order_line.offer_number as num from order_line GROUP by offer_number";
$result1 = mysqli_query($conn, $requestedOffers);
while ($row = mysqli_fetch_assoc($result1)) {
	$getDeals = "SELECT offer.* FROM `offer_line`
				INNER JOIN offer on offer.offer_number = offer_line.offer_number
				where offer_line.quantity <=";
	$getDeals .= $row['qunant'] ." and offer_line.offer_number =" .$row['num'];
	$run = mysqli_query($conn, $getDeals);
	$data =  mysqli_fetch_assoc($run);
	if(!empty($data)){
		$GetUSer = "SELECT user.user_firstname , user.user_lastname FROM `user` WHERE user.user_id =".$data['user_id'];
		$qu = mysqli_query($conn, $GetUSer);
		$user =  mysqli_fetch_assoc($qu);
		$data['user'] = array_values($user);
		$FinalDeals[]= $data;
	}
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Deals</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="style.css">
</head>

<body ng-app="ngStore" ng-controller="storeController">
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Deals</a>
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

    <div class="container">
        <div class="col-sm-12 price-form">
            <div class="row price-form-row" ng-if="!addListing">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">Min Price</span>
                        <textarea name="minPrice" id="minPrice" ng-model="priceInfo.min"
                            class="form-control"></textarea>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">Max Price</span>
                        <textarea name="maxPrice" id="maxPrice" ng-model="priceInfo.max"
                            class="form-control"></textarea>

                    </div>
                </div>
            </div>
        </div>
      
        <div class="container">
        <?php
		foreach ($FinalDeals as $val) {
	?>
            <!-- <div class="col-sm-4"> -->
                <div class="thumbnail col-lg-3">
                    <img ng-src="images/<?php echo $val['image'] ?>.jpg" alt="" />
                    <div class="caption">
                        <!--<h3>{{crib.address}}</h3>
					<p><strong>Type:</strong>{{ crib.type }}</p>
					<p><strong>Description:</strong>{{ crib.description}}</p>
					<p><strong>Price:</strong>{{ crib.price | currency}}</p>-->
                        <div ng-hide="showDetails === true">
                            <h3><i class="glyphicon glyphicon-tag"></i> <?php echo $val['discount'] ?> </h3>
                            <p class="label label-primary label-sm">Seller Name: <?php echo $val['user'][0] . $val['user'][1] ?> </p>
                            <p class="label label-primary label-sm">Offer Name: <?php echo $val['offer_name'] ?> </p>


                        </div>

                        <button class="btn btn-xs btn-success" ng-hide="showDetails === true"
                            ng-click="showDetails = !showDetails">
                            Details
                        </button>

                        <div class="details" ng-show="showDetails ===true">
                            <h4>
                                <!--<span class="label label-primary">Image: {{offer.image}}</span>-->

                                <span class="label label-primary">Start Date: <?php echo $val['start_date'] ?>
                                    <?php $start ?></span>
                                <span class="label label-primary">End Date: <?php echo $val['end_date'] ?></span>
                            </h4>
                            <button class="btn btn-xs btn-danger"
                                    ng-show="showDetails === true"
                                    ng-click="showDetails = !showDetails">
                                        Close
                            </button>

                        </div>
                    </div>
                </div>
                <?php
		}
	?>
            <!-- </div> -->
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

<script src="scripts/angular.min.js"></script>
    <script src="scripts/ui-bootstrap.min.js"></script>
    <script src="scripts/ui-bootstrap-tpls.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

<script src="app.js"></script>
<script src="scripts/storeController.js"></script>
<script src="scripts/storeFactory.js"></script>
<script src="scripts/storeFilter.js"></script>

</html>