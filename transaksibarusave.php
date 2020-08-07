<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); ?>
<?php
require('config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("Asia/Bangkok");
$idtransaksi = strval(date('YmdHis', time()));
$idcustomer = $_POST["idcustomer"];
$jatuhtempo = str_replace("-","",$_POST["jatuhtempo"]);
$jatuhtempo = date('Ymd', strtotime("+".$jatuhtempo." day"));
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
    $stmt = $con->prepare( "SELECT namaproduk, stok FROM produk WHERE idproduk = ?" );
    $stmt->bind_param("s",  $idproduk[$i]); 
    $result = $stmt->execute();
    $result = $stmt->get_result();
    while($row = mysqli_fetch_assoc($result)) {
        array_push($namaproduk, $row['namaproduk']);
		$stok = $row["stok"] - $qty[$i];
    }
	$stmt = $con->prepare( "UPDATE produk SET stok = ? WHERE idproduk = ?" );
    $stmt->bind_param("is", $stok, $idproduk[$i]); 
    $result = $stmt->execute();
}

$data = [];
array_push($data, $idproduk, $namaproduk, $qty, $hargasatuan, $harga);
$json_data =  json_encode($data);
$status=1;

$stmt = $con->prepare( "INSERT INTO transaksi (idtransaksi, idcustomer, jatuhtempo, nopo, pembayaran , produk , subtotal, diskon, status) 
                        VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ?)" );
$stmt->bind_param("ssisssiii", $idtransaksi, $idcustomer, $jatuhtempo, $nopo, $pembayaran , $json_data , $subtotal, $diskon, $status); 
$result = $stmt->execute();
$con->close();
if($result){
    echo "<script language='javascript'>alert('Idtransaksi: ".$idtransaksi." Berhasil Dibuat');window.location.href = 'transaksidetail.php?idtransaksi=".$idtransaksi."';</script>";
}else{
    echo "<script language='javascript'>alert('Register Gagal');window.location.href = 'transaksibaru.php';</script>";
}

?>