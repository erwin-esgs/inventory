<?php
require('config.php');
$kodebank = $_POST["kodebank"];
$nama = $_POST["nama"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "UPDATE bank SET namabank = ? WHERE  kodebank = ? ");
$stmt->bind_param("ss", $nama, $kodebank); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodebank: ".$kodebank." Berhasil Diubah');window.location.href = 'bank.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Update Gagal');window.location.href = 'bank.php';</script>";
	}
?>