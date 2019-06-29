<?php
include ('include/connection.php');
session_start();
include ('include/functions.php');
$userID=$_SESSION['logInId'];
//$productName = $discription="";
$wishID=$_GET['wishid'];
    
        $counter=$_GET['counter']+1;
        $query="UPDATE wish SET counter ='$counter' WHERE wish_id= '$wishID' ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: wishes.php?alert=countersuccess");
        }else{
            echo "Error updating record: ".mysql_error();
        }

mysqli_close($conn);

?>