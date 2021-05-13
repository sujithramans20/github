<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cpms";
$conn = new mysqli($servername, $username, $password,$dbname);
$lname = $email = $contact = $address = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
$lname =test_input($_POST['lname']);
$email =test_input($_POST['email']);
$contact = test_input($_POST['contact']);
$address =test_input($_POST['address']);
$password =test_input($_POST['password']);
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//$hashemail=sha1($semail);
//$hashpassword=sha1($spassword);
$sql = "INSERT INTO tbllab (email,password) VALUES ('$email','$password')";
if (mysqli_query($conn, $sql)){
	$query = "SELECT labid FROM `tbllab` WHERE email='$email' and password='$password'";
	$userId = mysqli_query($conn, $query);
	$data = mysqli_fetch_assoc($userId);
	$lid = $data['labid'];
	$_SESSION['labid']=$lid;
	if($userId){
		$details = "INSERT INTO lreg (lid,lname,email,contact,address) VALUES ('$lid','$lname','$email','$contact','$address')";
		if(mysqli_query($conn, $details)) {
			if(isset($_SESSION["lid"])){
			    header("Location:../../lreg.html");
			}
		}
		else {
			echo mysqli_error($conn);
			echo"invalid user details";
		}
	}
	else {
		echo mysqli_error($conn);
		echo"user not found";
	}
}
else {
	echo mysqli_error($conn);
	echo"invalid username or password";
}
mysqli_close($conn);
?>