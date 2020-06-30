<html>
<?php 
require('config.php');
	if($statusid !=1){
		echo "<script language='javascript'>alert('Kembali ke home'); window.location.href = 'index.php';</script>";
	}
	echo '<div class="btn-group mr-2" >
			<form method="GET" class="form-group mx-sm-3 mb-2 form-inline" action="index.php">  
				<input class="form-control" name="keyword" placeholder="SEARCH BY ID" type="number"> 
				<input class="btn btn-primary" type="submit" value="Search">
			</form>
		</div>';


	
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
	while($row = mysqli_fetch_assoc($result)) {
		echo '
		<a href="transaksidetail.php?idtransaksi='.$row["idtransaksi"].'">
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<div class="input-group">
					<div class="col-5">
						<input type="text" name="idtransaksi" class="form-control" value="'.$row["idtransaksi"].'" readonly>
					</div>
					<div class="col-2">
						<input type="text" name="idtransaksi" class="form-control" value="'.$row["jatuhtempo"].'" readonly>
					</div>
				</div>
			</li>
		</a>
		';
	}

?>


</html>