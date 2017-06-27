$(document).ready(function(e) {

    $(".zoom_mais").on("click",function(){
		distancia("mais");
	});
	$(".zoom_menos").on("click",function(){
		distancia("menos");
	});
	$(".nav_left").on("click",function(){
		distancia("nav_left");
	});
	$(".nav_right").on("click",function(){
		distancia("nav_right");
	});
	$(".nav_top").on("click",function(){
		distancia("nav_top");
	});
	$(".nav_bot").on("click",function(){
		distancia("nav_bot");
	});
	
	var valor_navegacao = 200;
	
	//FUNCAO QUE SETA OS VALORES NO MAPA DEFININDO A DISTANCIA OU APROXIMACAO DO MAPA
	function distancia(action){
		//SCALE
		var arrayFunctionScale = separarValoresScale();
		var value_left_zoom = arrayFunctionScale[0];
		var value_right_zoom = arrayFunctionScale[1];
		//TRANSLATE
		var arrayFunctionTranslate = separarValorTranslate();
		var value_left_zoom_trans = arrayFunctionTranslate[0];
		var value_right_zoom_trans = arrayFunctionTranslate[1];
		
		//SETANDO VALORES
		if(action == "mais"){
			value_left_zoom_trans -= 80;
			value_right_zoom_trans += 100;
			value_left_zoom += 0.002;
			value_right_zoom += 0.002;
		}else if(action == "menos"){
			value_left_zoom_trans += 80;
			value_right_zoom_trans -= 100;
			value_left_zoom -= 0.002;
			value_right_zoom -= 0.002;
		}else if(action == "nav_left"){
			value_left_zoom_trans -= valor_navegacao;
		}else if(action == "nav_right"){
			value_left_zoom_trans += valor_navegacao;
		}else if(action == "nav_top"){
			value_right_zoom_trans -= valor_navegacao;
		}else if(action == "nav_bot"){
			value_right_zoom_trans += valor_navegacao;
		}
		
		$("#zoom").attr("transform","scale("+value_left_zoom+",-"+value_right_zoom+")");
		$("#translate").attr("transform","translate("+value_left_zoom_trans+",-"+value_right_zoom_trans+")");	
	}
function separarValoresScale(){
		var nzoom = $("#zoom").attr("transform");
		var nzoom_arr;
		var nzoom_arr_final;
		nzoom_arr = nzoom.split("(");
		nzoom_arr = nzoom_arr[1].split(",");
		nzoom_arr_final = nzoom_arr;
		nzoom_arr = nzoom_arr[1].split(")");
		nzoom_arr_final.push(nzoom_arr[0]);
		nzoom_arr_final.splice(1,1);
		nzoom_arr_final[0] = parseFloat(nzoom_arr_final[0]);
		nzoom_arr_final[1] = parseFloat(nzoom_arr_final[1]*(-1));
		return nzoom_arr_final;
	}
	function separarValorTranslate(){
		var nzoom = $("#translate").attr("transform");
		var nzoom_arr;
		var nzoom_arr_final;
		nzoom_arr = nzoom.split("(");
		nzoom_arr = nzoom_arr[1].split(",");
		nzoom_arr_final = nzoom_arr;
		nzoom_arr = nzoom_arr[1].split(")");
		nzoom_arr_final.push(nzoom_arr[0]);
		nzoom_arr_final.splice(1,1);
		nzoom_arr_final[0] = parseFloat(nzoom_arr_final[0]);
		nzoom_arr_final[1] = parseFloat(nzoom_arr_final[1]*(-1));
		return nzoom_arr_final;
	}
});