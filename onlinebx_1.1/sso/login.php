<?php
header("Content-Type: text/html; charset=utf-8");
require_once 'CAS-1.3.3/CAS.php';
//require_once '/application/controllers/user.php';
 phpCAS::setDebug('debug');
 

phpCAS::client(CAS_VERSION_2_0, 'cas.uat.qa.nt.ctripcorp.com', 80, 'caso');
phpCAS::setNoCasServerValidation();
phpCAS::forceAuthentication();

//redirect("index.php/welcome/index");
//	$u1=new User();
//	$u1->loginpost();
if (isset($_REQUEST['logout'])) {

	phpCAS::logout(array('service'=>'http://'.$_SERVER['HTTP_HOST'].'/onlinebx_1.1/index.php'));
}
//echo '<a href="?logout=">Logout</a>';

//print_r($_SESSION['phpCAS']);
//echo'<script>alert($_SESSION["phpCAS"])</script>';
//echo '<script>alert($_SESSION["phpCAS"]);</script>';
//print_r( '<script>alert('.$_SESSION['phpCAS'].')</script>');
//echo "<script type='text/javascript'>alert($_SESSION['phpCAS']);</script>";
?>