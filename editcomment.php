<?php
include ('include/connection.php');
session_start();

    include ('include/functions.php');
    $userID=$_SESSION['logInId'];

    $comment_id = $_GET['commentid'];
    if (isset($_POST['edit'])) {
		$commentText = validateFormData($_POST["comment"]);

		$query="UPDATE comment SET commentText='$commentText' WHERE user_id='$userID' AND comment_id='$comment_id'";

		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: forum.php?alert=updatesuccess");
		}else{
			echo "Error updating record: ".mysql_error();
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
</head>
<body>
<div class="container">
        
        <div class="listing-form" ng-if="editListing">
            <h3>Edit Listing</h3>
    
            <div class="row listing-form-row">
               
            <form id="edit" method="post">
                <div class="col-sm-4">
                    <div class="input-group" id="comment">
                        <textarea type="text" placeholder="edit your post" class="form-control"
                            ng-model="existingListing.comment" name="comment"></textarea>
                    </div>
                </div>
    
                <button class="btn btn-primary listing-button" ng-click="saveCommentEdit()" ng-show="editListing" id="edit" name="edit">Save</button>
                </form>
            </div>
        </div>
    
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>