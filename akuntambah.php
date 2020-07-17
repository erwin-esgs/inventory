<?php
require('config.php');
$kodeakun = strval($_POST["kodeakun"]);
$nama = $_POST["nama"];

	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "SELECT kodeakun FROM akun WHERE  kodeakun = ? ");
	$stmt->bind_param("s", $kodeakun); $stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows == 0) {
		$stmt = $con->prepare( "INSERT INTO akun (kodeakun, namaakun) 
	        VALUES ( ? , ? )" );
		$stmt->bind_param("ss", $kodeakun, $nama); ;
		$result = $stmt->execute();
		$con->close();
		if($result){
			echo "<script language='javascript'>alert('Kodeakun: ".$kodeakun." Berhasil didaftarkan');window.location.href = 'akun.php';</script>";
		}else{
			echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'akuntambah.html';</script>";
		}
    }else{
		echo "<script language='javascript'>alert('Register Gagal, Akun sudah ada!');window.location.href = 'akun.php';</script>";
	}
	
?>