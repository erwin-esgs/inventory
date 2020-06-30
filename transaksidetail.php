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
	<center><h1>Invoice</h1><br><br></center>
    <?php
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
    ?>
    <div class="form-row">
        <div class="col-6">
        <label for="exampleInputText">Data Customer</label>
          <textarea id="nama" class="form-control-plaintext" rows="5" cols="40" readonly style="resize:none;">
          <?php
          $stmt = $con->prepare( "SELECT * FROM customer Where idcustomer = ? " );
          $stmt->bind_param("s", $idcustomer );$stmt->execute();
          $result = $stmt->get_result();
          while($row = mysqli_fetch_assoc($result)) {
              echo $row["nama"]."\n";
              echo $row["email"]."\n";
              echo $row["alamat"]."\n";
              echo $row["telepon"]."\n";
              echo $row["npwp"];
          }
          ?>
          </textarea>
        </div>

        <div class="col-3">
          <div class="col">
            <label for="exampleInputText">ID Customer</label>
            <input type="number" name="jatuhtempo" id="jatuhtempo" class="form-control-plaintext" readonly value="<?php echo $idcustomer ?>"  >
          </div>
          <div class="col">
            <label for="exampleInputText">Jatuh Tempo</label>
            <input type="number" name="jatuhtempo" id="jatuhtempo" class="form-control-plaintext" readonly value="<?php echo $jatuhtempo ?>"  >
          </div>  
        </div>
        <div class="col">
          <div class="col">
            <label for="exampleInputText">No. PO</label>
            <input type="text" name="nopo" id="nopo" class="form-control-plaintext" readonly value="<?php echo $nopo ?>"  >
          </div>
          <div class="col">
            <label for="exampleInputText">Pembayaran</label>
            <input type="text" name="nopo" id="nopo" class="form-control-plaintext" readonly value="<?php echo $pembayaran ?>"  >
          </div>  
        </div>
         
    </div>

  <div class="form-group">
    <table class="table" id="tabel">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Quantity</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col">Harga</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        for($i=0;$i<sizeof($produk[0]);$i++){
            $j=$i+1;
            echo '
            <tr>
                <td> <p class="no" id= "no1" >'. $j .'</p> </td>
                <td>
                    '.$produk[0][$i].' 
                </td>
                <td>
                    '.$produk[1][$i].' 
                </td>
                <td><input type="text" class="form-control-plaintext" id= "qty1" name="qty[]" value="'.$produk[2][$i].'" readonly ></td>
                <td><input type="text" class="form-control-plaintext" id= "hargasatuan1" name="hargasatuan[]"  value="'.$produk[3][$i].'" readonly ></td>
                <td><input type="text" class="form-control-plaintext" id= "hargatotal1" name="harga[]"  value="'.$produk[4][$i].'" readonly ></td>
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
            <p>Subtotal</p>
        </div>  
        <div class="col">
            <input type="text" class="form-control-plaintext" id="subtotal" name="subtotal" value="<?php echo $subtotal ?>" readonly>
        </div>
    </div>
    <div class="form-inline">
        <div class="col"> 
            <p>Diskon</p>
        </div>  
        <div class="col">
            <input type="number" class="form-control-plaintext" id="diskon" name="diskon" value="<?php echo $diskon ?>" readonly>
        </div>
    </div>
    <div class="form-inline">
        <div class="col"> 
            <p>Total</p>
        </div>  
        <div class="col">
            <input type="text" class="form-control-plaintext inputan" id="total" name="total" value="<?php echo $subtotal-$diskon ?>" readonly>
        </div>
    </div>

  </div>
  

    <a href="index.php"><button  type="button" class="btn btn-primary">Back</button></a>
    <a href="makepdf.php?idtransaksi=<?php echo $idtransaksi ?>"><button  type="button" class="btn btn-primary">Make PDF</button></a>
    
</div>

  </body>

</html>
<?php $con->close(); ?>
