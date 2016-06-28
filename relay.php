<?php 

 try {
    include './RelayLibV.php';
	$lib = new RelayLibV('192.168.1.1', '80', 'user', 'passw0rd');
 	
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
