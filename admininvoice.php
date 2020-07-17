<html>
<?php 
require('config.php');
	if($statusid !=0){
		echo "<script language='javascript'>alert('Kembali ke home'); window.location.href = 'index.php';</script>";
	}
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="customer.php">Customer</a> </div>'; 
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="produk.php">Barang</a> </div>';
	echo '<div class="btn-group mr-2" role="group" > | </div>';
	echo '<div class="btn-group mr-2" >
			<form method="GET" class="form-group mx-sm-3 mb-2 form-inline" action="index.php">  
				<input class="form-control" name="keyword" placeholder="SEARCH BY ID" type="number"> 
				<input class="btn btn-primary" type="submit" value="Search">
			</form>
		</div>';
	echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="transaksibaru.php">Tambah Transaksi</a> </div>';
	


	
	$con = new mysqli($host, $dbid, $dbpass, $dbname);
	if (isset($_GET['keyword']) && $_GET['keyword']!='') { 
		$keyword =  str_replace("'","",$_GET['keyword'])  ;
		$keyword = $con -> real_escape_string($keyword);
		$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo FROM transaksi WHERE idtransaksi LIKE '%$keyword%' ORDER BY idtransaksi DESC" ); $stmt->execute();
	}else{
		$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo FROM transaksi ORDER BY idtransaksi DESC" ); $stmt->execute();
	}	
	
	$result = $stmt->get_result();
	$con->close();
	
	?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID Transaksi</th>
      <th scope="col">Jatuh Tempo</th>
	  <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

	<?php
	while($row = mysqli_fetch_assoc($result)) {
		echo '
		<tr>
		<a href="transaksidetail.php?idtransaksi='.$row["idtransaksi"].'">
		<td>'.$row["idtransaksi"].'</td>
		<td>'.$row["jatuhtempo"].'</td>
		<td><a href="transaksidetail.php?idtransaksi='.$row["idtransaksi"].'" class="btn btn-primary">Detail</a></td>
		</tr>
		';
	}

?>
  </tbody>
</table>

</html>