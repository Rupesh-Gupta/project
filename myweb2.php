<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Online Bookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="jquery-3.0.0.js"></script>
	<link rel="stylesheet" href="mywebcss.css">

  </head>

  <body>
  <style>
  .submit{
        background: green;
        border:none;
        color: white;
        font-size: 18px;
        font-weight: 200;
        cursor: pointer;
        -webkit-transition: box-shadow .4s ease;
        transition: box-shadow .4s ease;
        
        &:hover {
          box-shadow: 1px 1px 5px #555;  
        }
          
        &:active {
            box-shadow: 1px 1px 7px #222;  
        }
        
      }
         .submit {
        width: 80%;
        margin-left: 10%;
        margin-bottom: 25px;
        height: 40px;
        border-radius: 5px;
        outline: 0;
        -moz-outline-style: none;
      }
.submit:hover {
  box-shadow: 1px 1px 5px #555;
}
.submit:active {
  box-shadow: 1px 1px 7px #222;
}</style>
    
<nav>
  <div class="container">
    <ul class="nav">
      <li><a href="#top">Home</a></li>
      <li><a href="#browse">Browse Collection</a></li>
      <li><a href="#contact">Contact Us</a></li>
    </ul>
  </div>
</nav>
<div style="float:right; margin: 80px auto; padding: 20px; font: bold 24px Gabriola; color: white;">Hello 
<?php
session_start();
echo $_SESSION['username'];?>!

<br/>
<button class="submit"><a href="checkout.php">Proceed to Checkout</a></button>
<button class="submit"><a href="logout.php">Logout</a></button></div>
<div class="jumbotron">
  <div class="container">
    <div class="main">
      <h1>Sahitya Sadan</h1>
      <p>a one stop online book store...</p>
    </div>
  </div>
</div>
<?php
function add($book, $price ,$category)
{
	
}
?>
<div>
<h2 style="font: bold 36px Algerian; color: brown; padding: 8px; text-decoration: underline;"> Recommended Books</h2>
<?php
@ $db = mysqli_connect("localhost","root", "", "bookstore" );
$query1 = "SELECT `books`.`TechID`,`books`.`BookName`, `books`.`AuthorName`,`books`.`ISBN`,`books`.`Press`,`books`.`BookPrice`, `books`.`BookDetails`".
        "FROM `books` JOIN `orders` ON `books`.`TechID` = `orders`.`TechID` LIMIT 3";
$result = mysqli_query($db, $query1);
if($result)
{
	echo '<div id="container"><div class= "next">';
	while ($row = mysqli_fetch_array($result)){
		$name = $row["BookName"];
		$price = $row["BookPrice"];
		$id = $row["TechID"];
		echo '<div class="book"><span id="title">'. $row["BookName"]. '</span><br/><br/><br/><label>Author</label>: '.
			$row["AuthorName"]. '<br/><label>ISBN</label>: '. $row["ISBN"].
			'<br/><label>Published by</label>: '. $row["Press"]. '<br/><p>'. $row["BookDetails"].
			'</p><br/><label>Price</label><em>: '. $row["BookPrice"].
			'</em>'.
			'<br/><form name="addProduct" method="post" action="'.$_SERVER["PHP_SELF"].'">'.
			'<input type="hidden" name="id_order" type="text" value="'.$name.'" />'.
			'<input type="hidden" name="id_product" type="text" value="'.$id.'" />'.
			'<input type="hidden" name="price" type="number" value="'.$price.'" />'.
			'<input class="submit" type="submit" value="Add to basket" name="pdt_basket"/>'.
			'</form></div>';
	}
	echo '</div</div>';
}
?>
</div>
<?php
if(($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["pdt_basket"])))
{
	$buyer = $_SESSION["username"];
	@ $db = mysqli_connect("localhost","root", "", "bookstore" );
	$Bookname = mysqli_real_escape_string($db, $_POST["id_order"]);
	$TechID = mysqli_real_escape_string($db, $_POST["id_product"]);
	$Price = mysqli_real_escape_string($db, $_POST["price"]);
	
	$query = "INSERT into orders". "(CartItems, TotalPrice, TechID, OrderDate, Username)". "VALUES ('$Bookname', '$Price', '$TechID', NOW(), '$buyer')";
	$run = mysqli_query($db, $query);
	if($run){
		echo '<script> alert("Book added to cart"); </script>';
	}
	else echo 'error, cannot add this book';
	
	mysqli_close($db);
}
?>

<div class="collection" id="browse">
  <div class="container">
  <h2>Search Books</h2>
    <p>Select one of these categories to continue:</p>
  <?php 
  global $link;
	@ $db = mysqli_connect("localhost","root", "", "bookstore" );
	if(mysqli_connect_errno())
	{
		echo "error, database connection not established";
		exit;
	}
	$query = "Select * from Technology";
	$result = mysqli_query($db, $query);
	
	if($result)
	{
		while ($cont = mysqli_fetch_array($result))
			echo '<a href="#'.$cont["TechID"].'" class="float-box">'.
				'<div class="collection-img">'.'</div><br><h3>'.$cont["TechName"].'</h3></a>';
		}
	else{
		echo 'error';
	}
	 echo'</div></div>';
	 
	$query = "Select * from Technology";
	$result = mysqli_query($db, $query);
	 while ($cont = mysqli_fetch_array($result))
	 {
		
		$id = $cont["TechID"];
		$sql = "Select * from Books where TechID ='$id'";
		$result2 = mysqli_query($db, $sql);
		if($result2){
			echo'<div id="container"><h3 id="'.$cont["TechID"].'">'.$cont["TechName"].'</h3><br/>'.
			'<div class= "next">';
				for($i=0; $i<mysqli_num_rows($result2); $i++)
			{
				$row= mysqli_fetch_array($result2);
				$name = $row["BookName"];
				$price = $row["BookPrice"];
				echo '<div class="book"><span id="title">'. $row["BookName"]. '</span><br/><br/><br/><label>Author</label>: '.
				$row["AuthorName"]. '<br/><label>ISBN</label>: '. $row["ISBN"].
				'<br/><label>Published by</label>: '. $row["Press"]. '<br/><p>'. $row["BookDetails"].
				'</p><br/><label>Price</label><em>: '. $row["BookPrice"].
				'</em>'.
				'<br/><form name="addProduct" method="post" action="'.$_SERVER["PHP_SELF"].'">'.
				'<input type="hidden" name="id_order" type="text" value="'.$name.'" />'.
				'<input type="hidden" name="id_product" type="text" value="'.$id.'" />'.
				'<input type="hidden" name="price" type="number" value="'.$price.'" />'.
				'<input class="submit" type="submit" value="Add to basket" name="pdt_basket"/>'.
				'</form></div>';
			}
			echo '</div></div>';
		}
		else echo'Error';
	 }
?>
</div>
</div>	

<div style="background-color: #1295C9;" class="contact" id="contact">
  <div class="container" >
    <h2 style="font: solid 36px Gabriola; color: browwn;">Contact Me</h2>
  </div>
</div>

<footer>
  <div class="container">
       <p>@ Copyright 2016, Sahitya Sadan.</p>
  </div>
</footer>

</body>
</html>