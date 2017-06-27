$(document).ready(function(){
//inicializacao do shadowbox
Shadowbox.init({
    skipSetup: true,
    players: ["html"],
	overlayColor: "#000", 
	overlayOpacity: "0.7"
});
//tip utilizando a biblioteca qtip
qtip();
function qtip(){
$("path").each(function() {
    $(this).qtip({
			content: {
				text: $(this).attr('name')
			},
			position: {
				my: 'top left',
				at: 'center',
				target: 'mouse',
				adjust: { x: 5, y: 5 }
			},
			show: {
            effect: function() {
                $(this).fadeTo(100, 1);
            	}
			},
			hide: {
				effect: function() {
					$(this).slideUp();
				}
			}
		});
	});
}
$(document).on("click","path",function(){
	var selecao = $(this).attr("id");
	var container = $("#left_container");
	carregando(container);
	$.ajax({
		url: "processador.php",
		type: "GET",
		data: "id="+selecao
		}).done(function(data){
			container.html(data);
	});
});
function carregando(div){
	var resultado = div.html("<img src='images/ajax-loader.gif' />");
	return resultado;
}

// CLASS .MARCADOR estilos, colocaração automatica -> MARCAVAO DE ICONES NA CRS
var colorIdObj = [];
$.getJSON("json/crs.json",function(data){// LEITURA DE ARQUIVO EM FORMATO JSON CONTENDO AS CORES DE ACORDO COM AS CRS
		$.each(data,function(index,dados){
			colorIdObj[index]={"id":""+dados.Id+"","color":""+dados.Color+""};	
		});
		$(".marcador").
			each(function(index){				
				if($(this).attr("id") == colorIdObj[index].id){
					var color = colorIdObj[index].color;
					$(this).css("background-color",color);
					$(this).css("border-radius","10px 10px 10px");	
				};
			});	
});
colorirMapa();
function colorirMapa(){
//MARCACAO DE CORES DO MAPA E MENU
	var id_crs =  "all";
	var action = 1;	//PARAMETRO PARA ESCOLHER A ACAO NO FUNCTIONS PHP
	$.post('functions.php',
			"action="+action+"&id_crs="+id_crs,// ATIVA A FUNCAO PARA LOCALIZAR O ARRAY COM O COD_IBGE NA TABELA DESSA CRS SELECIONADA, E ENTAO RETORNA O VALOR EM JSON E FAZ O PROCESSO DE MARCACAO
			function(callback){
				var color_arr = [];
				var cod_ibge_arr = [];
				$.getJSON("json/crs.json",function(data){// LEITURA DE ARQUIVO EM FORMATO JSON CONTENDO AS CORES DE ACORDO COM AS CRS
					$.each(data,function(index,dados){
						color_arr[dados.Id] = dados.Color; // a index do array e a id da CRS e o valor é a cor 					
						$.each(callback,function(index,value){
						if(value.crs == dados.Id){
							$('path[id='+value.cod_ibge+']').each(function(){
									var effect = $(this).css("fill",dados.Color);
									effect.css("opacity",0.1);
									effect.fadeTo(3000,1);
							});
						}
					});
					//BUSCANDO DADOS DO AJAX	
					});
			});		
			},"json");
}
//MENU DROPDOWN E ISOLANDO MAPAS
$('.mapa_select')
	.css({cursor: "pointer"})
	.on('click', function(e){
	  $(this).find('ul').toggle();
	  var id = $('a',this).attr('href');
	$.ajax({
		url: "mapa_select.php",
		type: "GET",
		data: "id="+id	
		}).done(function(data){
			$("#mapa").html(data);
			colorirMapa();
			qtip();
	});	
	  e.preventDefault();
});

//funcao para abrir o shadowbox
function show_box(html){
	Shadowbox.open({ 
	content: html, 
	player: "html", 
	height: 600, 
	width: 800
	});
}
});