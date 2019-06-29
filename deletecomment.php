<?php
include ('include/connection.php');
session_start();

    include ('include/functions.php');
    $comment_id = $_GET['commentid'];
    $userID=$_SESSION['logInId'];
    //if (isset($_POST['delete'])) {
		$alertMessage = "<div class='alert alert-danger'><p>Are you sure you want to delete this client? No take baks!</p><br>
		<form method='post'>
			<input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='yes, delete!'>
			<a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, no thanks!S</a>
		</form>
		</div>";
	//}

	if (isset($_POST['confirm-delete'])){
		$query="UPDATE comment
		SET deleted=1
		WHERE user_id='$userID' AND comment_id='$comment_id'";

		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: forum.php?alert=updatesuccess");
		}else{
			echo "Error updating record: ".mysql_error();
		}
			header("Location: forum.php?alert=deleted");
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
</head>
<body>
<div class="container">
        
       <?php echo $alertMessage?>
    
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>