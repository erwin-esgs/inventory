<?php
require 'fpdf/fpdf.php';
require('config.php');
    if( isset($_GET["idtransaksi"]) ){
        $idtransaksi = $_GET["idtransaksi"];
        $con = new mysqli($host, $dbid, $dbpass, $dbname);
        $stmt = $con->prepare( "SELECT * FROM transaksi Where idtransaksi = ? " );
        $stmt->bind_param("s", $idtransaksi ); $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "<script language='javascript'>alert('ID tidak ditemukan');window.location.href = 'index.php';</script>";
        }
        while($row = mysqli_fetch_assoc($result)) {
            $idcustomer = strval($row["idcustomer"]);
            $jatuhtempo = $row["jatuhtempo"];
            $nopo = $row["nopo"];
            $pembayaran = $row["pembayaran"];
            $produk = json_decode( $row["produk"] );
            $subtotal = $row["subtotal"];
            $diskon = $row["diskon"];
        }
    }else{
        echo "<script language='javascript'>alert('ID tidak ditemukan');window.location.href = 'index.php';</script>";
    }
    $stmt = $con->prepare( "SELECT * FROM customer Where idcustomer = ? " );
    $stmt->bind_param("s", $idcustomer );$stmt->execute();
    $result = $stmt->get_result();
    while($row = mysqli_fetch_assoc($result)) {
        $nama = $row["nama"]."\n";
        $email = $row["email"]."\n";
        $alamat= $row["alamat"]."\n";
        $telepon = $row["telepon"]."\n";
        $npwp = $row["npwp"];
    }
    
$file_pointer = "pdf/".$idtransaksi.".pdf"; 

$pdf = new FPDF('p','mm','A4');
$pdf -> SetFont('Arial','B',14);
$pdf -> AddPage();
$pdf->Rect(5, 5, 200, 287, 'D');
//Cell(width , height , text , border , endline , [align])
$pdf -> Cell(130, 5, 'PT BIJE JAYA PERDANA', 0 , 1);
$pdf -> SetFont('Arial','B',11);
$pdf -> Cell(130, 5, 'Komplek Duta Merlin F-4', 0 , 1);
$pdf -> Cell(130, 5, 'Jalan Gajahmada no.3 RT 2, RW 05. Petojo Utara, Gambir', 0 , 1);
$pdf -> Cell(130, 5, 'Jakarta Pusat. 10130 ', 0 , 1);
$pdf -> Cell(190, 7.5, '', 0 , 1, 'C');
$pdf -> SetFont('Arial','B',14);
$pdf -> Cell(190, 10, 'INVOICE', 0 , 1, 'C');
$pdf -> SetFont('Arial','B',11);
$pdf -> Cell(190, 7.5, 'No.'.$idtransaksi , 0 , 1, 'C');
$pdf -> Cell(190, 7.5, '', 0 , 1, 'C');
$pdf -> SetFont('Arial','',10);
$pdf -> Cell(40, 5, 'ID Customer', 0 , 0);    $pdf -> Cell(80, 5, ': '.$idcustomer , 0 , 0); $pdf -> Cell(30, 5, 'No. PO', 0 , 0);       $pdf -> Cell(30, 5, ': '.$nopo, 0 , 1);
$pdf -> Cell(40, 5, 'Nama Customer', 0 , 0);  $pdf -> Cell(40, 5, ': '.$nama , 0 , 1);
$pdf -> Cell(40, 5, 'Email', 0 , 0);          $pdf -> Cell(80, 5, ': '.$email , 0 , 0); $pdf -> Cell(30, 5, 'Jatuh Tempo', 0 , 0);  $pdf -> Cell(30, 5, ': '.$jatuhtempo , 0 , 1);
$pdf -> Cell(40, 5, 'Alamat', 0 , 0);         $pdf -> Cell(40, 5, ': '.$alamat , 0 , 1);
$pdf -> Cell(40, 5, 'Telepon', 0 , 0);        $pdf -> Cell(40, 5, ': '.$telepon , 0 , 1);
$pdf -> Cell(40, 5, 'NPWP', 0 , 0);           $pdf -> Cell(40, 5, ': '.$npwp , 0 , 1);
$pdf -> Cell(40, 5, '', 0 , 1);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10, 5, 'NO', 1 , 0); $pdf -> Cell(40, 5, 'Kode Barang', 1 , 0); $pdf -> Cell(50, 5, 'Nama Barang', 1 , 0); $pdf -> Cell(30, 5, 'Quantity', 1 , 0); $pdf -> Cell(30, 5, 'Harga Satuan', 1 , 0); $pdf -> Cell(30, 5, 'Harga', 1 , 1);
$pdf -> SetFont('Arial','',10);

for($i=0;$i<sizeof($produk[0]);$i++){
    $j=$i+1;
    $pdf -> Cell(10, 5, $j , 1 , 0); 
    $pdf -> Cell(40, 5, $produk[0][$i], 1 , 0); 
    $pdf -> Cell(50, 5, $produk[1][$i], 1 , 0); 
    $pdf -> Cell(30, 5, $produk[2][$i], 1 , 0); 
    $pdf -> Cell(30, 5, $produk[3][$i], 1 , 0); 
    $pdf -> Cell(30, 5, $produk[4][$i], 1 , 1);
}

$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'Subtotal', 0 , 0); $pdf -> Cell(30, 5, $subtotal, 1 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'Diskon', 0 , 0);   $pdf -> Cell(30, 5, $diskon, 1 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'Total', 0 , 0);    $pdf -> Cell(30, 5, $subtotal-$diskon, 1 , 1);

$pdf -> Cell(30, 15, '', 0 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'PT BIJE JAYA PERDANA', 0 , 1);
$pdf -> Cell(30, 25, '', 0 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, '(Manager Keuangan)', 0 , 1);

$pdf -> Output($file_pointer,'F');
echo "<script language='javascript'>alert('PDF: ".$idtransaksi." Berhasil Dibuat');window.location.href = 'transaksidetail.php?idtransaksi=".$idtransaksi."';</script>";
?>