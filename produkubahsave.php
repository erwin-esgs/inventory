<?php
require('config.php');
$idproduk = $_POST["idproduk"];
$namaproduk = $_POST["namaproduk"];
$stok = intval($_POST["stok"]);



	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "UPDATE produk SET namaproduk = ?, stok = ?
			WHERE  idproduk = ? ");
	$stmt->bind_param("sis",  $namaproduk, $stok, $idproduk); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idproduk: ".$idproduk." Berhasil Diubah');window.location.href = 'produk.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Perubahan Gagal');window.location.href = 'produktambah.html';</script>";
	}
 
	
?>