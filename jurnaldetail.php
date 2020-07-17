<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>

  <body>
	<div class="container" style="padding-left:5%; padding-right:5%;">
	<center><h1>Jurnal</h1></center>


		<?php
        require('config.php');
        if( isset($_GET["idjurnal"]) ){
            $idjurnal = $_GET["idjurnal"];
			echo'<center><h3>'.$idjurnal.'</h3><br></center>';
			
            $con = new mysqli($host, $dbid, $dbpass, $dbname);
            $stmt = $con->prepare( "SELECT * FROM jurnal Where idjurnal = ? " );
            $stmt->bind_param("s", $idjurnal ); $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                echo "<script language='javascript'>alert('ID tidak ditemukan');window.location.href = 'index.php';</script>";
            }
            while($row = mysqli_fetch_assoc($result)) {
                $idjurnal = strval($row["idjurnal"]);
                $debet = $row["debet"];
                $total = $row["total"];
                $jurnal = json_decode( $row["jurnal"] );
				$warkat = $row["warkat"];
            }
			$namawarkat = explode(" ",$warkat);
			$stmt = $con->prepare( "SELECT kodebank FROM warkat WHERE kodewarkat = ? AND nowarkat = ? " );
            $stmt->bind_param("ss", $namawarkat[0], $namawarkat[1]  ); $stmt->execute();
            $result = $stmt->get_result();
			while($row = mysqli_fetch_assoc($result)) {
				$kodebank = $row["kodebank"];
			}
			$namabank=' - ';
			$stmt = $con->prepare( "SELECT namabank FROM bank WHERE kodebank = ? " );
            $stmt->bind_param("s", $kodebank  ); $stmt->execute();
            $result = $stmt->get_result();
			while($row = mysqli_fetch_assoc($result)) {
				$namabank = $row["namabank"];
			}
			
        }else{
            echo "<script language='javascript'>alert('ID tidak ditemukan');window.location.href = 'index.php';</script>";
        }
		echo "<center><h4>Kode Warkat: ".$warkat."  Bank: ".$namabank."</h4></center>";
?>		
	<div class="form-group">
    <table class="table" id="tabel">
		<thead>
			<tr>
				<th scope="col">No</th>
				<th scope="col">ID Jurnal</th>
				<th scope="col">Debet</th>
				<th scope="col">Kredit</th>
				<th scope="col">Keterangan</th>
			</tr>
		</thead>
		<tbody>
<?php		
        for($i=0;$i<sizeof($jurnal[0]);$i++){
            $j=$i+1;
			if($debet == 1){
			$dk = ' <td></td><td>
					'.$jurnal[1][$i].' 
					</td>';
			}else{
			$dk = ' <td>
					'.$jurnal[1][$i].' 
					</td><td></td>';
			}
            echo '
            <tr>
                <td> <p class="no" >'. $j .'</p> </td>
                <td>
                    '.$jurnal[0][$i].' 
                </td>
					'.$dk.'
                <td><input type="text" class="form-control-plaintext" name="qty[]" value="'.$jurnal[2][$i].'" readonly ></td>
            </tr>
            ';
        }
        
        ?>
        </tbody>
    </table>
  </div>

  <div class="card justify-content-end" style="width: 18rem;">

    <div class="form-inline">
        <div class="col"> 
            <p>Total</p>
        </div>  
        <div class="col">
            <input type="text" class="form-control-plaintext" id="total" name="total" value="<?php echo $total ?>" readonly>
        </div>
    </div>

  </div>

    <a href="jurnal.php"><button  type="button" class="btn btn-primary">Back</button></a>
	<a href="jurnalmakepdf.php?idjurnal=<?php echo $idjurnal ?>"><button  type="button" class="btn btn-primary">Make PDF</button></a>
    
</div>

  </body>

</html>
<?php $con->close(); ?>
