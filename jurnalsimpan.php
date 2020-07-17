<?php
session_start();
require('config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Bangkok");
$idjurnal = strval(date('YmdHis', time()));

$warkat = strval($_POST["warkat"]);
$namawarkat = explode(" ",$_POST["warkat"]);
$kodewarkat = strval($namawarkat[0]);
$nowarkat = intval($namawarkat[1]);

$kodeakun = $_POST["kodeakun"];
$nominal = $_POST["nominal"];
$keterangan = $_POST["keterangan"];

$total = $_POST["total"];

$data = [];
array_push($data, $kodeakun, $nominal, $keterangan);
$json_data =  json_encode($data);
$debet=0;

$con = new mysqli($host, $dbid, $dbpass, $dbname);

$stmt = $con->prepare( "UPDATE warkat SET aktif = 0 WHERE  kodewarkat = ? AND nowarkat = ? ");
$stmt->bind_param("si", $kodewarkat, $nowarkat); 
$result = $stmt->execute();

$stmt = $con->prepare( "INSERT INTO jurnal (idjurnal, debet, jurnal, total, warkat) 
                        VALUES ( ? , ? , ? , ? , ?)" );
$stmt->bind_param("sisis", $idjurnal, $debet, $json_data, $total, $warkat); 
$result = $stmt->execute();
$con->close();
if($result){
    echo "<script language='javascript'>alert('Jurnal: ".$idjurnal." Berhasil Dibuat');window.location.href = 'jurnal.php';</script>";
}else{
    echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'jurnal.php';</script>";
}

?>