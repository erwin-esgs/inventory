<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap.min.css">
	<div class="container">
<?php
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
		<form method="GET" action="bank.php">  
			<input class="textinput1" name="keyword" placeholder="SEARCH BY ID" type="text"> 
			<input class="button1" type="submit" value="Search">
		</form>
	 </div>';
echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="banktambah.html">Tambah bank</a> </div>';
	
$con = new mysqli($host, $dbid, $dbpass, $dbname);
if (isset($_GET['keyword']) && $_GET['keyword']!='') { // serch 
	//$keyword = "'%{$_GET['keyword']}%'";
	$keyword =  $_GET['keyword'] ;
	$stmt = $con->prepare( "SELECT kodebank, namabank FROM bank WHERE kodebank LIKE '%$keyword%' ORDER BY kodebank DESC" ); $stmt->execute();
	//$stmt->bind_param("s", $keyword ); 
}else{
	$stmt = $con->prepare( "SELECT kodebank, namabank FROM bank ORDER BY kodebank DESC" ); $stmt->execute();
}

$result = $stmt->get_result();
$con->close();
?>

<?php
while($row = mysqli_fetch_assoc($result)) {
	echo '
		<li class="list-group-item d-flex justify-content-between align-items-center">
			<form action="bankubah.php"method="POST">
				<div class="input-group">		
				<input type="text" name="kodebank" class="input-group-text" value="'.$row["kodebank"].'" readonly>
				<input type="text" name="nama" class="form-control" value="'.$row["namabank"].'"  >
				<div class="btn-group mr-2" role="group" > <button type="submit" class="btn btn-primary" onclick="return confirm()" >Ubah</button> </div>
				<div class="btn-group mr-2" role="group" ><a href="bankhapus.php?kodebank='.$row["kodebank"].'" class="btn btn-danger" onclick="return confirm()" >Hapus</a> </div>
				</div>
			</form>
		</li>
	';
}
?>
</div>