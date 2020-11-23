<?php
$recommendtions = [];
include ('include/connection.php');
session_start();
include ('include/functions.php');
$user_id = $_SESSION['logInId'];
$Recommendtion_Query = "
SELECT * from offer WHERE offer_number IN 
(
    SELECT DISTINCT offer.offer_number from offer_line
    INNER JOIN offer on offer.offer_number = offer_line.offer_number
    where offer_line.product_id in 
    (
                SELECT product.product_id from product 
                where category_id IN 
                (
                        SELECT product.category_id FROM offer_line
                        INNER join product on product.product_id = offer_line.product_id
                        where offer_line.offer_number IN 
                        (
                            SELECT `order_line`.`offer_number` FROM `order_line`
                            INNER JOIN `order` ON `order`.`order_id`= order_line.order_id
                            where `order`.`user_id`= '$user_id'
                        )
                )
    )
) AND  offer_number NOT IN 
    (
        SELECT `order_line`.`offer_number` FROM `order_line`
        INNER JOIN `order` ON `order`.`order_id`= order_line.order_id
        where `order`.`user_id`= '$user_id'
    )
";
$q = mysqli_query($conn, $Recommendtion_Query);
if ($q->num_rows > 0) {
    while($row = mysqli_fetch_assoc($q)){
        $recommendtions[] = $row;
    }
}
else {
    $Recommendtion_Query = "select * from offer";
    $q = mysqli_query($conn, $Recommendtion_Query);
    if ($q->num_rows > 0) {
        while($row = mysqli_fetch_assoc($q)){
        $recommendtions[] = $row;
        }
    }
        $No_Recommendtions = "there is no recommendtions becuase client did not buy any offers before , or there is no related offers";
    

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
        <!-- <div class="col-sm-12"> -->
        <p class="label label-primary label-large "><?php 
        if(isset($No_Recommendtions)){
            echo $No_Recommendtions."<br>";
              
        }?></p>
        <br><br>
        <?php
    foreach ($recommendtions as $val) {
?>
        <div class="thumbnail col-lg-3">
       
       
            <a href="offer_linesbuy.php?offer_number=<?php echo $val['offer_number']?>"><img
                    ng-src="images/<?php echo $val['image']; ?>.jpg" alt="" /></a>
            <div class="caption">

                <div ng-hide="showDetails === true">
                    <h3><i class="glyphicon glyphicon-tag"></i><?php echo $val['discount']; ?> </h3>
                    <br>
                    
                    <br>
                    <p class="label label-primary label-sm">Offer Name: <?php echo $val['offer_name']; ?> </p>
                    <br><br>

                </div>

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
                        <a href="order.php?userid=<?php echo $ID;?>"
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