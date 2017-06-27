<?php
require_once 'Database.class.php';

header("Content-Type: text/html; charset=utf-8");
$id = $_GET['id'];
try{
	$info = Database::conn()->prepare("SELECT * FROM cidade WHERE cod_ibge='".$id."'");
	$info->execute();
	if($info->rowCount() > 0){
		while($array = $info->fetchObject()){
			echo "<div id='info_cidades'>";
				echo "<h2>".utf8_encode($array->nome)." : ".$array->cod_ibge."</h2>";
				echo "<h3>População: </h3>";
				echo "<p>".number_format($array->populacao,0,',','.')."</p>";
				echo "<h3>Gentílico: </h3>";
				echo "<p>".utf8_encode($array->gentilico)."</p>";
				echo "<h3>Área Territorial: </h3>";
				echo "<p>".number_format($array->area_territorial,2,',','.')."</p>";
				echo "<h3>Densidade demográfica: </h3>";
				echo "<p>".number_format($array->densidade_demografica,2,',','.')."</p>";
				echo "<h3>PIB: </h3>";
				echo "<p>".number_format($array->pib,2,',','.')."</p>";
				echo "<footer>Fonte: IBGE</footer>";
			echo "</div>";
		}
		
		$info_crs = Database::conn()->prepare("SELECT crs.nome_hospital as nome_hospital,crs.cod_ibge as cod_ibge,crs.leitos_sus as leitos_sus,cidade.nome as nome FROM crs,cidade WHERE cidade.cod_ibge = crs.cod_ibge AND crs.cod_ibge='".$id."'");
		$info_crs->execute();
		$rows = $info_crs->rowCount();
		echo  "<table summary='Informações'>
			<caption>Informações</caption>
				<thead>
					<tr>
						<th scope='col'>U.H.</th>
						<th scope='col'>Leitos</th>
						<th scope='col'>Detalhes</th>
					</tr>
				</thead>";
		$total_leitos = 0;
		while($arrayNomesHospitais = $info_crs->fetchObject()){
		echo "
			<tr>
				<td>".utf8_encode($arrayNomesHospitais->nome_hospital)."</td>
				<td>".$arrayNomesHospitais->leitos_sus."</td>
				<td></td>
			</tr>";
			
		$total_leitos += $arrayNomesHospitais->leitos_sus;
		}
		echo "<tfoot>
			<tr>
				<th scope='row'>Total</th>
				<td colspan='2'>".$total_leitos."</td>
			</tr>
		</tfoot><tbody>";
		echo "	</tbody></table>";
		
	}else{
		echo "Não foi encontrado nenhuma informação da cidade."	;
	}


}catch(PDOException $e){
	echo $e->message;	
}
?>



