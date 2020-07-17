<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require('config.php');

date_default_timezone_set("Asia/Bangkok");
$datenow = date('Ymd');

$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "SELECT idtransaksi, jatuhtempo, idcustomer FROM transaksi");
$stmt->execute();
$result = $stmt->get_result();
while($row = mysqli_fetch_assoc($result)) {
	if($datenow == $row["jatuhtempo"]){
	
		$stmt = $con->prepare( "SELECT email FROM customer WHERE idcustomer = ?");
		$stmt->bind_param("s", $row["idcustomer"] );
		$stmt->execute();
		$result1 = $stmt->get_result();
		while($row1 = mysqli_fetch_assoc($result1)) {
			$email = $row1["email"];
		}
				
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
		$mail->Subject = 'Mohon dibayarkan tagihan '.$row["idtransaksi"];
		$mail->Body = "Dear customer PT BIJE JAYA PERDANA, <br><br> Terlampir tagihan invoice yang akan jatuh tempo, 
		mohon segera melakukan pembayaran sesuai tanggal jatuh tempo. <br><br> Terima kasih. <br> Regards, <br> Admin keuangan";
		$mail->addAttachment("pdf/".$row["idtransaksi"].".pdf");
		$mail->AddAddress($email);
		$mail->Send();
	
	}

}
$con->close();
echo "<script language='javascript'>window.location.href = 'index.php';</script>";
?>