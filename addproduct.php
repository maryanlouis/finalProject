<?php
    include ('include/connection.php');
	session_start();
	if (!isset($_SESSION['loggedInUser'])) {
		header("Location: GrouBuy.php");
	}
    include ('include/functions.php');
    $categoryName= array();
     $nameError=$discriptionError=$imgError=$alertMessage=" ";
     $qu="SELECT * FROM `category`";
     $r = mysqli_query($conn, $qu);
     if (mysqli_affected_rows($conn) > 0) {
     while($row = mysqli_fetch_assoc($r) ) {
        $categoryName[]=$row;
      }
    }
	if (isset($_POST['add']))
	{
        $product=$discription=$category=$img=" ";
       
		if (!$_POST["product"]) {
			$nameError="Please the discount <br>";
		}else{
            
			$product=validateFormData($_POST["product"]);
        }
        if (!$_POST["discription"]) {
			$discriptionError="Please enter the discription <br>";
		}else{
			$discription=validateFormData($_POST["discription"]);
        }
        
        if (!$_POST["img"]) {
			$imgError="Please enter image name <br>";
		}else{
			$img=validateFormData($_POST["img"]);
        }
       
        if ($product&&$discription&&$img)
        {
            if ($_POST["category"]=="addcat") {
               // $categoryError="Please choose <br>";
               $category=validateFormData($_POST["category"]);
		      $query="INSERT INTO `category` (category_name,parent) VALUES ('$category','$categoryId')";
		      $result = mysqli_query($conn, $query);
            }else{
                $category=validateFormData($_POST["category"]);
            }
                $id =mysqli_query($conn, "SELECT category_id FROM category WHERE category_name='$category'");
				$row = mysqli_fetch_assoc($id);
                $categoryId=$row['category_id'];
                // $parent = "INSERT INTO category (parent) VALUES ('$categoryId')";
                // $r=mysqli_query($conn,$parent);
                $q="INSERT INTO `product`(product_name,discrption,img,category_id)VALUES('$product','$discription','$img','$categoryId')";
                $res = mysqli_query($conn, $q);   
                if($res){     
                header("Location: products.php?alert=success");	
                }else{
                echo "Error: ".$q."<br>".mysqli_error($conn);
                } 
            }
            }
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <div class="row">
            <form method="post">
                <br><br>
                <div class="col-sm-4">

                    <div class="input-group" id="product">

                        <span class="input-group-addon">Product Name <?php echo $nameError; ?></span>
                        <input type="text" name="product" placeholder="Enter the price of the item" class="form-control"
                            ng-model="newListing.discount">
                    </div>
                </div>
                <br>

                <div class="col-sm-4">
                    <div class="input-group" id="discription">
                        <span class="input-group-addon">Discription <?php echo $discriptionError; ?></span>
                        <textarea type="text" name="discription" placeholder="Enter the quantity" class="form-control"
                            ng-model="newListing.start"></textarea>
                    </div>
                </div>
                <br>
               
                <div class="col-sm-4">
                    <div class="input-group" id="category">
                        <span class="input-group-addon">Category Name</span>
                        <select name="category">
                        <?php
                        foreach ($categoryName as $val) {
                        ?>
                            <option value="<?php echo $val['category_name']; ?>"><?php echo $val['category_name']; ?> </option>
                            <?php
                            }
                            ?>
                            <option type="text" value="addcat">Add one</option>
                        </select>
                    </div>
                </div>
                

                <br>
                <br>
                <div class="col-sm-4">
                    <div class="input-group" id="image">
                        <span class="input-group-addon">Image <?php echo $imgError; ?></span>
                        <input type="text" name="img" placeholder="Enter the image name" class="form-control"
                            ng-model="newListing.start">
                    </div>
                </div>
                <br>
                <br>

                <button class="btn btn-primary listing-button" name="add" ng-click="addOffer(newListing)"
                    ng-show="addListing">Submit</button>
            </form>
        </div>
    </div>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>