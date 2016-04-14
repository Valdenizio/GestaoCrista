		<?php
abstract class CrudIgreja {

	private static $instancia = null;

	private function __construct() {}

	/**
	 *
	 * @return Autenticador
	 */
	public static function instanciar() {

		if (self::$instancia == NULL) {
			self::$instancia = new ManterIgreja();
		}

		return self::$instancia;

	}

	public abstract function salvar($igreja, $dirigente, $conjugue, $endereco, $cep, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $informacao);
	public abstract function alterar($id_igreja, $igreja, $dirigente, $conjugue, $endereco, $cep, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform);
	public abstract function excluir($id_igreja);
	
}

class ManterUsuario extends CrudUsuario {

	
	public function salvar($igreja, $dirigente, $conjugue, $endereco, $cep, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform) {
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=utf8','root','');
		$sql = "select *
		from igreja
		where igreja.nm_igreja ='{$igreja}' and
		igreja.nm_dirigente = '{$dirigente}'";
		$stm = $pdo->query($sql);
		
// 		var_dump($stm);
		
		if ($stm->rowCount() >= 1){
			return false;
		}
		else {
			$sqlGravar = "INSERT INTO igreja(
					NM_IGREJA, 
					NM_DIRIGENTE, 
					NM_CONJUGUE, 
					DS_ENDERECO, 
					CD_CEP, 
					NR_TELEFONE, 
					DT_INAUGURACAO, 
					NM_BANCO, 
					NR_AGENCIA, 
					NR_CONTA, 
					DS_INFOMACOES) 
					VALUES(
					'".$igreja."', 
					'".$dirigente."',
					'".$conjugue."',
					'".$endereco."',
					'".$cep."',
					'".$telefone."',
					'".$inauguracao."', 
					'".$banco."',
					'".$agencia."', 
					'".$conta."',
					'".$inform."')";
			
			$stmg = $pdo->query($sqlGravar);
		//var_dump($sqlGravar);
			return true;
		}
		
	}
	
	public function alterar($id_igreja, $igreja, $dirigente, $conjugue, $endereco, $cep, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform) {
				
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select *
				from igreja
				where igreja.id_igreja like '%{$id_igreja}%'";
				$stm = $pdo->query($sql);
				//var_dump($stm);
								
				if (!$stm->rowCount() == 1){
					return false;
				}
				else {
					
					$sqlGravar = "UPDATE igreja SET
					NM_DIRIGENTE = '".$dirigente."',
					NM_CONJUGUE = '".$conjugue."',
					DS_ENDERECO = '".$endereco."',
					CD_CEP = '".$cep."',
					NR_TELEFONE = '".$telefone."',
					DT_INAUGURACAO = '".$inauguracao."',
					NM_BANCO = '".$banco."',
					NR_AGENCIA = '".$agencia."',
					NR_CONTA = '".$conta."',
					DS_INFOMACOES = '".$inform."'
					where ID_IGREJA = ".$id_igreja.";";
					
					$stmg = $pdo->query($sqlGravar);
					//var_dump($sqlGravar);
					
					return true;

				}	
				 	
	}
	
	public function excluir($id_igreja) {
				//var_export("chamou a função");
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=utf8','root','');
				$sql = "delete 
				from igreja
				where igreja.id_igreja ='{$id_igreja}'";
				$stm = $pdo->query($sql);
				//var_export("Chamou o SQL");
				return true;
				
	}
}
?>
