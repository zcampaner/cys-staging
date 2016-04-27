<?php 

session_start();
	if (!isset($_SESSION["myusername"]))	
		header("location:login.php");

	require_once ("dbconnection.php"); 
	
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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<?php include("title.php"); ?>

	<!-- Bootstrap Core CSS -->
	<link href="bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="font-awesome.min.css" rel="stylesheet" type="text/css">
	<?php include("loading_css.php");?>
	<link rel="stylesheet" type="text/css" href="assets/styles.css">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	<script src="assets/js/loading.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>

	<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table_jui.css";
			@import "css/jquery-ui-1.8.4.custom.css";
	</style>
	<script src="js/jquery.dataTables.js"></script>
	<script src="assets/js/users.js"></script>

<?php

if (isset($_POST["frmSubmit"])) {

		if (!$_POST['login_name'] || !$_POST['first_name'] || !$_POST['last_name'] || !$_POST['email']) {
			echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
			exit;
		} 

    else {

			try {

				$login_name = $_POST["login_name"];
				
				$query = "UPDATE system.users SET password = :password, first_name = :first_name, last_name = :last_name, email = :email WHERE login_name = :login_name";

				$STH = $db->prepare($query); 

				$STH->execute(array('password' => $_POST['password'], 'first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], ':email' => $_POST['email'], ':login_name' => $login_name));

			} 
        catch (PDOException $e) {
				  echo $e->getMessage();
			  }
			     echo "<script language='javascript' type='text/javascript'>alert('Successfully Saved!')</script>";
			     echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";
		}
}

?>
<body>

	<div id="wrapper">

		<?php include 'sidebar.php'; ?>

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
									  $email        =$row1['email'];
									  $password     =$row1['password'];
									  $enabled      =$row1['enabled'];
									  $terminal     =$row1['terminal']; 

									 }
								  }

							  ?>

								<div id="modal" class="modal-box">

									<header> <a href="users.php" class="js-modal-close close">×</a>
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
									  
									     <footer> <a href="users.php" class="btn btn-small js-modal-close">Close</a> </footer>
                   </form>
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



