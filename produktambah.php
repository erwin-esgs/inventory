<?php
require('config.php');
date_default_timezone_set("Asia/Bangkok");
$idproduk = strval(date('ymdHis', time()));
$namaproduk = $_POST["namaproduk"];
$stok = intval($_POST["stok"]);

	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "INSERT INTO produk (idproduk, namaproduk, stok) 
							VALUES ( ? , ? , ?)" );
	$stmt->bind_param("ssi", $idproduk, $namaproduk, $stok); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idproduk: ".$idproduk." Berhasil didaftarkan');window.location.href = 'produk.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'produktambah.html';</script>";
	}
	
?>