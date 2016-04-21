<?php
// Start Session because we will save some values to session varaible.
session_start();
	// 	$host  = "localhost";
	// 	$user = "raksquad_sms";  
	//     $pass = "09131991";
	// 	$dbase = "raksquad_smsblast";
	//  	$mysqli = mysqli_connect($host,$user,$pass,$dbase) or die (mysqli_error());
	
	// $sUserID	= FixInput($_POST['txtUsername']);
	// $sPwd		= FixInput($_POST['txtPassword']);
	// $pass		= md5($sPwd);
	// $sql		= "SELECT * FROM USERS WHERE USR_USERNAME='$sUserID' AND USR_PASSWORD='$pass'";
	// $rsUser		= mysqli_query($mysqli,$sql) or die("Unable to login.");

	// if (mysqli_num_rows($rsUser)) {
	// 	$_SESSION["ses_sUsername"]	= $sUserID;
	// 	$_SESSION["ses_sFullname"]	= mysqli_result($rsUser,0,"fullname");
	// 	$_SESSION["ses_sLevel"]		= mysqli_result($rsUser,0,"level");
		
	// 	//logs("Access","Login","User Logged In.",$_SESSION["ses_sUsername"]);
	// 	echo"<script type='text/javascript'>alert('You have logged in our system.');</script>";
	// 	echo '<META HTTP-EQUIV="Refresh" Content="1; URL=../phpsample/">';
	// 	//header("location: ../faculty_loading/");
	// }

	// //invalid username or password
	// else {
	// $_SESSION["ses_sUsername"]	= $sUserID;
	// 	//logs("Access","Login","User Log IN Failed.",$_SESSION["ses_sUsername"]);
	// 	echo"<script type='text/javascript'>alert('Invalid username / password!');</script>";
	// 	echo '<META HTTP-EQUIV="Refresh" Content="1; URL= login.php?e=1">';
	// 	//header("location: login.php?e=1");
	// }
include("dbconnection.php");

// Define $myusername and $mypassword
$UserName=$_POST['username']; 
$Password=md5($_POST['password']); 

// We Will prepare SQL Query
    $STM = $db->prepare("SELECT * FROM system.users WHERE login_name = :UserName AND password = :Password");


// bind paramenters, Named paramenters alaways start with colon(:)
    $STM->bindParam(':UserName', $UserName);
    $STM->bindParam(':Password', $Password);
// For Executing prepared statement we will use below function
    $STM->execute();
// Count no. of records	
$count = $STM->rowCount(); 
//just fetch. only gets one row. So no foreach loop needed :)
$row  = $STM -> fetch();

// User Redirect Conditions will go here
	if($row > 0){
    	// Save type and other information in Session for future use.
		$_SESSION['myusername']=$UserName;
				// if user type is ACTAdmin only then he can access protected page.
			echo "<script language='javascript' type='text/javascript'>alert('Successfully Logged In!')</script>";
			echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";


	}
	else 
	{
	echo "<script language='javascript' type='text/javascript'>alert('Access Denied!')</script>";
	echo "<script language='javascript' type='text/javascript'>window.open('login.php','_self')</script>";

	}
?>