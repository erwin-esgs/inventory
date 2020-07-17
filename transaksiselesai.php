<?php
require('config.php');
$idtransaksi = $_GET["idtransaksi"];
$status=0;

$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "UPDATE transaksi SET status = ? WHERE  idtransaksi = ? ");
$stmt->bind_param("is", $status, $idtransaksi); 
$result = $stmt->execute();

$stmt = $con->prepare( "SELECT subtotal, diskon FROM transaksi Where idtransaksi = ? " );
$stmt->bind_param("s", $idtransaksi ); $stmt->execute();
$result = $stmt->get_result();
$nominal = 0;
while($row = mysqli_fetch_assoc($result)) {
	$nominal = $row["subtotal"] - $row["diskon"];
}

$debet = 1;

$kodeakun = []; array_push($kodeakun , '2300001');
$total = [];  array_push($total, $nominal);
$keterangan = []; array_push( $keterangan , 'Transaksi '.$idtransaksi.' selesai');

$data = [];
array_push($data, $kodeakun, $total, $keterangan);
$json_data =  json_encode($data);
$warkat = '';
$stmt = $con->prepare( "INSERT INTO jurnal (idjurnal, debet, jurnal, total, warkat) 
                        VALUES ( ? , ? , ? , ? , ?)" );
$stmt->bind_param("sisis", $idtransaksi, $debet, $json_data, $nominal, $warkat); 
$result = $stmt->execute();
$con->close();
if($result){
		echo "<script language='javascript'>alert('Transaksi: ".$idtransaksi." telah selesai');window.location.href = 'index.php';</script>";
	}else{
		//echo "<script language='javascript'>alert('Update Gagal');window.location.href = 'index.php';</script>";
	}
?>