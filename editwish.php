<?php
include ('include/connection.php');
session_start();
include ('include/functions.php');
$userID=$_SESSION['logInId'];
$productName = $discription="";
$wishID=$_GET['wishid'];
if (isset($_POST['edit'])) {
    
    if (!$_POST["product"]) {
        $productError="Please enter a name of a product you wish <br>";
    }else{
        $productName=validateFormData($_POST["product"]);
    }

    if (!$_POST["discription"]) {
        $discriptionError="Please the discription of your product <br>";
    }else{
        $discription=validateFormData($_POST["discription"]); 
    }
    $query="UPDATE wish SET wishname='$productName', discrption='$discription' WHERE wish_id='$wishID'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: wishes.php?alert=updatesuccess");
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

<body ng-app="ngStore" ng-controller="storeController">
    <div class="container">

        <form id="edit" method="post">
            <div class="listing-form" ng-if="editListing">
                <h3>Edit Listing</h3>

                <div class="row listing-form-row">

                    <div class="col-sm-4" id="offerName">
                        <div class="input-group">
                            <span class="input-group-addon">Product Name</span>
                            <input type="text" placeholder="Enter the Product Name" name="product" class="form-control"
                                ng-model="existingListing.offer">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group" id="description">
                            <span class="input-group-addon">Description</span>
                            <textarea type="text" placeholder="Enter the description" name="discription"
                                class="form-control" ng-model="newListing.description"></textarea>
                        </div>
                    </div>



                </div>


                <button class="btn btn-primary listing-button" ng-click="saveOfferEdit()" ng-show="editListing"
                    name="edit" id="edit">Save</button>


            </div>
        </form>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>