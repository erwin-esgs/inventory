<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
<?php
require('config.php');
$idproduk = $_GET["idproduk"];

	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	$stmt = $con->prepare( "DELETE FROM produk WHERE  idproduk = ? ");
	$stmt->bind_param("s", $idproduk); ;
	$result = $stmt->execute();
	$con->close();
	if($result){
		echo "<script language='javascript'>alert('Idproduk: ".$idproduk." Berhasil Dihapus');window.location.href = 'produk.php';</script>";
	}else{
		echo "<script language='javascript'>alert('Gagal');window.location.href = 'produktambah.html';</script>";
	}
 
	
?>