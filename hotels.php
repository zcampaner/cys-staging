<?php 

session_start();
	if (!isset($_SESSION["myusername"]))	
		header("location:login.php");

	require_once ("dbconnection.php"); 
	
		if(isset($_GET['hotel_code'])){
			
			$ppid = $_GET['hotel_code'];
			$sqlLoader="Select from system.hotels where hotel_code=?";
			$resLoader=$db->prepare($sqlLoader);
			$resLoader->execute(array($ppid));		

			while($rowLoader = $resLoader->fetch(PDO::FETCH_ASSOC)){

				$hotel_code=$rowLoader['hotel_code'];
				$hotel=$rowLoader['hotel'];	
				$status=$rowLoader['status'];
				$chain_code=$rowLoader['chain_code'];

			}
	} 

	if (isset($_POST["frmSubmit"])) {

			if (!$_POST['hotel_code'] || !$_POST['hotel'] || !$_POST['status'] || !$_POST['chain_code']) {
				echo "<p>Please supply all of the data! You may press your back button to attempt again minion!</p>";
				exit;
			} 

	    else {

				try {

					$hotel_code = $_POST["hotel_code"];
					
					$query = "UPDATE system.hotels SET hotel = :hotel, status = :status, chain_code = :chain_code WHERE hotel_code = :hotel_code";

					$STH = $db->prepare($query); 

					$STH->execute(array('hotel' => $_POST['hotel'], 'status' => $_POST['status'], ':chain_code' => $_POST['chain_code'], ':hotel_code' => $hotel_code));

				} 
	        catch (PDOException $e) {
					  echo $e->getMessage();
				  }
				     echo "<script language='javascript' type='text/javascript'>alert('Successfully Saved!')</script>";
				     echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";
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
	<script src="assets/js/hotels.js"></script>
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

								  if(isset($_GET['hotel_code'])){
									 require_once ("dbconnection.php");  

									  $ppid1 = $_GET['hotel_code'];

									  $sqledit="SELECT* FROM system.hotels WHERE hotel_code='$ppid1'";
									   $res1=$db->prepare($sqledit);
									   $res1->execute();
									   $result1 = $res1->fetchALL(PDO::FETCH_ASSOC); 
									 foreach ($result1 as $row1) {
									  // while($rowadd = $resadd->fetchALL(PDO::FETCH_ASSOC)){
									  $hotel_code   =$row1['hotel_code'];
									  $hotel   		=$row1['hotel'];
									  $status    	=$row1['status'];  
									  $chain_code   =$row1['chain_code'];

									 }
								  }

							  ?>

								<div id="modal" class="modal-box">

									<header> <a href="hotels.php" class="js-modal-close close">×</a>
									  <h3 id="ed">EDIT</h3>
									  <h3 id="ad">ADD</h3>
									</header>

									<div class="modal-body">
								    <form method="POST" action="">
									     <p>Enter the below information if you want to insert:</p>
									     Hotel Code <input type="text" name="hotel_code" id="hotel_code" value = "<?php echo $hotel_code; ?>" required/><br />
									     Hotel <input type="text" name="hotel" id="hotel" required/><br />
									     Status <select name="status" id="status" required/><br />
                                    				<option value="ACTIVE">Active</option>
                                    				<option value="INACTIVE">Inactive</option>
                                    				<option value="SUSPENDED">Suspended</option>
                               					</select><br />
									     Chain Code <input type="text" name="chain_code" id="chain_code" required/><br />

									     <input type="button" id="add_button" name="frmSubmit" value="Do-It">
									     <input type="button" id="edit_button" name="frmSubmit" value="Do-It">
									  
									     <footer> <a href="hotels.php" class="btn btn-small js-modal-close">Close</a> </footer>
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
											* FROM system.hotels";
											$res=$db->prepare($sql);
											$res->execute();
											$result = $res->fetchALL(PDO::FETCH_ASSOC);  
											$str="<div class='container'>";
    $str="<div class='row'>";
            $str="<div class='box clearfix'>"; 
											$str="<div class='demo_jui'><table cellpadding='0' cellspacing='0' border='0' class='display' id='bootstrap-table' class='table table-hover'>";
											$str.="<thead>
												  <tr><th>Hotel Code</th>
													<th>Hotel</th>
													<th>Status</th>
													<th>Chain Code</th>
													</tr>
												</thead>
											  <tbody>";
											  foreach ($result as $row) {
												$sStatus = $row['status'];
												if ($sStatus=="ACTIVE") {
													$sActive = "Active";
												  }
												  else {
													$sActive = "Inactive";
												  }
												$str.="<tr><td id='".$row['hotel_code']."' value='attr'><center>".$row['hotel_code']."</center></td>";
												$str.="<td width='10%'>".$row['hotel']."</td>";
												$str.="<td width='10%'>".$sActive."</td>";
												$str.="<td width='10%'>".$row['chain_code']."</td>";
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
	
<script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>	
<script src="js/vendor/jquery.sortelements.js" type="text/javascript"></script>
<script src="js/jquery.bdt.js" type="text/javascript"></script>
<script>
    $(document).ready( function () {
        $('#bootstrap-table').bdt();
    });
</script>
</body>
</html>


