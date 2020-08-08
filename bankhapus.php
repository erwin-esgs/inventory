<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
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