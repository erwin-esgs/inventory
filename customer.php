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
    echo '<div class="btn-group mr-2" role="group" > | </div>';
    echo '<div class="btn-group mr-2" >
			<form method="GET" class="form-group mx-sm-3 mb-2 form-inline" action="index.php">  
				<input class="form-control" name="keyword" placeholder="SEARCH BY ID" type="number"> 
				<input class="btn btn-primary" type="submit" value="Search">
			</form>
		  </div>';
	
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="customertambah.html">Tambah Customer</a> </div>';

	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	if (isset($_GET['keyword']) && $_GET['keyword']!='') { 
		$keyword =  str_replace("'","",$_GET['keyword'])  ;
		$keyword = $con -> real_escape_string($keyword);
		$stmt = $con->prepare( "SELECT * FROM customer WHERE idcustomer LIKE '%$keyword%' ORDER BY idcustomer DESC" ); $stmt->execute();
	}else{
		$stmt = $con->prepare( "SELECT * FROM customer ORDER BY idcustomer DESC" ); $stmt->execute();
	}	
	
	$result = $stmt->get_result();
	$con->close();
	while($row = mysqli_fetch_assoc($result)) {
		echo '
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="input-group">
					<input type="text" name="idcustomer" class="form-control" value="'.$row["idcustomer"].'" readonly>
					<input type="text" name="nama" class="form-control" value="'.$row["nama"].'"  readonly>
					<input type="text" name="alamat" class="form-control" value="'.$row["alamat"].'"  readonly>
					<input type="text" name="telepon" class="form-control" value="'.$row["telepon"].'"  readonly>
                    <input type="text" name="npwp" class="form-control" value="'.$row["npwp"].'"  readonly>
                    <div class="btn-group mr-2" role="group" > <a class="btn btn-primary" href="customerubah.php?idcustomer='.$row["idcustomer"].'">Ubah</a> </div>
                    <div class="btn-group mr-2" role="group" > <a class="btn btn-danger" href="customerhapus.php?idcustomer='.$row["idcustomer"].'" onclick="return confirm()">Hapus</a> </div>
				</div>
			</li>
		';
	}
?>
</div>