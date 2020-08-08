<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
<?php
require('config.php');
date_default_timezone_set("Asia/Bangkok");
$idcustomer = strval(date('ymdHis', time()));
$nama = $_POST["nama"];
$email = $_POST["email"];
$alamat = $_POST["alamat"];
$telepon = $_POST["telepon"];
if(isset($_POST["npwp"])){
	$npwp = $_POST["npwp"];
}else{
	$npwp = '';
}


	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);	
	$stmt = $con->prepare( "INSERT INTO customer (idcustomer, nama, email, alamat, telepon, npwp) 
							VALUES ( ? , ? , ? , ? , ? , ?)" );
	$stmt->bind_param("ssssss", $idcustomer, $nama, $email, $alamat, $telepon, $npwp); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idcustomer: ".$idcustomer." Berhasil didaftarkan');window.location.href = 'customer.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'customertambah.html';</script>";
	}
  
	
?>