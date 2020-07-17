<?php
require('config.php');
$kodebank = strval($_POST["kodebank"]);
$nama = $_POST["nama"];
$cabang = $_POST["cabang"];

	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "SELECT kodebank FROM bank WHERE  kodebank = ? ");
	$stmt->bind_param("s", $kodebank); $stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows == 0) {
		$stmt = $con->prepare( "INSERT INTO bank (kodebank, namabank, cabang) 
	        VALUES ( ? , ? , ?)" );
		$stmt->bind_param("sss", $kodebank, $nama, $cabang); ;
		$result = $stmt->execute();
		$con->close();
		if($result){
			echo "<script language='javascript'>alert('Kodebank: ".$kodebank." Berhasil didaftarkan');window.location.href = 'bank.php';</script>";
		}else{
			echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'banktambah.html';</script>";
		}
    }else{
		echo "<script language='javascript'>alert('Register Gagal, bank sudah ada!');window.location.href = 'bank.php';</script>";
	}
	
?>