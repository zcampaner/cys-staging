
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP Sample</title>
<style>
.myButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf));
	background:-moz-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-webkit-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-o-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:-ms-linear-gradient(top, #ededed 5%, #dfdfdf 100%);
	background:linear-gradient(to bottom, #ededed 5%, #dfdfdf 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf',GradientType=0);
	background-color:#ededed;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #dcdcdc;
	display:inline-block;
	cursor:pointer;
	color:#777777;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffffff;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
	background:-moz-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-webkit-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-o-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-ms-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:linear-gradient(to bottom, #dfdfdf 5%, #ededed 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed',GradientType=0);
	background-color:#dfdfdf;
}
.myButton:active {
	position:relative;
	top:1px;
}
</style>
<?php
# pdo options/attributes
    $opt = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION );
    # data source name
    $dsn = "pgsql:dbname=cys;   host=localhost;   user=postgres;   password=root";

if (isset($_POST["frmSubmit"])) {

        if (!$_POST['login_name'] || !$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        

                $db = new PDO($dsn, $user, $pass, $opt);
                $STH = $db->prepare("INSERT INTO system.users (login_name,password,first_name,last_name,email,enabled,internal) VALUES (:login_name,:password,:first_name,:last_name,:email,'Yes','Yes')");

                $STH->bindParam(':login_name', $_POST['login_name']);
                $STH->bindParam(':first_name', $_POST['first_name']);
                $STH->bindParam(':last_name', $_POST['last_name']);
                $STH->bindParam(':password', $_POST['password']);
                $STH->bindParam(':email', $_POST['email']);

                $STH->execute();

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo "<script language='javascript' type='text/javascript'>alert('Successfully Saved!')</script>";
			echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";

        }
}

    echo '<form method="POST" action="">';
    echo '<p>Enter the below information if you want to insert:</p>';
    echo 'User Name: <input type="text" name="login_name" required/><br />';
    echo 'Password: <input type="password" name="password" required/><br />';
    echo 'First Name: <input type="text" name="first_name" required/><br />';
    echo 'Last Name: <input type="text" name="last_name" required/><br />';
    echo 'Email: <input type="email" name="email" required/><br />';
    echo '<input type="submit" name="frmSubmit" value="Do-It"></form>';


# close the connection  
    $db = null;