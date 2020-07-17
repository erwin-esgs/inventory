<?php
require('config.php');
$kodewarkat = $_POST["kodewarkat"];
$kodebank = $_POST["kodebank"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "UPDATE warkat SET kodebank = ? WHERE  kodewarkat = ? ");
$stmt->bind_param("ss", $kodebank, $kodewarkat); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodewarkat: ".$kodewarkat." Berhasil Diubah');window.location.href = 'warkat.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Update Gagal');window.location.href = 'warkat.php';</script>";
	}
?>