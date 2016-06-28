<?php 

 try {
include "./config/config.php";
include './RelayLib.php';
 
	$lib = new RelayLib(IP, PORT, USER, PASSWORD);
 
 	
if (isset($_GET['relay'])) {
    $relay = $_GET['relay'];
	try{
	 echo $lib->toggle($relay);
	}catch (Exception $exc){
    echo json_encode(array(
        'error' => array(
            'code' => $exc->getCode(),
            'message' => $exc->getMessage()
        )
    ));
	}
}else{
    
	$allData = $lib->GetData();
	
    echo'{"data":'.json_encode($allData).'}'; 
}
	 

}catch (Exception $exc) {

	echo $exc->getMessage().'<br/>';
	echo $exc->getTraceAsString();
	die();

}


?>
