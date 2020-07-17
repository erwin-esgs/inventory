<?php
require('config.php');
$kodeakun = $_POST["kodeakun"];
$nama = $_POST["nama"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "UPDATE akun SET namaakun = ? WHERE  kodeakun = ? ");
$stmt->bind_param("ss", $nama, $kodeakun); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodeakun: ".$kodeakun." Berhasil Diubah');window.location.href = 'akun.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Update Gagal');window.location.href = 'akun.php';</script>";
	}
?>