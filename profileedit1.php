<?php
<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); ?>
require('config.php');
$username = $_SESSION["username"];
$oldpassword = md5($_POST["oldpassword"]);
$password = md5($_POST["password"]);

	//$con = mysqli_connect($host,$dbid,$dbpass,$dbname);
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	//cek username
	$stmt = $con->prepare( "SELECT password FROM user WHERE  username = ? AND password = ? ");
	$stmt->bind_param("ss", $username, $oldpassword); $stmt->execute();
	$result = $stmt->get_result();
	
	if ($result->num_rows == 1) {
		$stmt = $con->prepare( "UPDATE user SET password = ?   WHERE  username = ? " );
		$stmt->bind_param("ss",  $password, $username); 
		$result = $stmt->execute();
		$con->close();
		if($result){
			echo "<script language='javascript'>alert('Password: ".$username." Berhasil Diubah');window.location.href = 'index.php';</script>";
		}else{
			echo "<script language='javascript'>alert('Perubahan Gagal');window.location.href = 'index.php';</script>";
		}
    }else{
		echo "<script language='javascript'>alert('Edit Gagal, Password salah!');window.location.href = 'index.php';</script>";
	}
	
?>