<?php
session_start();
require('config.php');
date_default_timezone_set("Asia/Bangkok");
$idtransaksi = strval(date('ymdHis', time()));
$idcustomer = $_POST["idcustomer"];
$jatuhtempo = $_POST["jatuhtempo"];
$nopo = $_POST["nopo"];
$pembayaran = $_POST["pembayaran"];

$idproduk = $_POST["idproduk"];
$qty = $_POST["qty"];
$hargasatuan = $_POST["hargasatuan"];
$harga = $_POST["harga"];

$subtotal = $_POST["subtotal"];
$diskon = $_POST["diskon"];
$total = $_POST["total"];

$con = new mysqli($host, $dbid, $dbpass, $dbname);
$namaproduk =[];
for($i=0; $i<sizeof($idproduk); $i++){
    $stmt = $con->prepare( "SELECT namaproduk FROM produk WHERE idproduk = ?" );
    $stmt->bind_param("s",  $idproduk[$i]); 
    $result = $stmt->execute();
    $result = $stmt->get_result();
    while($row = mysqli_fetch_assoc($result)) {
        array_push($namaproduk, $row['namaproduk']);
    }
}

$data = [];
array_push($data, $idproduk, $namaproduk, $qty, $hargasatuan, $harga);
$json_data =  json_encode($data);
 

$stmt = $con->prepare( "INSERT INTO transaksi (idtransaksi, idcustomer, jatuhtempo, nopo, pembayaran , produk , subtotal, diskon) 
                        VALUES ( ? , ? , ? , ? , ? , ? , ? , ?)" );
$stmt->bind_param("ssisssii", $idtransaksi, $idcustomer, $jatuhtempo, $nopo, $pembayaran , $json_data , $subtotal, $diskon); 
$result = $stmt->execute();
$con->close();
if($result){
    echo "<script language='javascript'>alert('Idtransaksi: ".$idtransaksi." Berhasil Dibuat');window.location.href = 'transaksidetail.php?idtransaksi=".$idtransaksi."';</script>";
}else{
    echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'transaksibaru.php';</script>";
}

?>