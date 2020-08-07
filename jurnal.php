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
		<form method="GET" action="jurnal.php">  
			<input class="textinput1" name="keyword" placeholder="SEARCH ID OR KET." type="text"> 
			<input class="button1" type="submit" value="Search">
		</form>
	 </div>';
echo '<div class="btn-group mr-2" role="group" > <a class="btn btn-secondary" href="jurnaltambah.php">Tambah jurnal</a> </div>';
	
$con = new mysqli($host, $dbid, $dbpass, $dbname);
if (isset($_GET['keyword']) && $_GET['keyword']!='') { // serch 
	//$keyword = "'%{$_GET['keyword']}%'";
	$keyword =  $_GET['keyword'] ;
	if( is_numeric($keyword) == true){
		$stmt = $con->prepare( "SELECT idjurnal, debet, total FROM jurnal WHERE idjurnal LIKE '%$keyword%' ORDER BY idjurnal DESC" ); $stmt->execute();
	}else{
		$stmt = $con->prepare( "SELECT idjurnal, debet, total FROM jurnal WHERE jurnal LIKE '%$keyword%' ORDER BY idjurnal DESC" ); $stmt->execute();
	}
	//$stmt->bind_param("s", $keyword ); 
}else{
	$stmt = $con->prepare( "SELECT idjurnal, debet, total FROM jurnal ORDER BY idjurnal DESC" ); $stmt->execute();
}

$result = $stmt->get_result();
$con->close();
?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID Jurnal</th>
	  <th scope="col">Debet</th>
	  <th scope="col">Kredit</th>
	  <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>

	<?php
	while($row = mysqli_fetch_assoc($result)) {
		$dk='';
		if($row["debet"]==1){
			$dk='<td>'.$row["total"].'</td><td></td>';
		}else{
			$dk='<td></td><td>'.$row["total"].'</td>';
		}
		echo '
		<tr>
		<td>'.$row["idjurnal"].'</td>
		'.$dk.'
		<td>
			<div class="btn-group mr-2" role="group" > <a class="btn btn-primary" href="jurnaldetail.php?idjurnal='.$row["idjurnal"].'">Detail Jurnal</a> </div>
		</td>
		</tr>
		';
	}

?>
  </tbody>
</table>

</div>