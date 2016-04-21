<?php
session_start();
session_destroy();
echo "<script language='javascript' type='text/javascript'>alert('Successfully Logged Logout!')</script>";
echo "<script language='javascript' type='text/javascript'>window.open('index.php','_self')</script>";

