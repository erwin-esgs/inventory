<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
<?php
require('config.php');
$kodejurnal = $_GET["kodejurnal"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "DELETE FROM jurnal WHERE  kodejurnal = ? ");
$stmt->bind_param("s", $kodejurnal); 
$result = $stmt->execute();
if($result){
		echo "<script language='javascript'>alert('Kodejurnal: ".$kodejurnal." Berhasil Dihapus');window.location.href = 'jurnal.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Delete Gagal');window.location.href = 'jurnal.php';</script>";
	}
?>