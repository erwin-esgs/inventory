<?php
require('config.php');
$idcustomer = $_GET["idcustomer"];

	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "DELETE FROM customer WHERE  idcustomer = ? ");
	$stmt->bind_param("s", $idcustomer); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idcustomer: ".$idcustomer." Berhasil Dihapus');window.location.href = 'customer.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Gagal');window.location.href = 'customertambah.html';</script>";
	}
 
	
?>