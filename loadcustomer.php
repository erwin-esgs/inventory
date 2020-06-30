<?php
require('config.php');
$con = new mysqli($host, $dbid, $dbpass, $dbname);
if (isset($_POST['idcustomer'])){
    $stmt = $con->prepare( "SELECT * FROM customer WHERE idcustomer = ".$_POST['idcustomer']." ORDER BY nama DESC" ); 
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_all();
    $con->close();
    echo json_encode($result) ;
}else{
    echo 'Tidak ada ID yang dipilih';
}
    
?>