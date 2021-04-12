<?php
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
	
	//Algumas funcoes importantes.
    //Cria o hash da senha.
    function make_hash($str){
        return md5($str);
    }
	
	function inverteData($data){
		if(count(explode("/",$data)) > 1){
			return implode("-",array_reverse(explode("/",$data)));
		}elseif(count(explode("-",$data)) > 1){
			return implode("/",array_reverse(explode("-",$data)));
		}
	}
?>