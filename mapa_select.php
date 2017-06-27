<?php
require_once("Database.class.php");
	@$id = $_GET['id'];
	if($id == NULL || $id == "all"){
		$sql = "SELECT c.cod_ibge AS cod_ibge, c.nome AS nome, m.cod_svg AS cod_svg 
                FROM estado e, cidade c, mapa_svg m 
                WHERE c.estado = e.id
                AND c.cod_ibge = m.cod_ibge
                AND e.uf = 'PA'
				";
	}else if($id >= 1 or $id <=13){
		$sql = "SELECT c.cod_ibge AS cod_ibge, c.nome AS nome, m.cod_svg AS cod_svg 
				FROM estado e, cidade c, mapa_svg m, crs
				WHERE c.estado = e.id
				AND c.cod_ibge = m.cod_ibge
				AND crs.cod_ibge = m.cod_ibge
				AND e.uf = 'PA'
				AND crs.crs = ".$id."
				";
	}	
	$paths = Database::conn()->prepare($sql);	
	$paths->execute();
?>
<script type="text/javascript">
// CARREGADO SCALE E TRANSLATE PARA CARREGAR O MAPA ISOLADO COM ZOOM
var transform = [];
	$.getJSON("json/crs.json",function(data){
		$.each(data,function(index,dados){
			transform[dados.Id] = {"Scale":""+dados.Scale+"","Translate":""+dados.Translate+""};
			
		});
			// A ESCRITA DO 100 é uma gambiarra pra colocar o mapa depois que acontece o click no TODOS do menu
			$("#zoom").attr("transform",transform[<?php if($id == NULL || $id == "all"){echo 100;}else {echo $id;} ?>].Scale);
			$("#translate").attr("transform",transform[<?php if($id == NULL || $id == "all"){echo 100;}else {echo $id;} ?>].Translate);
	});

</script>
<svg xmlns="http://www.w3.org/2000/svg" width="720" height="697.284412246" version="1.1">
	<g class="mapa"><g id="zoom" class="mod" transform="scale(0.045,-0.045)">
		<g class="mod" id="translate" transform="translate(58898,-2591)">
        <?php
        while($array = $paths->fetchObject()){
            echo "<g><path class=\"mapa\" id=\"".$array->cod_ibge."\" name=\"".utf8_encode(	$array->nome)."\" d=\"".$array->cod_svg."\"></path></g>";
        }
        ?>
		</g>
	</g>
</svg>