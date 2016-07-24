<html>
<head>
<title>Cart</title>
<link type="text/css" rel="stylesheet" href="login.css" />
</head>
<body>
<header>
<h1 style="float: left; font: solid 60px Algerian; color: white; padding:30px;">Your Cart</h1>
<img src="shopping-cart-black-1.png" height="150" width="220" style="float:right;">
</header>
<div align="center" class="login-wrap">
<?php
$total =0;
session_start();
$user = $_SESSION["username"];
@ $db = mysqli_connect("localhost", "root", "", "bookstore");

$query = "Select * from orders where Username = '$user'";
$result = mysqli_query($db, $query);
while($row= mysqli_fetch_array($result))
{
	echo '<div style="font: bold 20px TimesNewRoman; color: blue;">'.$row["CartItems"];
	echo '<em style="float:right;">'.$row["TotalPrice"];
	echo '</em><br/><br/></div>';
	$total += $row["TotalPrice"];
}
echo '<p style="font: bold 24px Tahoma; color: Green;">Total Amount = '.$total.'</p><br/>';
?>
<button class="submit">Continue to Pay</button>
</div>
</body>
</html>