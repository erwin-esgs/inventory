<?php
require('config.php');
$kodebank = $_GET["kodebank"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "DELETE FROM bank WHERE  kodebank = ? ");
$stmt->bind_param("s", $kodebank); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodebank: ".$kodebank." Berhasil Dihapus');window.location.href = 'bank.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Delete Gagal');window.location.href = 'bank.php';</script>";
	}
?>