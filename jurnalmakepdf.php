<?php
require 'fpdf/fpdf.php';
require('config.php');
    if( isset($_GET["idjurnal"]) ){
        $idjurnal = $_GET["idjurnal"];
        $con = new mysqli($host, $dbid, $dbpass, $dbname);
        $stmt = $con->prepare( "SELECT * FROM jurnal Where idjurnal = ? " );
        $stmt->bind_param("s", $idjurnal ); $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "<script language='javascript'>alert('ID tidak ditemukan');window.location.href = 'index.php';</script>";
        }else{
			while($row = mysqli_fetch_assoc($result)) {
            $idjurnal = strval($row["idjurnal"]);
            $debet = $row["debet"];
            $jurnal = json_decode($row["jurnal"]);
            $total = $row["total"];
			}
		}
    }else{
        echo "<script language='javascript'>alert('ID tidak ada');window.location.href = 'index.php';</script>";
    }
    
$file_pointer = "pdf/".$idjurnal.".pdf"; 

$pdf = new FPDF('p','mm','A4');
$pdf -> SetFont('Arial','B',14);
$pdf -> AddPage();
$pdf->Rect(5, 5, 200, 287, 'D');
//Cell(width , height , text , border , endline , [align])
$pdf -> SetFont('Arial','B',14);
$pdf -> Cell(190, 10, 'JURNAL', 0 , 1, 'C');
$pdf -> SetFont('Arial','B',11);
$pdf -> Cell(190, 7.5, 'No.'.$idjurnal , 0 , 1, 'C');
$pdf -> Cell(190, 7.5, '', 0 , 1, 'C');
$pdf -> Cell(40, 5, '', 0 , 1);
$pdf -> SetFont('Arial','B',10);
$pdf -> Cell(10, 5, 'NO', 1 , 0); $pdf -> Cell(40, 5, 'Kode Akun', 1 , 0); $pdf -> Cell(80, 5, 'Keterangan', 1 , 0); $pdf -> Cell(60, 5, 'Nominal', 1 , 1);
$pdf -> SetFont('Arial','',10);

for($i=0;$i<sizeof($jurnal[0]);$i++){
    $j=$i+1;
    $pdf -> Cell(10, 5, $j , 1 , 0); 
    $pdf -> Cell(40, 5, $jurnal[0][$i], 1 , 0); 
    $pdf -> Cell(80, 5, $jurnal[2][$i], 1 , 0); 
    $pdf -> Cell(60, 5, $jurnal[1][$i], 1 , 1); 
}

$pdf -> Cell(100, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'Total', 0 , 0);    $pdf -> Cell(60, 5, $total, 1 , 1);

$pdf -> Cell(30, 15, '', 0 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, 'Dibuat Oleh', 0 , 1);
$pdf -> Cell(30, 25, '', 0 , 1);
$pdf -> Cell(130, 5, '', 0 , 0); $pdf -> Cell(30, 5, '(Bagian Keuangan)', 0 , 1);

$pdf -> Output($file_pointer,'F');
echo "<script language='javascript'>alert('PDF: ".$idjurnal." Berhasil Dibuat');window.location.href = 'jurnaldetail.php?idjurnal=".$idjurnal."';</script>";
?>