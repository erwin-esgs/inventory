<?php
require('config.php');
$idcustomer = $_POST["idcustomer"];
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
	$stmt = $con->prepare( "UPDATE customer SET nama = ?, email = ?, alamat = ?, telepon = ?, npwp = ?
			WHERE  idcustomer = ? ");
	$stmt->bind_param("ssssss",  $nama, $email, $alamat, $telepon, $npwp, $idcustomer); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idcustomer: ".$idcustomer." Berhasil Diubah');window.location.href = 'customer.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Perubahan Gagal');window.location.href = 'customertambah.html';</script>";
	}
 
	
?>