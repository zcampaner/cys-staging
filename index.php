<?php 
session_start();
	if (!isset($_SESSION["myusername"]))	
		header("location:login.php");

	require_once ("dbconnection.php"); 
	
	$pnum="";
	$pfname="";
	$plname="";
	$pcontact="";
	$pemail="";			
		if(isset($_GET['login_name'])){
			$ppid = $_GET['login_name'];
			$sqlLoader="Select from system.users where login_name=?";
			$resLoader=$db->prepare($sqlLoader);
			$resLoader->execute(array($ppid));		
			while($rowLoader = $resLoader->fetch(PDO::FETCH_ASSOC)){
				$login_name=$rowLoader['login_name'];
				$password=$rowLoader['password'];
				$first_name=$rowLoader['first_name'];	
				$last_name=$rowLoader['last_name'];
				$email=$rowLoader['email'];
				$enabled=$rowLoader['enabled'];
				$terminal=$rowLoader['terminal'];		
			}
	} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript, 
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(loading.gif) center no-repeat #fff;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");;
	});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CYS</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="fancybox/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="fancybox/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".fancybox").fancybox();
});
</script>	
    <style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table_jui.css";
			@import "css/jquery-ui-1.8.4.custom.css";
		</style>
<script src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			jQuery(document).ready(function() {
				
				oTable = jQuery('#tbl').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
								} );
				$('#modal').hide();
    			$("#add").click(function(){
        			$("#modal").show();
    			});	
    			$(".edit").click(function(){
    				var login_name = { "login_name": $(this).closest('tr').find('td').attr('id') }
            		$.ajax({
  						method: "POST",
  						url: "template_edit.php",
  						data: login_name,
  						dataType: "json"
					})
  					.done(function( msg ) {
  						console.log(msg[0]);
            			$("#login_name").val( msg[0].login_name );
            			$("#first_name").val( msg[0].first_name );
            			$("#last_name").val( msg[0].last_name );
            			$("#email").val( msg[0].email );
  					});
        			$("#modal").show();
        			$("#add_button").hide();
    			});
    			$('#edit_button').click(function(){
    				var params = { "login_name": $('#login_name').val(), "password": $('#password').val(), "first_name": $('#first_name').val(), "last_name": $('#last_name').val(), "email": $('#email').val() }
            		$.ajax({
  						method: "POST",
  						url: "edit_file.php",
  						data: params					
  					})
  					.done(function( msg ) {
  						if(msg > 0){
  							alert('OK!');
  						}
  						else {
  							alert('FAILED!');
  						}
  						
  					});
    			});
    			$('#add').click(function(){
  					$("#edit_button").hide();	
    			});
    			$('#add_button').click(function(){
    				var params = { "login_name": $('#login_name').val(), "password": $('#password').val(), "first_name": $('#first_name').val(), "last_name": $('#last_name').val(), "email": $('#email').val() }
            		$.ajax({
  						method: "POST",
  						url: "add_file.php",
  						data: params					
  					})
  					.done(function( msg ) {
  						alert(msg);
  					});
    			});	
    			$('.delete').click(function(){

    				var params = { "login_name": $(this).closest('tr').find('td').attr('id') };
    				var txt;
    				var r = confirm("Are you sure you want to delete record?");
    						if (r == true) {
        						$.ajax({
  									method: "POST",
  									url: "delete_file.php",
  									data: params					
  								})
  								.done(function( msg ) {
  									if(msg > 0){
  									alert('Deleted record successfully');
  									window.location.href("index.php");
  									location.reload();
  									}
  									else {
  									alert('Cancel');
  									}
  								});
    						}
  					
    			})
			});	
		</script>
<style>
#myButton {
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
#myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed));
	background:-moz-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-webkit-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-o-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:-ms-linear-gradient(top, #dfdfdf 5%, #ededed 100%);
	background:linear-gradient(to bottom, #dfdfdf 5%, #ededed 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed',GradientType=0);
	background-color:#dfdfdf;
}
#myButton:active {
	position:relative;
	top:1px;
}
</style>

</head>
<body>

<div id="modal">

    <p>Enter the below information if you want to insert:</p>
    User Name: <input type="text" name="login_name" id="login_name" required/><br />
    Password: <input type="password" name="password" id="password" required/><br />
    First Name: <input type="text" name="first_name" id="first_name" required/><br />
    Last Name: <input type="text" name="last_name" id="last_name" required/><br />
    Email: <input type="email" name="email" id="email" required/><br />
    <input type="button" id="add_button" name="frmSubmit" value="Do-It">
    <input type="button" id="edit_button" name="frmSubmit" value="Do-It">

</div>

	<div class="se-pre-con"></div>
<br/><br/>
<input type="button" id="add" value="ADD"> || <a href="logout.php" id="myButton">LOGOUT</a>
<br/><br/>
<?php 
					$sql="SELECT 
					* FROM system.users";
					$res=$db->prepare($sql);
					$res->execute();
					$result = $res->fetchALL(PDO::FETCH_ASSOC);		
					$str="<div class='demo_jui'><table cellpadding='0' cellspacing='0' border='0' class='display' id='tbl' class='jtable'>";
					$str.="<thead>
								<tr><th>Login Name</th>
									<th>Password</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Email</th>
									<th>Enabled</th>
									<th>Action</th>
									</tr>
							</thead>
						<tbody>";
						foreach ($result as $row) {
							$sStatus = $row['enabled'];
							if ($sStatus=="1") {
									$sActive = "Active";
								}
								else {
									$sActive = "Inactive";
								}
							$str.="<tr><td id='".$row['login_name']."' value='attr'><center>".$row['login_name']."</center></td>";
							$str.="<td width='10%'>".$row['password']."</td>";
							$str.="<td width='10%'>".$row['first_name']."</td>";
							$str.="<td width='10%'>".$row['last_name']."</td>";
							$str.="<td width='10%'>".$row['email']."</td>";
							$str.="<td width='10%'>".$sActive."</td>";
							$str.="<td><center><a class='edit'><img src = 'images/edit-icon.png' height='30' width='30' id='edit' alt = 'edit' title = 'edit'/></a><a class='delete'><img src = 'images/edit_delete.png' height='30' width='30' alt = 'delete' title = 'delete'/></a></center></td></tr>";
						}//
						echo $str;
						echo "</tbody></table></div>";//class='fancybox fancybox.ajax' 
?>


</body>
</html>


