<?php
	//Aqui fica a classe padrão pra conectar no banco, aonde eu crio uma function public pra usar toda vez que eu precisar.
	class Conexao{
		public function conectar(){
			try{
				$user ="root";
				$senha ="";
				$banco ="lojamatrix";
				$local ="127.0.0.1";
				$conn = new PDO("mysql:host=$local;dbname=$banco;charset=utf8","$user","$senha");
				return $conn;
			} catch (Exception $e) {
				echo "Falha na tentativa de conectar ao banco! " . $e->getMessage();
			}
		}
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