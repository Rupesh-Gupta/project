<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script type='text/javascript' src='jquery-1.11.1.min.js'></script>
     <script src="jquery-ui.js"></script>
    <link type="text/css" rel="stylesheet" href="login.css" />
     <script src="jquery.js"></script>
    <style>
        body {
            margin: 0;
        }
    </style>
</head>

 <body>
 <div class="header">
        <img  height="120" width="400" style="padding:20px;" src="bookstore-493x328.jpg" />
		<div style="float: right; padding:20px; font: normal 50px TimesNewRoman; color: white;">Sahitya Sadan</h1>
		<br/><span style=" font: italic 24px Gabriola;">a one stop online book store...</span></div>
    </div>
     </br></br></br></br>
    <div class="login-wrap">
  <h2>Login</h2>
  
  <div class="form">
       <form action="<?php echo $_SERVER["PHP_SELF"];?>" name="f1" method="post">
       <input type="text" placeholder="UserName" id="uname" value="" name="uname" required>
       <input type="password" placeholder="Password" id="pwd" value="" name="pwd" required>
            <input class="submit" type="submit" value="Login" id="sub_form">
      </form>
  </div>
  <div style="text-align: center; font: bold 14px Arial; color: blue;">
  New User &nbsp;<a href="register.php">Register here</a>
</div>  
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
session_start();

$server = "localhost";
$username = "root";
$password = "";
$db_name = "bookstore";

@ $db = mysqli_connect( $server,$username, $password, $db_name );
	if(mysqli_connect_errno())
	{
		echo "error, database connection not established";
		exit;
	}
$username = mysqli_real_escape_string($db, $_POST["uname"]);
$login = "select * from Buyers where Username ='$username' ";
$result = mysqli_query($db, $login);
if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	if($_POST["pwd"] === $row["Password"])
	{
	header("Location: myweb2.php");
	$_SESSION["username"] = $row["FirstName"];
	$_SESSION["buyerid"] = $row["BuyerID"];
	}
	else
	{
	header("Location: main.php");
	}
}
else echo '<p style="font: bold 16px Tahoma; color: red; text-align: center;">Login Error</p>';
}
?>
   
  </body>
</html>