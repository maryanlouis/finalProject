<?php
	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: GrouBuy.php");
	}
	include ('include/connection.php');
	include ('include/functions.php');
	$userID=$_SESSION['logInId'];
	$mycomments = array();
	
	$comment=$commentText=$alertMessage="";
	
	 	$query= "SELECT * FROM comment WHERE deleted=0 ";

				$result= mysqli_query($conn, $query);
				
				 if (mysqli_num_rows($result) > 0){
					while ($row = mysqli_fetch_assoc($result)) {
						$query2="SELECT user_firstname FROM user WHERE user_id=".$row['user_id'];
				 		$result2 = mysqli_query($conn, $query2);
				 		$row2 = mysqli_fetch_assoc($result2);
				 		$row['user']=array_values($row2);
						$mycomments[]= $row;
						
					}
			
				 }
	 				else{
					$alertMessage = "<div class='alert alert-warning'>Nothing to see here.<a href='clients.php'>Head back</a></div>";
					}
					
	

	


	mysqli_close($conn);
	//include ('includes/header.php'); 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Forum</title>
     <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body ng-app="ngChat" ng-controller="chatController">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Chat</a>
            </div>
            <a class="navbar-brand navbar-right"  href="GrouBuy.php">Home</a>
            <a class="navbar-brand navbar-right" href="logout.php">Logout??</a>
            <a class="navbar-brand navbar-right" href="#"><?php 
				echo isset($_SESSION['loggedInUser'])?$_SESSION['loggedInUser']:' ';
			?></a>
        </div>
    </nav>
<?php echo $alertMessage;?>
<iframe src="addcomment.php" height="150" width="1000"> </iframe>
  <frame src="addcomment.php">
  <frame src="editcomment.php">
  <frame src="deletecomment.php">


    <div class="container">
        <div class="col-sm-4">
        	 <?php
	foreach ($mycomments as $val) {
?>
            <div class="thumbnail">

                <div class="caption">

                    <div ng-hide="showDetails === true">
                        <h4>
                        	
                            <p class="label label-primary label-sm">Name: <?php echo $val['user'][0]; ?></p>
               
                            <br><br>
                           
                            <p class="label label-primary label-sm">Comments: <?php echo $val['commentText'];?></p>
                             
                        </h4>
                    </div>

                    <button class="btn btn-xs btn-success" ng-hide="showDetails === true"
                        ng-click="showDetails = !showDetails">
                        Details
                    </button>
                    <div class="details" ng-show="showDetails ===true">
                        <h4>
                         
                            <p class="label label-primary label-sm">Time: <?php echo $val['datenow'];?></p>
                         
							<a href="editcomment.php?commentid=<?php echo $val['comment_id']; ?>" class="btn btn-success" ng-show="showDetails" >Edit</a>
							<a href="addcomment.php?option=<?php echo $val['comment_id']; ?>" class="btn btn-success" ng-show="showDetails" >Reply</a>
								<a href="deletecomment.php?commentid=<?php echo $val['comment_id']; ?>" class="btn btn-danger listing-button" ng-show="showDetails" name="delete">Delete</a>
                            <button class="btn btn-xs btn-danger" ng-show="showDetails === true"
                                ng-click="showDetails = !showDetails">
                                Close
                            </button>
                        </h4>
                    </div>

                </div>
          
            </div>
      <?php
	}
?>
        </div>
    </div>
<script src="scripts/angular.min.js"></script>
    <script src="scripts/ui-bootstrap.min.js"></script>
    <script src="scripts/ui-bootstrap-tpls.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="app2.js"></script>
    <script src="scripts/chatController.js"></script>
    <script src="scripts/chatFactory.js"></script>
    <script src="scripts/chatFilter.js"></script>
</body>


</html>