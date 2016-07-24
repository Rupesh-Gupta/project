<?
echo 'jksdjdnjvkb';
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
$login = "select * from users where username ='$_POST["uname"]' ";
$result = mysqli_query($db, $login);
if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_array($result);
	if($_POST["pwd"] === $row["Password"])
	{
	$_SESSION['username'] = $_POST['username'];
	header("Location: myweb2.php");
	}
	else
	{
	header("Location: main.php");
	}
}
else echo 'error';
?>