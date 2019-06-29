<?php
 $myoffer = array();
include ('include/connection.php');
	session_start();
		if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
	
	include ('include/functions.php');
	
	//$user_id=mysqli_fetch_assoc($q);
	
	
			//$name = $_SESSION['loggedInUser'] . ' '.$_SESSION['user_lastname'];
            $userId =  mysqli_query($conn,"SELECT user_id FROM seller");
            $user_id  = mysqli_fetch_assoc($userId);
            $sellerId=$user_id['user_id'];
            $query = "SELECT * FROM offer WHERE user_id='$sellerId' and deleted=1";
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
   

?>
<!DOCTYPE html>
<html>
<head>
	<head>
    <meta charset="utf-8">
	<title>Deleted offers</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body ng-app="ngStore" ng-controller="storeController">
	 <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Deleted offers</a>
            </div>
            <a class="navbar-brand navbar-right" href="logout.php">Logout??</a>
            <a class="navbar-brand navbar-right"
                href="#"><?php echo isset($_SESSION['loggedInUser'])?$_SESSION['loggedInUser']:' ';?></a>
        </div>
    </nav>
       <?php
	foreach ($myoffer as $val) {
?>
    <div class="container">

        <div class="row">
            <div class="col-sm-4">

                <div class="thumbnail">

                    <a role="button" href="products.php?offer_number=<?php echo $val['offer_number'] ?>">

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
                       
                                <a class="btn btn-danger mymargin" href="deactivateoffer.php?offerid=<?php echo $val['offer_number']; ?>&option=0">Restore</a>
                            </h4>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
      }
    ?>
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