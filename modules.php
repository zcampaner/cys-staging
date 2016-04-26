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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome.min.css" rel="stylesheet" type="text/css">

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
              $("#ad").hide();
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
  							location.reload();
							}
  						else {
  							alert('FAILED!');
  						}
  						
  					});
    			});
    			$('#add').click(function(){
  					$("#edit_button").hide();
            $("#ed").hide();	
    			});
    			$('#add_button').click(function(){
    				var params = { "login_name": $('#login_name').val(), "password": $('#password').val(), "first_name": $('#first_name').val(), "last_name": $('#last_name').val(), "email": $('#email').val() }
            		$.ajax({
  						method: "POST",
  						url: "add_file.php",
  						data: params					
  					})
  					.done(function( msg ) {
  						alert('New record added');
  						location.reload();
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
<style>
html {
  font-family: "roboto", helvetica;
  position: relative;
  height: 100%;
  font-size: 100%;
  line-height: 1.5;
  color: #444;
}

h2 {
  margin: 1.75em 0 0;
  font-size: 5vw;
}

h3 { font-size: 1.3em; }

.v-center {
  height: 100vh;
  width: 100%;
  display: table;
  position: relative;
  text-align: center;
}

.v-center > div {
  display: table-cell;
  vertical-align: middle;
  position: relative;
  top: -10%;
}

.btn {
  font-size: 3vmin;
  padding: 0.75em 1.5em;
  background-color: #fff;
  border: 1px solid #bbb;
  color: #333;
  text-decoration: none;
  display: inline;
  border-radius: 4px;
  -webkit-transition: background-color 1s ease;
  -moz-transition: background-color 1s ease;
  transition: background-color 1s ease;
}

.btn:hover {
  background-color: #ddd;
  -webkit-transition: background-color 1s ease;
  -moz-transition: background-color 1s ease;
  transition: background-color 1s ease;
}

.btn-small {
  padding: .75em 1em;
  font-size: 0.8em;
}

.modal-box {
  display: none;
  position: absolute;
  z-index: 1000;
  width: 98%;
  background: white;
  border-bottom: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(0, 0, 0, 0.1);
  background-clip: padding-box;
}
@media (min-width: 32em) {

.modal-box { width: 70%; }
}

.modal-box header,
.modal-box .modal-header {
  padding: 1.25em 1.5em;
  border-bottom: 1px solid #ddd;
}

.modal-box header h3,
.modal-box header h4,
.modal-box .modal-header h3,
.modal-box .modal-header h4 { margin: 0; }

.modal-box .modal-body { padding: 2em 1.5em; }

.modal-box footer,
.modal-box .modal-footer {
  padding: 1em;
  border-top: 1px solid #ddd;
  background: rgba(0, 0, 0, 0.02);
  text-align: right;
}

.modal-overlay {
  opacity: 0;
  filter: alpha(opacity=0);
  position: absolute;
  top: 0;
  left: 0;
  z-index: 900;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3) !important;
}

a.close {
  line-height: 1;
  font-size: 1.5em;
  position: absolute;
  top: 5%;
  right: 2%;
  text-decoration: none;
  color: #bbb;
}

a.close:hover {
  color: #222;
  -webkit-transition: color 1s ease;
  -moz-transition: color 1s ease;
  transition: color 1s ease;
}
</style>
<?php


if (isset($_POST["frmSubmit"])) {

        if (!$_POST['login_name'] || !$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email']) {
            echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
            exit;
        } else {

            try {        
            	$login_name = $_POST["login_name"];
            	

                $query = "UPDATE system.users SET password = :password, first_name = :first_name, last_name = :last_name, email = :email WHERE login_name = :login_name";

                $STH = $db->prepare($query); 

                 $STH->execute(array('password' => $_POST['password'], 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], ':email' => $_POST['email'], ':login_name' => $login_name));

            	

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            echo "<script language='javascript' type='text/javascript'>alert('Successfully Saved!')</script>";
			echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";
        }
}
?>
<body>



    <div id="wrapper">

        <?php

          include 'sidebar.php';

        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Like SB Admin?</strong> Try out <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">SB Admin 2</a> for additional features!
                        </div>
                    </div>
               </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart</h3>
                            </div>
                            <div class="panel-body">
                                <?php


					if(isset($_GET['login_name'])){
					  require_once ("dbconnection.php");  

					    $ppid1 = $_GET['login_name'];

					    $sqledit="SELECT* FROM system.users WHERE login_name='$ppid1'";
					  $res1=$db->prepare($sqledit);
					  $res1->execute();
					  $result1 = $res1->fetchALL(PDO::FETCH_ASSOC); 
					   foreach ($result1 as $row1) {
					    // while($rowadd = $resadd->fetchALL(PDO::FETCH_ASSOC)){
					    $login_name   =$row1['login_name'];
					    $first_name   =$row1['first_name'];
					    $last_name    =$row1['last_name'];  
					    $email      =$row1['email'];
					    $password   =$row1['password'];
					    $enabled    =$row1['enabled'];
					    $terminal   =$row1['terminal']; 

					  }
					}
					?>

					<div id="modal" class="modal-box">

					  <header> <a href="#" class="js-modal-close close">×</a>
					    <h3 id="ed">EDIT</h3>
					    <h3 id="ad">ADD</h3>
					  </header>
					  <div class="modal-body">
					 <form method="POST" action="">
					    <p>Enter the below information if you want to insert:</p>
					    User Name: <input type="text" name="login_name" id="login_name" value = "<?php echo $login_name; ?>" required/><br />
					    Password: <input type="password" name="password" id="password" required/><br />
					    First Name: <input type="text" name="first_name" id="first_name" required/><br />
					    Last Name: <input type="text" name="last_name" id="last_name" required/><br />
					    Email: <input type="email" name="email" id="email" required/><br />

					    <input type="button" id="add_button" name="frmSubmit" value="Do-It">
					    <input type="button" id="edit_button" name="frmSubmit" value="Do-It">
					    
					  <footer> <a href="#" class="btn btn-small js-modal-close">Close</a> </footer>
					</div>
					</div>
					<script>
					$(function(){

					var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

					  $('a[data-modal-id]').click(function(e) {
					    e.preventDefault();
					    $("body").append(appendthis);
					    $(".modal-overlay").fadeTo(500, 0.7);
					    //$(".js-modalbox").fadeIn(500);
					    var modalBox = $(this).attr('data-modal-id');
					    $('#'+modalBox).fadeIn($(this).data());
					  });  
					  
					  
					$(".js-modal-close, .modal-overlay").click(function() {
					    $(".modal-box, .modal-overlay").fadeOut(500, function() {
					        $(".modal-overlay").remove();
					    });
					 
					});
					 
					$(window).resize(function() {
					    $(".modal-box").css({
					        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
					        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
					    });
					});
					 
					$(window).resize();
					 
					});
					</script>
					<script type="text/javascript">
					  var _gaq = _gaq || [];
					  _gaq.push(['_setAccount', 'UA-36251023-1']);
					  _gaq.push(['_setDomainName', 'jqueryscript.net']);
					  _gaq.push(['_trackPageview']);

					  (function() {
					    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
					  })();

					</script>

					  <div class="se-pre-con"></div>
					<br/><br/>
					<input type="button" id="add" value="ADD"> || <a href="logout.php" id="myButton">LOGOUT</a>
					<br/><br/> 
					<?php
					        $sql="SELECT 
					          * FROM system.hotel_chains";
					          $res=$db->prepare($sql);
					          $res->execute();
					          $result = $res->fetchALL(PDO::FETCH_ASSOC);   
					          $str="<div class='demo_jui'><table cellpadding='0' cellspacing='0' border='0' class='display' id='tbl' class='jtable'>";
					          $str.="<thead>
					                <tr><th>Chain Code</th>
					                  <th>Chain</th>
					                  <th>Description</th>
					                  <th>Enabled</th>
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
					              $str.="<tr><td id='".$row['chain_code']."' value='attr'><center>".$row['chain_code']."</center></td>";
					              $str.="<td width='10%'>".$row['chain']."</td>";
					              $str.="<td width='10%'>".$row['description']."</td>";
					              $str.="<td width='10%'>".$sActive."</td>";
					              $str.="<td><center><a class='edit'><img src = 'images/edit-icon.png' height='30' width='30' id='edit' alt = 'edit' title = 'edit'/></a><a class='delete'><img src = 'images/edit_delete.png' height='30' width='30' alt = 'delete' title = 'delete'/></a></center></td></tr>";
					            }
					            echo $str;
					            echo "</tbody></table></div>";//class='fancybox fancybox.ajax' 

							?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>





