<html>
<?php 
require('config.php');
	if($statusid ==0){
		echo "<script language='javascript'>alert('Kembali ke home'); window.location.href = 'index.php';</script>";
	}
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="jurnal.php">Jurnal</a> </div>';
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="akun.php">Akun</a> </div>';
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="Bank.php">Bank</a> </div>';
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="warkat.php">Warkat</a> </div>';
	echo '<div class="btn-group mr-2" role="group" > | </div>';
	echo '<div class="btn-group mr-2" >
			<form method="GET" class="form-group mx-sm-3 mb-2 form-inline" action="index.php">  
				<input class="form-control" name="keyword" placeholder="SEARCH BY ID/Ket" type="text"> 
				<input class="btn btn-primary" type="submit" value="Search">
			</form>
		</div>';
	


	$jatuhtempo = intval(date('Ymd', time()));
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	if (isset($_GET['keyword']) && $_GET['keyword']!='') { 
		$keyword =  str_replace("'","",$_GET['keyword'])  ;
		$keyword = $con -> real_escape_string($keyword);
		if( is_numeric($keyword) == true){
			$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo, status FROM transaksi WHERE idtransaksi LIKE '%$keyword%' ORDER BY jatuhtempo DESC" ); $stmt->execute();
		}else{
			$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo, status FROM transaksi WHERE produk LIKE '%$keyword%' ORDER BY jatuhtempo DESC" ); $stmt->execute();
		}
	}else{
		$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo, status , jatuhtempo - $jatuhtempo AS DIFFERENCE FROM transaksi ORDER BY DIFFERENCE ASC" ); $stmt->execute();
	}	
	
	$result = $stmt->get_result();
	$con->close();
	
	?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID Transaksi</th>
      <th scope="col">Jatuh Tempo</th>
	  <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

	<?php
	while($row = mysqli_fetch_assoc($result)) {
		$tombolselesai = '';
		if($row["status"]==1){
			$tombolselesai = '<a href="transaksiselesai.php?idtransaksi='.$row["idtransaksi"].'" class="btn btn-success" onclick="return confirm(\'Anda yakin transaksi ini dselesaikan?\')">Selesai</a>';
		}
		echo '
		<tr>
		<td>'.$row["idtransaksi"].'</td>
		<td>'.$row["jatuhtempo"].'</td>
		<td><a href="transaksidetail.php?idtransaksi='.$row["idtransaksi"].'" class="btn btn-primary">Detail</a>'.$tombolselesai.'</td>
		</tr>
		';
	}

?>
  </tbody>
</table>

</html>