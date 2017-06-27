<?php 
require_once("Database.class.php");
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html xml:lang="pt-br" lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Mapa Regional - Pará</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/imagesloaded.pkg.min.js"></script>
<script type="text/javascript" src="shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="js/jquery.qtip.js"></script>
<script type="text/javascript" src="js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/zoom_maps.js"></script>
<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="js/jquery.qtip.css" />
<link rel="stylesheet" type="text/css" href="shadowbox/shadowbox.css" />
</head>
<div id="geral">
	<div id="logos">
    	<div class="eco">
        	<a href="http://www.ecosistemas.com.br/"><img src="images/eco.png" alt="ECO Sistemas"/></a>
        </div>
        <div class="gov_para">
        	<a href="http://www.pa.gov.br/"><img src="images/para.png" alt="Governo do Pará"/></a>
        </div>
        <div class="siah">
        	<a href="http://siah.com.br/"><img src="images/siah.png" alt="SIAH" /></a>
        </div>
    </div>
	<div id="left_container">
    </div>
    <div id="center">
        <div id="control_map">
            <a class="zoom_mais" href="#"></a>
            <a class="zoom_menos" href="#"></a>
            <a class="nav_left" href="#"></a>
            <a class="nav_right" href="#"></a>
            <a class="nav_top" href="#"></a>
            <a class="nav_bot" href="#"></a>
        </div>
	<div id="mapa">
		<?php require 'mapa_select.php'; ?>
    </div>
    <!-- FIM DIV MAPA -->    
    </div>
    <div id="right_container">
       <ul>
            <?php
				try{
					$select_data_crs = Database::conn()->prepare("SELECT crs.crs as crs, reg_s.nome as nome FROM crs, regioes_saude as reg_s WHERE reg_s.crs = crs.crs GROUP BY crs.crs");
					$select_data_crs->execute();
					echo "<li><a href=\"\">TODOS</a></li>";
					if($select_data_crs->rowCount() > 0){
					while($obj = $select_data_crs->fetchObject()){
						$select_crs_cidades = Database::conn()->prepare(" SELECT nome,crs 
																FROM crs,cidade 
																WHERE crs.cod_ibge = cidade.cod_ibge 
																AND crs = :crs 
																GROUP BY nome");
						$select_crs_cidades->bindValue(':crs',$obj->crs);
						$select_crs_cidades->execute();
						echo "<li class=\"mapa_select\"><a href='".$obj->crs."'><div class=\"marcador\" id='".$obj->crs."'></div>".utf8_encode($obj->nome)."</a>
								<ul>";
						while($obj_cidade = $select_crs_cidades->fetchObject()){
							echo "<li class=\"mapa_select\"><a href='".$obj->crs."'>".utf8_encode($obj_cidade->nome)."</a></li>";	
						}
						echo "	</ul>
							</li>";
					}
					}else{
						echo "CRS não encontrada";
					}	
				}catch(PDOException $e){
					echo $e->getMessage();
				};
			?>
            </ul>
    </div>
    <!-- FIM LISTAGEM DAS CIDADES -->
    <div class="clearboth">
    </div>
    <div id="footer">
    </div>
</div>
</body>
</html>