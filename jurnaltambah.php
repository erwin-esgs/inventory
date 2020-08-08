<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
<!doctype html>
<html lang="en">
<?php require('config.php');?>
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
	<center><h1>Jurnal</h1></center>
  <form action="jurnalsimpan.php" method="post" onsubmit="return validasi()">
  
	<select name="warkat" class="form-control-plaintext inputan" style="width: 18rem;">
	<?php
        $con = new mysqli($host, $dbid, $dbpass, $dbname);
		$stmt = $con->prepare( "SELECT kodewarkat, nowarkat FROM warkat WHERE aktif = 1" );
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = mysqli_fetch_assoc($result)) {
            echo '<center> <option value="'.$row["kodewarkat"].' '.$row["nowarkat"].'">'.$row["kodewarkat"].' '.$row["nowarkat"].'</option> </center>';
        }
	?>
	</select>
    <button type="button" class="btn btn-outline-primary" id="tambahbarang">Add Item</button>
    <button type="button" class="btn btn-outline-primary" id="deletebarang">Del Item</button>

  <div class="form-group">
    <table class="table" id="tabel">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kode & Nama Barang</th>
          <th scope="col">Nominal</th>
          <th scope="col">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> <p class="no" id= "no1" >1</p> </td>
          <td>
            <select name="kodeakun[]" class="form-control-plaintext inputan" style="width: 18rem;">
              <option selected="" disabled="" value="">--Kode Akun--</option>
                <?php
                $stmt = $con->prepare( "SELECT * FROM akun " );
                $stmt->execute();
                $result = $stmt->get_result();
                $con->close();
                while($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="'.$row["kodeakun"].'">'.$row["kodeakun"].' : '.$row["namaakun"].'</option>';
                }
              ?>
            </select>
            </td>
            <td><input type="number" class="form-control nominal" min="1" id= "nominal1" name="nominal[]" value="" onkeyup="countHarga()" ></td>
            <td><input type="text" class="form-control keterangan" id= "keterangan" name="keterangan[]" ></td>
        </tr>
        </tbody>
    </table>
  </div>

  <div class="card justify-content-end" style="width: 18rem;">

    <div class="form-inline">
        <div class="col"> 
            <p>Total</p>
        </div>  
        <div class="col">
            <input type="text" class="form-control-plaintext" id="total" name="total" readonly>
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
var numberinput1 = document.getElementsByClassName("nominal");
var count=0;
for (i = 0; i < textinput1.length; i++) { 
	if(textinput1[i].value == "" || textinput1[i].value == null){
		count = count + 1;
	}
	
}
for (i = 0; i < numberinput1.length; i++) { 
	if(parseInt(numberinput1[i].value) < 1  ){
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

  $("#tambahbarang").click(function(){
    var arrlength = $(".nominal").length +1 ;
    var $last = $("#tabel tbody").find('tr:last').clone();
	
    $last.find('.no').attr("id","no"+arrlength).html(arrlength);
    $last.find('.nominal').attr("id","nominal"+arrlength);
	$last.find('.keterangan').attr("id","keterangan"+arrlength);
    arrlength = arrlength-1 ;
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
  var arrlength = $(".nominal").length ;
  var total=0;
  var i;
  for (i = 1; i <= arrlength; i++) {
    var nominal = parseInt($("#tabel tbody").find("#nominal"+i).val());
    total = total + nominal;
  }   
  $("#total").val(total);
}

  </script>
