<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
abstract class CrudMovimento {

	private static $instancia = null;

	private function __construct() {}

	/**
	 *
	 * @return Autenticador
	 */
	public static function instanciar() {

		if (self::$instancia == NULL) {
			self::$instancia = new ManterMovimento();
		}

		return self::$instancia;

	}

	public abstract function salvar($dta,$dti, 
						$tpm,$vlr,$igj);
	public abstract function alterar($dta,$dti, 
						$tpm,$vlr);
	
}

class ManterMovimento extends CrudMovimento {

	
	public function salvar($dta,$dti, 
						$tpm,$vlr,$igj) {
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		/* $sql = "select *
		from membro
		where membro.nm_membro = '{$membro}' and
		membro.dt_nascimento = '{$dtnascimento}'";
		$stm = $pdo->query($sql); */
		
// 		var_dump($stm);
		
		/* if ($stm->rowCount() >= 1){
			return false;
		}
		else { */
							
			$sqlGravar = "INSERT INTO movimento(dt_movimento, dt_reg_movimento, vl_movimento, id_tipo_movimento, id_igreja) 
					VALUES(
					'".$dti."', 
					'".$dta."',
					'".$vlr."',
					'".$tpm."',
					'".$igj."')";
			
			$stmg = $pdo->query($sqlGravar);
			
			return true;
		//}
		
	}
	
	public function alterar($dta,$dti, 
						$tpm,$vlr) {
				
				/* $pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select *
				from membro
				where membro.id_membro like '%{$id_membro}%'";
				$stm = $pdo->query($sql);
				//var_dump($stm);
								
				if (!$stm->rowCount() >= 1){
					return false;
				}
				else { */
					
					$sqlGravar = "UPDATE movimento SET
					dt_movimento='".$dti."',
					dt_reg_movimento='".$dta."',
					vl_movimento='".$vlr."',
					id_tipo_movimento='".$tpm."'
					where id_movimento = ".$id_movimento.";";
					
					$stmg = $pdo->query($sqlGravar);
					//var_dump($sqlGravar);
					
					return true;

				//}	
				 	
	}
	
	
}
?>
