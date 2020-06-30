<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

  </head>
  <script>
function validasi() { 
var textinput1 = document.getElementsByClassName("inputan");
var count=0;
	for (i = 0; i < textinput1.length; i++) { 
	if(textinput1[i].value == ""){
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
  </script>
<?php
require('config.php');
$idcustomer = $_GET["idcustomer"];
$con = new mysqli($host, $dbid, $dbpass, $dbname);
$stmt = $con->prepare( "SELECT * FROM customer WHERE  idcustomer = ? ");
$stmt->bind_param("s", $idcustomer); $stmt->execute();
$result = $stmt->get_result();
while($row = mysqli_fetch_assoc($result)) {
?>
  <body>
	<div class="container" style="padding:5%;">
	<center><h1>Edit Customer</h1></center>
<form action="customerubahsave.php" method="post" onsubmit="return validasi()">
  <div class="form-group">
    <label for="exampleInputText">ID Customer</label>
    <input type="text" name="idcustomer" class="form-control inputan" id="exampleInputText" readonly value="<?php echo $row["idcustomer"]; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputText">Nama</label>
    <input type="text" name="nama" class="form-control inputan" id="exampleInputText" value="<?php echo $row["nama"]; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputText">Email</label>
    <input type="text" name="email" class="form-control inputan" id="exampleInputText" value="<?php echo $row["email"]; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputText">Alamat</label>
    <input type="text" name="alamat" class="form-control inputan" id="exampleInputText" value="<?php echo $row["alamat"]; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputText">Telepon</label>
    <input type="number" name="telepon" class="form-control inputan" id="exampleInputText" value="<?php echo $row["telepon"]; ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputText">NPWP</label>
    <input type="text" name="npwp" class="form-control" id="exampleInputText" value="<?php echo $row["npwp"]; ?>">
  </div>
    <a href="customer.php"><button  type="button" class="btn btn-primary">Back</button></a>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
<?php } ?>
</html>
