<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap.min.css">
	<div class="container">
<?php
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
$username = $_SESSION["username"];
$nama = $_SESSION["nama"];
$statusid = $_SESSION["statusid"];
if($statusid ==0){
	echo "<script language='javascript'> window.location.href = 'logout.php';</script>";
}
include 'config.php';
include 'navbar.php';
echo '<div class="btn-group mr-2" role="group" ><a href="index.php"><button type="button" class="btn btn-primary" >Back</button></a></div>';
echo '<div class="btn-group mr-2" role="group" >
		<form method="GET" action="warkat.php">  
			<input class="textinput1" name="keyword" placeholder="SEARCH BY No Warkat" type="text"> 
			<input class="button1" type="submit" value="Search">
		</form>
	 </div>';
echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="warkattambah.php">Tambah warkat</a> </div>';
	
$con = new mysqli($host, $dbid, $dbpass, $dbname);
if (isset($_GET['keyword']) && $_GET['keyword']!='') { // serch 
	//$keyword = "'%{$_GET['keyword']}%'";
	$keyword =  $_GET['keyword'] ;
	$stmt = $con->prepare( "SELECT *  FROM warkat WHERE nowarkat LIKE '%$keyword%' ORDER BY kodewarkat DESC" ); $stmt->execute();
	//$stmt->bind_param("s", $keyword ); 
}else{
	$stmt = $con->prepare( "SELECT * FROM warkat ORDER BY kodewarkat DESC" ); $stmt->execute();
}

$result = $stmt->get_result();
$con->close();
?>

<?php
while($row = mysqli_fetch_assoc($result)) {
	if($row["aktif"] == 1 ){
		$statuswarkat = "AKTIF";
	}else{
		$statuswarkat = "TERPAKAI";
	}
	echo '
		<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="input-group">		
				<input type="text" name="kodewarkat" class="input-group-text" value="'.$row["kodewarkat"].'" readonly>
				<input type="text" name="nowarkat" class="form-control" value="'.$row["nowarkat"].'" readonly >
				<input type="text" name="nama" class="form-control" value="'.$row["kodebank"].'" readonly >
				<input type="text" name="status" class="form-control" value="'.$statuswarkat.'" readonly >
				<div class="btn-group mr-2" role="group" ><a href="warkathapus.php?kodewarkat='.$row["kodewarkat"].'" class="btn btn-danger" onclick="return confirm()" >Hapus</a> </div>
				</div>
		</li>
	';
}
?>
</div>