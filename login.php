<?php
include("dbconnection.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Central Yield System</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="header">
		
	</div>
	<div id="menu" style="padding:2px 0;"></div>
	<div id="wrapper_login">
    <div class="login_form">
    <form class="theformlogin" name="frmLogin" method="POST" action="php_check_login.php">
		<div id="login_error">
			<!-- <?php
				if (isset($_GET["e"]) && $_GET["e"]==1) 
					echo "Login failed.";
				else
					echo "&nbsp";
			?> -->
			
			Central Yield System
		</div>
			
		
			<div class="input-group">
				
				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
				<input type="textbox" class="form-control" name="username" placeholder="Username" required/>
			</div></br>
			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
				<input type="password" class="form-control" name="password" placeholder="Password" required/>
			</div>
			<p style="padding-top:5px;">
    		<label for="remember">Remember Me:</label>    <input type="checkbox" name="remember" value="1" id="remember"> 
    	    </p>
				
		<div id="login_button">
          	<button type="submit" id="button_login" name="frmSubmit" class="btn btn-danger">Submit</button>
         </div>
		
	
	</form>

	

	</div>

	</div>
	<div id="footer">
    <div class="container clearfix">
    <center>
        <div class="footer_copyright">

        <p> DirectwithHotels - Copyright &copy; <?php echo date("Y"); ?>.   All rights reserved. </p>
        
      </div>
      </center>
      </div>
  </div>
  <script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</body>
</html>
