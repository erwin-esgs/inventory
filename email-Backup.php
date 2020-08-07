<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require('config.php');
require 'fpdf/fpdf.php';

date_default_timezone_set("Asia/Bangkok");
$datenow = date('Y-m-d');

$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo, idcustomer, jatuhtempo , nopo , pembayaran , produk , subtotal , diskon FROM transaksi");
$stmt->execute();
$result = $stmt->get_result();
$datenow = strtotime($datenow);
while($row = mysqli_fetch_assoc($result)) {
	
	$daterow = strtotime(substr_replace(substr_replace($row["jatuhtempo"],"-",4,0),"-",7,0));
	$secs = $daterow - $datenow;
	// echo $datenow." datenow <br>";
	// echo $daterow." dateRow <br>";
	// echo $secs." sec <br>";
	$days = $secs / 86400;
	//echo $days." days<br><br>";
		
	if($days <= 5 && $days > 0){
		
	//======================	

		$idtransaksi = $row["idtransaksi"]; //echo $idtransaksi."<br>";
		$idcustomer = strval($row["idcustomer"]);
		$jatuhtempo = $row["jatuhtempo"]; //echo $jatuhtempo."<br><br>";
		$nopo = $row["nopo"];
		$pembayaran = $row["pembayaran"];
		$produk = json_decode( $row["produk"] );
		$subtotal = $row["subtotal"];
		$diskon = $row["diskon"];
		
		$stmt1 = $con->prepare( "SELECT nama, email, alamat, telepon, npwp FROM customer Where idcustomer = ? ");
		$stmt1->bind_param("s", $idcustomer );
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		while($row1 = mysqli_fetch_assoc($result1)) {
			$nama = $row1["nama"]."\n";
			$email = $row1["email"];
			$alamat= "\n".$row1["alamat"]."\n";
			$telepon = $row1["telepon"]."\n";
			$npwp = $row1["npwp"];
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
		//======================	
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = $SMTPSecure;
		$mail->Host = $Host;
		$mail->Port = $Port;
		$mail->isHTML();
		$mail->Username = $mailUsername;
		$mail->Password = $mailPassword;
		$mail->SetFrom($SetFrom);
		$mail->Subject = 'Mohon dibayarkan tagihan yang sudah jatuh tempo';
		$mail->Body = "Dear customer PT BIJE JAYA PERDANA, <br><br> Terlampir tagihan invoice yang akan jatuh tempo, 
		mohon segera melakukan pembayaran sesuai tanggal jatuh tempo. <br><br> Terima kasih. <br> Regards, <br> Admin keuangan";
		$mail->addAttachment("pdf/".$idtransaksi.".pdf");
		$mail->AddAddress($email);
		$mail->Send();
	
	}


}

$con->close();
echo "<script language='javascript'>window.location.href = 'index.php';</script>";
?>