<html>
<head>
<title> Registration Page</title>
<link type="text/css" rel="stylesheet" href="login.css" />
</head>
<body>
<h1 style="text-align: center; padding: 20px; font: bold 36px tahoma; color: gold;">Registration Form</h1>
<form name="f1" method ="post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
<div style="display: box; width: 800px; height: 600px; margin: 100px auto; text-align: left; padding: 20px; border: 1px solid white; font: normal 18px Tahoma; color: white;">
	<div style="text-align: left; padding: 20px; font: bold 18px tahoma; color: red;" class="form">Fill these details.<br/>
<p class="note">Fields marked with * are required.</p></div>
	Firstname <abbr>*</abbr>: 
	<input type="text" name="firstname" id="firstname" placeholder="First Name" required></input>		<br/><br/>
	Lastname <abbr>*</abbr>: 
	<input type="text" name="lastname" id="lastname" placeholder= "Last Name" required></input>			<br/><br/>
	Username <abbr>*</abbr>: 
	<input type="text" name="username" id="username" placeholder="Username" required></input>			<br/><br/>
	Password: <abbr>*</abbr>
	<input type="password" pattern="[a-zA-Z0-9]+" id="password1" name="password1" 
		title="The password should be between 6-13 characters. It should include alphabets[a-z, A-Z] and numbers[0-9] only."
		required></input><br/><br/>
	Confirm Password: <abbr>*</abbr>
	<input type="password" id="password2" pattern="[a-zA-Z0-9]+" name="password2"
		title="The password should be between 6-13 characters. It should include alphabets[a-z, A-Z] and numbers[0-9] only."
		required></input><br/><br/>
	Email Id: <abbr>*</abbr>
	<input type="email" name="email" id="email" required></input><br/><br/>
	Phone No: <abbr>*</abbr>
	<input type="tel" name="phone" pattern="[0-9]+" maxlength="10" id="phone" required></input><br/><br/>
	Address: <input type="textarea" name="address"><br/><br/>
	City: <abbr>*</abbr>
	<input type="text" name="city" required><br/><br/>
	Country: <abbr>*</abbr>
	<input type="text" name="country" required><br/><br/>
	Credit Card Details<br/>
	Number: <abbr>*</abbr><input type="number" name="Card_num" required>
	Expiry Date: <abbr>*</abbr><input type="date" name="Card_date" required>
	<br/><br/>
	<input class="submit" type="submit" value="submit">
	</div>
	</form>
	
		
<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$flag=0;
	@ $db = mysqli_connect("localhost","root", "", "bookstore" );
	if(mysqli_connect_errno())
	{
		echo "error, database connection not established";
		exit;
	}
	else{
		
	$firstname = mysqli_real_escape_string($db, $_POST["firstname"]);
	$lastname = mysqli_real_escape_string($db, $_POST["lastname"]);
	$username = mysqli_real_escape_string($db, $_POST["username"]);
	$password1 = mysqli_real_escape_string($db, $_POST["password1"]);
	$password2 = mysqli_real_escape_string($db, $_POST["password2"]);
	$email = mysqli_real_escape_string($db, $_POST["email"]);
	$phone = mysqli_real_escape_string($db, $_POST["phone"]);
	$address = mysqli_real_escape_string($db, $_POST["address"]);
	$city = mysqli_real_escape_string($db, $_POST["city"]);
	$country = mysqli_real_escape_string($db, $_POST["country"]);
	$Card_num = mysqli_real_escape_string($db, $_POST["Card_num"]);
	$Card_date = mysqli_real_escape_string($db, $_POST["Card_date"]);

	if(!$username || !$email || !$phone || !$password1 || !$password2 || !$Card_date || !$Card_num 
	|| !$country	|| !$city || !$lastname || !$firstname)
	{
		echo "You must fill in all the required fields";
		exit;
	}
	if(strlen($password1) <6)
	{
		echo "Password must be atleast 6 characters long";
	}
	
	if($password1 != $password2){
		echo "Passwords do not match";
	}
	//$pdhash = password_hash($password1, PASSWORD_DEFAULT, array('cost'=>10));
	
	$uniq1 = "Select * from Buyers where Username ='$username'";
	$uniq_run1 = mysqli_query($db, $uniq1);
	$uniq2 = "Select * from Buyers where EmailId ='$email'";
	$uniq_run2 = mysqli_query($db, $uniq2);
	$uniq3 = "Select * from Buyers where PhoneNumber ='$phone'";
	$uniq_run3 = mysqli_query($db, $uniq3);
	if(mysqli_num_rows($uniq_run1)>0)
	{
		echo("The account with username: '$username' already exist, try login. ");
	}
	else if(mysqli_num_rows($uniq_run2)>0){
		echo("The account with email id: '$email' already exist, try login.");
	}
	else if(mysqli_num_rows($uniq_run3)>0){
		echo("The account with Phone number: '$phone' already exist, try login.");
	}
	else
	{
	
	if(!get_magic_quotes_gpc())
	{
		$username = addslashes($username);
		$email = addslashes($email);
		$firstname = addslashes($firstname);
		$lastname = addslashes($lastname);
		$address = addslashes($address);
		$city = addslashes($city);
		$country = addslashes($country);
		$Card_num = addslashes($Card_num);
		$Card_date = addslashes($Card_date);
	}
	$query = "INSERT INTO Buyers". "(Address, City, Country, CreditCardExpire, CreditCardNumber
	, FirstName, LastName, Password, PhoneNumber, Username, EmailId)"
	."VALUES".
	"('$address', '$city','$country', '$Card_date', '$Card_num', '$firstname', '$lastname', '$password1', '$phone', '$username', '$email')";
	$result = mysqli_query($db, $query);
	
	if($result)
	{
		$_SESSION['username'] = $username;
		header ("location: myweb2.php");
	}
	else
	{
		echo "Oops Sorry,Trouble in registering, please retry!";
	}
	}
	mysqli_close($db);
	}
}
?>
</body>
</html>