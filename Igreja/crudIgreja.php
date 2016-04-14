<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
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

	public abstract function salvar($igreja, $dirigente, $conjugue, $endereco, $cep, $regiao, $cidade, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $informacao);
	public abstract function alterar($id_igreja, $igreja, $dirigente, $conjugue, $endereco, $cep, $regiao, $cidade, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform);
	public abstract function excluir($id_igreja);
	
}

class ManterIgreja extends CrudIgreja {

	
	public function salvar($igreja, $dirigente, $conjugue, $endereco, $cep, $regiao, $cidade, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform) {
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sql = "select *
		from igreja
		where igreja.nm_igreja ='{$igreja}'";
		$stm = $pdo->query($sql);
		
 		//var_dump($sql);
		
		if ($stm->rowCount() >= 1){
			return false;
			//var_export("if crudIgreja");
		}
		else {
			$sqlGravar = "INSERT INTO igreja(
					NM_IGREJA, 
					NM_DIRIGENTE, 
					NM_CONJUGUE, 
					DS_ENDERECO, 
					CD_CEP,
					ID_REGIAO,
					NM_CIDADE,
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
					'".$regiao."',
					'".$cidade."',		
					'".$telefone."',
					'".$inauguracao."', 
					'".$banco."',
					'".$agencia."', 
					'".$conta."',
					'".$inform."')";
			
			$stmg = $pdo->query($sqlGravar);
			//var_dump($sqlGravar);
			if ($stmg->rowCount()<1) {
				return false;
			}else{
				return true;
			}
			
		}
		
	}
	
	public function alterar($id_igreja, $igreja, $dirigente, $conjugue, $endereco, $cep, $regiao, $cidade, $telefone, 
							$inauguracao, $banco, $agencia, $conta, $inform) {
				
				
				
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select igj.*
				from igreja igj 				
				where igj.id_igreja = '{$id_igreja}'";
				$stm = $pdo->query($sql);
								
				if (!$stm->rowCount() == 1){
					return false;
				}
				else {
					
					$sqlGravar = "UPDATE igreja SET
					NM_DIRIGENTE = '".$dirigente."',
					NM_CONJUGUE = '".$conjugue."',
					DS_ENDERECO = '".$endereco."',
					CD_CEP = '".$cep."',
					ID_REGIAO = '".$regiao."',
					NM_CIDADE = '".$cidade."',
					NR_TELEFONE = '".$telefone."',
					DT_INAUGURACAO = '".$inauguracao."',
					NM_BANCO = '".$banco."',
					NR_AGENCIA = '".$agencia."',
					NR_CONTA = '".$conta."',
					DS_INFOMACOES = '".$inform."'
					where ID_IGREJA = ".$id_igreja.";";
					
					$stmg = $pdo->query($sqlGravar);
					//Verifica se o SQL foi executado com sucesso. 
					if ($stmg->rowCount()<1) {
						//Caso ocorra erro no SQL
						return false;
					}else{
						//Caso SQL executado com sucesso
						return true;
					}

				}	
				 	
	}
	
	public function excluir($id_igreja) {
				//var_export("chamou a função");
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "delete 
				from igreja
				where igreja.id_igreja ='{$id_igreja}'";
				$stm = $pdo->query($sql);
				//var_export("Chamou o SQL");
				
					return true;
				
	}
}
?>
