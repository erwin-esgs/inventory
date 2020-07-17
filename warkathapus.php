<?php
require('config.php');
$kodewarkat = $_GET["kodewarkat"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "DELETE FROM warkat WHERE  kodewarkat = ? ");
$stmt->bind_param("s", $kodewarkat); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodewarkat: ".$kodewarkat." Berhasil Dihapus');window.location.href = 'warkat.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Delete Gagal');window.location.href = 'warkat.php';</script>";
	}
?>