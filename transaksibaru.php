<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <body>
	<div class="container" style="padding-left:5%; padding-right:5%;">
	<center><h1>Invoice</h1></center>
  <form action="transaksibarusave.php" method="post" onsubmit="return validasi()">
    <div class="form-row">
        <div class="col-6">
        <label for="exampleInputText">Data Customer</label>
          <textarea id="nama" class="form-control-plaintext" rows="5" cols="40" readonly style="resize:none;">
          </textarea>
        </div>
        <div class="col-3">
          <div class="col">
            <label for="exampleInputText">Nama Customer</label>
            <select class="form-control inputan" id="idcustomer" name="idcustomer">
              <option selected="" disabled="" value="">--Select Id Customer--</option>
                <?php
                require('config.php');
                $con = new mysqli($host, $dbid, $dbpass, $dbname);
                $stmt = $con->prepare( "SELECT idcustomer , nama FROM customer ORDER BY nama DESC" );
                $stmt->execute();
                $result = $stmt->get_result();
                $con->close();
                while($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="'.$row["idcustomer"].'">'.$row["nama"].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col">
            <label for="exampleInputText">Jatuh Tempo</label>
            <input type="number" name="jatuhtempo" id="jatuhtempo" class="form-control inputan"  >
          </div>  
        </div>
        <div class="col">
          <div class="col">
            <label for="exampleInputText">No. PO</label>
            <input type="text" name="nopo" id="nopo" class="form-control inputan"  >
          </div>
          <div class="col">
            <label for="exampleInputText">Pembayaran</label>
            <select class="form-control"  name="pembayaran">
              <option >Cash</option>
              <option >Kredit</option>
            </select>
          </div>  
        </div>
         
    </div>

    <button type="button" class="btn btn-outline-primary" id="tambahbarang">Add Item</button>
    <button type="button" class="btn btn-outline-primary" id="deletebarang">Del Item</button>

  <div class="form-group">
    <table class="table" id="tabel">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode & Nama Barang</th>
          <th scope="col">Quantity</th>
          <th scope="col">Harga Satuan</th>
          <th scope="col">Harga</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> <p class="no" id= "no1" >1</p> </td>
          <td>
            <select name="idproduk[]" class="form-control-plaintext inputan" style="width: 18rem;">
              <option selected="" disabled="" value="">--Select Product--</option>
                <?php
                $con = new mysqli($host, $dbid, $dbpass, $dbname);
                $stmt = $con->prepare( "SELECT idproduk , namaproduk FROM produk ORDER BY namaproduk DESC" );
                $stmt->execute();
                $result = $stmt->get_result();
                $con->close();
                while($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="'.$row["idproduk"].'">'.$row["idproduk"].' : '.$row["namaproduk"].'</option>';
                }
              ?>
            </select>
            </td>
            <td><input type="number" class="form-control qty inputan" id= "qty1" name="qty[]" value="" onkeyup="countHarga()" ></td>
            <td><input type="number" class="form-control hargasatuan inputan" id= "hargasatuan1" name="hargasatuan[]" value="" onkeyup="countHarga()" ></td>
            <td><input type="text" class="form-control hargatotal" id= "hargatotal1" name="harga[]" value="0" readonly ></td>
        </tr>
        </tbody>
    </table>
  </div>

  <div class="card justify-content-end" style="width: 18rem;">

    <div class="form-inline">
        <div class="col"> 
            <p>Subtotal</p>
        </div>
			Rp
        <div class="col">
            <input type="text" class="form-control-plaintext" id="subtotal" name="subtotal" readonly>
        </div>
    </div>
    <div class="form-inline">
        <div class="col"> 
            <p>Diskon</p>
        </div>
			Rp		
        <div class="col">
            <input type="number" class="form-control-plaintext" id="diskon" name="diskon" value="0" onkeyup="countHarga()">
        </div>
    </div>
    <div class="form-inline">
        <div class="col"> 
            <p>Total</p>
        </div>  
			Rp
        <div class="col">
            <input type="text" class="form-control-plaintext inputan" id="total" name="total" readonly>
        </div>
    </div>

  </div>
  

    <a href="index.php"><button  type="button" class="btn btn-primary">Back</button></a>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  </body>

</html>
<script>
function validasi() { 
var textinput1 = document.getElementsByClassName("inputan");
var count=0;
	for (i = 0; i < textinput1.length; i++) { 
	if(textinput1[i].value == "" || textinput1[i].value == null){
		count = count + 1;
	}
}
if(count > 0){
	alert("Fill all required field!"); 
	return false;
	}else{
	return true;
	}
}
$(document).ready(function(){
  $("#idcustomer").change(function(){
    var idcustomer = $("#idcustomer").val();
    $.ajax({
      url: 'loadcustomer.php',
      method: 'post',
      data: 'idcustomer='+idcustomer,
      success: function(results){
        var result = JSON.parse(results);
        var idcustomer = result[0][0];
        var email = result[0][2];
        var alamat = result[0][3];
        var telepon = result[0][4];
        var npwp = result[0][5];
        $("#nama").html("ID: "+idcustomer+"\nemail: "+email+"\nAlamat: "+alamat+"\nTelepon: "+telepon+"\nNpwp: "+npwp);
      }
    })
  });

  $("#tambahbarang").click(function(){
    var qtylength = $(".qty").length +1 ;
    var $last = $("#tabel tbody").find('tr:last').clone();
    $last.find('.no').attr("id","no"+qtylength).html(qtylength);
    $last.find('.qty').attr("id","qty"+qtylength);
    $last.find('.hargasatuan').attr("id","hargasatuan"+qtylength);
    $last.find('.hargatotal').attr("id","hargatotal"+qtylength);
    qtylength = qtylength-1 ;
    //alert($("#qty"+qtylength).val());
    //alert($("#hargasatuan"+qtylength).val());
    //alert($("#hargatotal"+qtylength).val());
    $last.appendTo($('table')); 
    countHarga();
    
  });

  $("#deletebarang").click(function(){
    var $last = $("#tabel tbody").find('tr:last');
    if($last.is(':first-child')){
        alert('Last is the only one');
    }else {
        $last.remove();
    }
    countHarga();
  });

});
function countHarga(){
  var qtylength = $(".qty").length ;
  var subtotal=0;
  var i;
  for (i = 1; i <= qtylength; i++) {
    var qty = parseInt($("#tabel tbody").find("#qty"+i).val());
    var hargasatuan = parseInt($("#tabel tbody").find("#hargasatuan"+i).val());
    var totalharga = qty * hargasatuan;
    subtotal = subtotal + totalharga;
    $("#tabel tbody").find("#hargatotal"+i).val(totalharga);
  }   
  $("#subtotal").val(subtotal);
  var diskon = parseInt($("#diskon").val());
  var total = subtotal - diskon;
  $("#total").val(total);
}

  </script>
