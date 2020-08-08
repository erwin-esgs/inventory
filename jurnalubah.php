<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
<?php
require('config.php');
$kodejurnal = $_POST["kodejurnal"];
$nama = $_POST["nama"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "UPDATE jurnal SET namajurnal = ? WHERE  kodejurnal = ? ");
$stmt->bind_param("ss", $nama, $kodejurnal); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodejurnal: ".$kodejurnal." Berhasil Diubah');window.location.href = 'jurnal.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Update Gagal');window.location.href = 'jurnal.php';</script>";
	}
?>