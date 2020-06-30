<?php session_start(); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="css/bootstrap.min.css">

<div class="container">
<?php
$username = $_SESSION["username"];
$nama = $_SESSION["nama"];
$statusid = $_SESSION["statusid"];
require('config.php');
include 'navbar.php';

	if($statusid !=0){
		echo "<script language='javascript'>alert('Kembali ke home'); window.location.href = 'index.php';</script>";
    }
    echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-primary" href="index.php">Back</a> </div>'; 
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="customer.php">Customer</a> </div>';
    echo '<div class="btn-group mr-2" role="group" > | </div>';
    echo '<div class="btn-group mr-2" >
			<form method="GET" class="form-group mx-sm-3 mb-2 form-inline" action="index.php">  
				<input class="form-control" name="keyword" placeholder="SEARCH BY ID" type="number"> 
				<input class="btn btn-primary" type="submit" value="Search">
			</form>
		  </div>';
	
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="produktambah.html">Tambah produk</a> </div>';

	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	if (isset($_GET['keyword']) && $_GET['keyword']!='') { 
		$keyword =  str_replace("'","",$_GET['keyword'])  ;
		$keyword = $con -> real_escape_string($keyword);
		$stmt = $con->prepare( "SELECT * FROM produk WHERE idproduk LIKE '%$keyword%' ORDER BY idproduk DESC" ); $stmt->execute();
	}else{
		$stmt = $con->prepare( "SELECT * FROM produk ORDER BY idproduk DESC" ); $stmt->execute();
	}	
	
	$result = $stmt->get_result();
	$con->close();
	while($row = mysqli_fetch_assoc($result)) {
		echo '
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="input-group">
					<input type="text" name="idproduk" class="form-control" value="'.$row["idproduk"].'" readonly>
					<input type="text" name="namaproduk" class="form-control" value="'.$row["namaproduk"].'"  readonly>
					<input type="text" name="stok" class="form-control" value="'.$row["stok"].'"  readonly>
                    <div class="btn-group mr-2" role="group" > <a class="btn btn-primary" href="produkubah.php?idproduk='.$row["idproduk"].'">Ubah</a> </div>
                    <div class="btn-group mr-2" role="group" > <a class="btn btn-danger" href="produkhapus.php?idproduk='.$row["idproduk"].'" onclick="return confirm()">Hapus</a> </div>
				</div>
			</li>
		';
	}
?>
</div>