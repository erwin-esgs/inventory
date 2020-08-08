<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
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