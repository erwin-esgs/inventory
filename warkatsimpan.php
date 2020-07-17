<?php
require('config.php');
$kodewarkat = strval($_POST["kodewarkat"]);
$nowarkat = intval($_POST["nowarkat"]);
$kodebank = $_POST["kodebank"];
$aktif=1;
	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "SELECT kodewarkat, nowarkat FROM warkat WHERE  kodewarkat = ? AND nowarkat = ?");
	$stmt->bind_param("si", $kodewarkat, $nowarkat); $stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows == 0) {
		for($i=0; $i<25; $i++){
			$stmt = $con->prepare( "INSERT INTO warkat (kodewarkat, nowarkat ,kodebank, aktif) 
	        VALUES ( ? , ? , ? , ?)" );
			$stmt->bind_param("sisi", $kodewarkat, $nowarkat, $kodebank, $aktif); ;
			$result = $stmt->execute();
			$nowarkat = $nowarkat + 1;
		}
		$con->close();
		if($result){
			echo "<script language='javascript'>alert('25 lembar: ".$kodewarkat." Berhasil didaftarkan');window.location.href = 'warkat.php';</script>";
		}else{
			echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'warkattambah.html';</script>";
		}
    }else{
		echo "<script language='javascript'>alert('Register Gagal, warkat sudah ada!');window.location.href = 'warkat.php';</script>";
	}
	
?>