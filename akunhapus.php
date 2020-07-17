<?php
require('config.php');
$kodeakun = $_GET["kodeakun"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "DELETE FROM akun WHERE  kodeakun = ? ");
$stmt->bind_param("s", $kodeakun); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodeakun: ".$kodeakun." Berhasil Dihapus');window.location.href = 'akun.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Delete Gagal');window.location.href = 'akun.php';</script>";
	}
?>