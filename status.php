<?php 

include "./config/config.php";
include './RelayLib.php';

try {


	$lib = new RelayLib(IP, PORT, USER, PASSWORD);
	$status = $lib->status();
	$name   = $lib->name();
	$complete = array_combine($name, $status);
        echo'{"Status":'.json_encode($complete).'}'; 
     
}catch (Exception $exc) {

	echo $exc->getMessage().'<br/>';
	echo $exc->getTraceAsString();
	die();

}


?>
     
