<?php
include ('include/connection.php');
session_start();
include ('include/functions.php');
$userID=$_SESSION['logInId'];
//$productName = $discription="";
$wishID=$_GET['wishid'];
    
    $alertMessage = "<div class='alert alert-danger'><p>Are you sure you want to cancle this wish? No take baks!</p><br>
    <form method='post'>
        <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='yes, delete!'>
        <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!S</a>
    </form>
    </div>";

if (isset($_POST['confirm-delete'])){
     $status="canceled";
    $query = "UPDATE wish SET status='$status', cancel_date= CURRENT_TIMESTAMP WHERE wish_id = '$wishID'";
    $result = mysqli_query($conn, $query);
   
    if ($result) {
        
        header("Location: wishes.php?alert=canceled");
    }else{
        echo "Error updating record: ".mysql_error($conn);
    }
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Comptible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Chat</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">	
<body ng-app="ngStore" ng-controller="storeController">
<div class="container">
<?php echo  $alertMessage; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>