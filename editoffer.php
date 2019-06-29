<?php

include ('include/connection.php');
    session_start();
    include ('include/functions.php');
    if (!isset($_SESSION['loggedInUser'])) // check on logged in user
    {
		header("Location: GrouBuy.php");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') 
    {
        if (!isset($_GET['offerid'])) // دا عشان لو هو جايلى الصفحة من غير رقم لاى اوفر ارجعه تانى عشان اريح دماغى دا اولا
        {
            header('location:storeSeller.php');
        }
        $offer_number = intval($_GET['offerid']); // not important intval() put more security ^_^
        if (!is_int($offer_number))
        {
            echo 'You Must Get an offer Number'; // error message ^_^
        }
        // خلاص عدينا مرحله ال 
        // checking 
        // نخش بقى في مرحلة اننا نجيب الاوفر بناءا على الرقم اللى جالى دا

        $GetOfferQuery = 'select * from offer where offer_number='.$offer_number;
        $q = mysqli_query($conn, $GetOfferQuery);
        $OfferData = mysqli_fetch_assoc($q);
        if(empty($OfferData))
        {
            echo 'There is no offer with this number '. $offer_number . ' , Please Try again';
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['save'])) {
             // get your all inputs from the form below .example >> $offer_number = $_POST['offer_number']
             // start your validation conditions
             // if data passed your validation write your Query then excute it (updata offer set name=$yourVariables ,,,, where offer_number = $offer_number)
            // say conguratualion then header back
        $offer_number = intval($_POST['offer_number']);
        $discount=validateFormData($_POST["discount"]);
		$startDate=validateFormData($_POST["start"]);
		$endDate=validateFormData($_POST["end"]);
		$quantity=validateFormData($_POST["quantity"]);
		$price=validateFormData($_POST["price"]);
		// $category=validateFormData($_POST["category"]);
        $offerName=validateFormData($_POST["offer_name"]);
        $IMAGE=validateFormData($_POST["image"]);//, discount=".$discount." ,start_date= ".$startDate." ,end_date=".$endDate."
		// $description=validateFormData($_POST['description']);
        $query="UPDATE offer set offer_name = '$offerName' , discount = '$discount' ,image = '$IMAGE' , start_date='$startDates' ,end_date='$endDate'  WHERE offer_number = '$offer_number'";
		$result = mysqli_query($conn, $query);
		if ($result) {
			header("Location: storeSeller.php?alert=updatesuccess");
		}else{
			echo "Error updating record: ".mysqli_error($conn);
		}
	} 
            
        }
    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="utf-8">
    <title>Edit</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .mymargin{
            margin:9px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1 class="text-center">Edit Offer</h1>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
        if(!empty($OfferData))
        {
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" >
                <!-- put the offer number for editing to get it in th top for update ^_^ -->
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group">
                        <input type="hidden" name="offer_number" placeholder="offer number" class="form-control"
                            value="<?php echo $OfferData['offer_number'] ?>">
                    </div>
                </div><!-- end div -->
                
                <!-- put the offer offer_name for editing to get it in th top for update ^_^ -->
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group">
                        <span class="input-group-addon">Offer Name</span>
                        <input type="text" name="offer_name" placeholder="offer number" class="form-control"
                            value="<?php echo $OfferData['offer_name'] ?>">
                    </div>
                </div><!-- end div -->

                <!-- put the offer discount for editing to get it in th top for update ^_^ -->
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group" id="productNumber">
                        <span class="input-group-addon">Offer Discount</span>
                        <input type="text" name="discount" placeholder="offer number" class="form-control"
                            value="<?php echo $OfferData['discount'] ?>">
                    </div>
                </div><!-- end div -->

                                <!-- put the offer discount for editing to get it in th top for update ^_^ -->
             
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group" id="productNumber">
                        <div class="col-md-3"><img class="img-responsive mymargin" src="<?php echo 'images/'. $OfferData['image'].'.jpg' ?>" > </div>
                        <input type="text" name="image" placeholder="offer image" class="form-control"
                            value="<?php echo $OfferData['image'] ?>">
                    </div>
                </div>
                <!-- end div -->
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group" id="productNumber">
                        <span class="input-group-addon">Start Date</span>
                        <input type="text" name="start" placeholder="start date" class="form-control"
                            value="<?php echo $OfferData['start_date'] ?>">
                    </div>
                </div><!-- end div -->
                <div class="col-md-12 mymargin"><!-- start div -->
                    <div class="input-group" id="productNumber">
                        <span class="input-group-addon">End Date</span>
                        <input type="text" name="end" placeholder="end date" class="form-control"
                            value="<?php echo $OfferData['end_date'] ?>">
                    </div>
                </div><!-- end div -->

                 <button name="save" class="btn-success btn btn">Save</button>
            </form>
            <?php
        }
    ?>
        </div>
    </div>
</body>

    <script src="bootstrap/js/bootstrap.min.js"></script>

</html>