<?php ini_set('session.gc_maxlifetime', 300); session_set_cookie_params(300); session_start(); 
if(!isset($_SESSION["username"]) || $_SESSION["username"] == ""){
		//header("location:login.html");
		echo "<script language='javascript'>alert('Silahkan login terlebih dulu'); window.location.href = 'login.html';</script>";
	}
?>
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
var textinput1 = document.getElementsByClassName("form-control");
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
function showpass() {
  var x = document.getElementById("exampleInputPassword1");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
  </script>
  <body>
	<div class="container" style="padding:5%;">
	<center><h1>Ubah Password</h1></center>
<form action="profileedit1.php" method="post" onsubmit="return validasi()">
  <div class="form-group">
    <label for="exampleInputPassword1">Password Lama</label>
    <input type="password" name="oldpassword" class="form-control" id="exampleInputPassword1">
	<input type="checkbox" onclick="showpass()">Show Password
  </div>

  <div class="form-group">
	<label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
	<input type="checkbox" onclick="showpass()">Show Password
  </div>
    <a href="index.php"><button  type="button" class="btn btn-primary">Back</button></a>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
	</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>