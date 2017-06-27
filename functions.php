<?php
require_once 'Database.class.php';
@$action = $_POST['action'];

switch($action){
	case 1 : marcarMapaCRS($_POST['id_crs']);break;	
}
function marcarMapaCRS($id_crs){
	if($id_crs== "all"){
		$select = Database::conn()->prepare("SELECT cod_ibge,crs FROM crs GROUP BY cod_ibge");
		$select->execute();	
		$array = $select->fetchAll();
		echo json_encode($array);	
	}else{
		$select = Database::conn()->prepare("SELECT cod_ibge,crs FROM crs WHERE crs = ".$id_crs." GROUP BY cod_ibge");
		$select->execute();	
		$array = $select->fetchAll();
		echo json_encode($array);	
	}
	
}
?>