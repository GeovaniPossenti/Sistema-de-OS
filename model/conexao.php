<?php
	//Aqui fica a classe padrão pra conectar no banco, aonde eu crio uma function public pra usar toda vez que eu precisar.
	class Conexao{
		public function conectar(){
			$user ="root";
			$senha ="";
			$banco ="lojamatrix";
			$local ="127.0.0.1";
			$conn = new PDO("mysql:host=$local;dbname=$banco;charset=utf8","$user","$senha");
			return $conn;
		}
	}
	/*$con = new Conexao;
	if($con->conectar() == true){
		print "Ok";
	}else{
		print "Conexão com o banco não estabelecida corretamente";
	}
	*/
	
	//Aqui eu gosto de colocar algumas funçoes importantes que eu uso no sistema em geral. 

    //Aqui é uma função que eu crio o hash md5 da variavel que eu passar pela function.
    function make_hash($str){
        return md5($str);
    }
	
	//Apenas uma função pra inverter a data que vem do banco no padrão yyyy/mm/dd - dd/mm/yyyy.
	function inverteData($data){
		if(count(explode("/",$data)) > 1){
			return implode("-",array_reverse(explode("/",$data)));
		}elseif(count(explode("-",$data)) > 1){
			return implode("/",array_reverse(explode("-",$data)));
		}
	}
?>