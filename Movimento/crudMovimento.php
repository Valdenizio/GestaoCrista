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
						$tpm,$vlr,$id_movimento,$igreja);
	
}

class ManterMovimento extends CrudMovimento {

	
	public function salvar($dta,$dti, 
						$tpm,$vlr,$igj) {
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		
		//$datamov = str_replace("/","",$dti);
							
			$sqlGravar = "INSERT INTO movimento (dt_movimento, dt_reg_movimento,
							vl_movimento, id_tipo_movimento, id_igreja) 
							VALUES(
							(STR_TO_DATE( '".$dti."', '%d/%m/%Y' )), 
							(STR_TO_DATE( '".$dta."', '%d/%m/%Y' )),
							'".$vlr."',
							'".$tpm."',
							'".$igj."')";
			
			$stmg = $pdo->query($sqlGravar);
			
			return true;
		//}
		
	}
	
	public function alterar($dta,$dti, 
						$tpm,$vlr,$id_movimento,$igreja) {
				
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
							
				//$datamov = strtotime(str_replace("/","",$dti));
					
					$sqlGravar = "UPDATE movimento SET
					vl_movimento='".$vlr."',
					id_tipo_movimento='".$tpm."'
					id_igreja='".$igreja."'
					where id_movimento = ".$id_movimento.";";
					
					$stmg = $pdo->query($sqlGravar);
					//var_dump($sqlGravar);
					
					return true;

				//}	
				 	
	}
	
	
}
?>
