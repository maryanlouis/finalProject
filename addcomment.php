<?php
include ('include/connection.php');
session_start();

    include ('include/functions.php');
    $userID=$_SESSION['logInId'];
     if (!isset($_GET['option'])) {
           $option='NULL'; 
        }else{
    $option=$_GET['option'];
}
if (isset($_POST['add'])) {
		
    $comment=validateFormData($_POST["comment"]);


    if ($comment) {
       
        $query1 = "INSERT INTO `comment`(datenow,commentText, deleted,parent,user_id)VALUES(CURRENT_TIMESTAMP,'$comment',0,$option,'$userID')";
        $result1 = mysqli_query($conn, $query1);
        if($result1){
            header("Location: forum.php?alert=success");
        }else{
            echo "Error: ".$query1."<br>".mysqli_error($conn);
        }
    }
}
//}
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
            <h3>Chat</h3>
            <div class="row listing-form-row">
			<form id="add" method="post">
                <div class="col-sm-4">
                    <div class="input-group" id="comment">

                        <textarea type="text" placeholder="Enter what you think about" name="comment" class="form-control" ng-model="newListing.comment"></textarea>
                    </div>
                </div>

                <button  class="btn btn-primary listing-button" name="add">Send</button>
                <pre>{{newListing | json}}</pre>
				</form>
            </div>
            
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>