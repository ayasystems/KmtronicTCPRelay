<?php 
include './config/config.php';
include './RelayLib.php';

$lib = new RelayLib(IP, HOST, USER, PASSWORD); 
 try {
 
 $lib->toggle(1);//Toggle relay 1
 $lib->toggle(8);//Toggle relay 8
 
 
}catch (Exception $exc) {

	echo $exc->getMessage().'<br/>';
	echo $exc->getTraceAsString();
	die();

}


?> 
