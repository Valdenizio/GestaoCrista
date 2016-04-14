<?php
header('Content-Type: text/html; charset=ISO-8859-1', true);
abstract class CrudMembro {

	private static $instancia = null;

	private function __construct() {}

	/**
	 *
	 * @return Autenticador
	 */
	public static function instanciar() {

		if (self::$instancia == NULL) {
			self::$instancia = new ManterMembro();
		}

		return self::$instancia;

	}

	public abstract function salvar($nrlocal,$igreja,$cargo,$dtmembrecia,
						$membro,$rg,$cpf,$escolaridade,$dtnascimento,$sexo,$civil,
						$endereco,$email,$telefone,$pai,$mae,$conjugue,$homens,
						$mulher,$conversao,$lugarconv,$bataguas,$lugarbat,$ministro,
						$bates,$lugares,$nomemin,$cargoant,$datamemant,$lugarant,
						$pastor,$historico);
	public abstract function alterar($id_membro,$nrlocal,$igreja,$cargo,$dtmembrecia,
						$membro,$rg,$cpf,$escolaridade,$dtnascimento,$sexo,$civil,
						$endereco,$email,$telefone,$pai,$mae,$conjugue,$homens,
						$mulher,$conversao,$lugarconv,$bataguas,$lugarbat,$ministro,
						$bates,$lugares,$nomemin,$cargoant,$datamemant,$lugarant,
						$pastor,$historico);
	public abstract function excluir($id_membro);
	public abstract function experfil($id_membro);
	public abstract function svperfil($id_membro, $login, $senha, $id_perfil);
		
}

class ManterMembro extends CrudMembro {

	
	public function salvar($nrlocal,$igreja,$cargo,$dtmembrecia,
						$membro,$rg,$cpf,$escolaridade,$dtnascimento,$sexo,$civil,
						$endereco,$email,$telefone,$pai,$mae,$conjugue,$homens,
						$mulher,$conversao,$lugarconv,$bataguas,$lugarbat,$ministro,
						$bates,$lugares,$nomemin,$cargoant,$datamemant,$lugarant,
						$pastor,$historico) {
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sql = "select *
		from membro
		where membro.nm_membro = '{$membro}' and
		membro.dt_nascimento = '{$dtnascimento}'";
		$stm = $pdo->query($sql);
		
// 		var_dump($stm);
		
		if ($stm->rowCount() >= 1){
			return false;
		}
		else {
			$sqlGravar = "INSERT INTO MEMBRO(nm_membro, dt_nascimento, cd_sexo, cd_escolaridade, nm_pai, nm_mae, nm_conjugue,
					cd_estado_civil, nr_rg, nr_cpf, nr_filhos_homens, nr_filhos_mulheres, ds_endereco, nr_telefone, ds_email,
					nr_local, id_igreja, id_cargo, dt_membrecia, nm_antigo_minist, ds_cargo_antigo_min, dt_membrecia_antigo,
					ds_lugar_aguas, nm_pastor, ds_historico, dt_conversao, ds_lugar_conversao, dt_bat_aguas, nm_ministro, dt_bat_es,
					ds_lugar_es, ds_lugar_antigo_minist) 
					VALUES(
					'".$membro."', 
					'".$dtnascimento."',
					'".$sexo."',
					'".$escolaridade."',
					'".$pai."',
					'".$mae."',
					'".$conjugue."', 
					'".$civil."',
					'".$rg."', 
					'".$cpf."',
					'".$homens."',
					'".$mulher."',
					'".$endereco."',
					'".$telefone."',
					'".$email."',
					'".$nrlocal."',
					'".$igreja."',
					'".$cargo."',
					'".$dtmembrecia."',
					'".$nomemin."',
					'".$cargoant."',
					'".$datamemant."',
					'".$lugarbat."',
					'".$pastor."',
					'".$historico."',
					'".$conversao."',
					'".$lugarconv."',
					'".$bataguas."',
					'".$nomemin."',
					'".$bates."',
					'".$lugares."',
					'".$lugarant."')";
			
			$stmg = $pdo->query($sqlGravar);
			//var_dump($sqlGravar);
			return true;
		}
		
	}
	
	public function alterar($id_membro,$nrlocal,$igreja,$cargo,$dtmembrecia,
						$membro,$rg,$cpf,$escolaridade,$dtnascimento,$sexo,$civil,
						$endereco,$email,$telefone,$pai,$mae,$conjugue,$homens,
						$mulher,$conversao,$lugarconv,$bataguas,$lugarbat,$ministro,
						$bates,$lugares,$nomemin,$cargoant,$datamemant,$lugarant,
						$pastor,$historico) {
				
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "select *
				from membro
				where membro.id_membro like '%{$id_membro}%'";
				$stm = $pdo->query($sql);
				//var_dump($stm);
								
				if (!$stm->rowCount() >= 1){
					return false;
				}
				else {
					
					$sqlGravar = "UPDATE membro SET
					nm_membro='".$membro."',
					dt_nascimento='".$dtnascimento."',
					cd_sexo='".$sexo."',
					cd_escolaridade='".$escolaridade."',
					nm_pai='".$pai."',
					nm_mae='".$mae."',
					nm_conjugue='".$conjugue."',
					cd_estado_civil='".$civil."',
					nr_rg='".$rg."',
					nr_cpf='".$cpf."',
					nr_filhos_homens='".$homens."',
					nr_filhos_mulheres='".$mulher."',
					ds_endereco='".$endereco."',
					nr_telefone='".$telefone."',
					ds_email='".$email."',
					nr_local='".$nrlocal."',
					id_igreja='".$igreja."',
					id_cargo='".$cargo."',
					dt_membrecia='".$dtmembrecia."',
					nm_antigo_minist='".$nomemin."',
					ds_cargo_antigo_min='".$cargoant."',
					dt_membrecia_antigo='".$datamemant."',
					ds_lugar_aguas='".$lugarbat."',
					nm_pastor='".$pastor."',
					ds_historico='".$historico."',
					dt_conversao='".$conversao."',
					ds_lugar_conversao='".$lugarconv."',
					dt_bat_aguas='".$bataguas."',
					nm_ministro='".$nomemin."',
					dt_bat_es='".$bates."',
					ds_lugar_es='".$lugares."',
					ds_lugar_antigo_minist='".$lugarant."'
					where id_membro = ".$id_membro.";";
					
					$stmg = $pdo->query($sqlGravar);
					//var_dump($sqlGravar);
					
					return true;

				}	
				 	
	}
	
	public function excluir($id_membro) {
				//var_export("chamou a função");
				$id_membro=base64_decode($id_membro);
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "delete 
				from membro
				where membro.id_membro ='{$id_membro}'";
				$stm = $pdo->query($sql);
				//var_export($stm);
				return true;
				
	}
	
	public function experfil($id_membro){
				$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
				$sql = "delete
				from usuario
				where usuario.id_membro ='{$id_membro}'";
				$stm = $pdo->query($sql);
				//var_export($stm);
				return true;
	}
		
	public function svperfil($id_membro, $login, $senha, $id_perfil){
		$pdo = new PDO('mysql:host=localhost;dbname=gc;charset=latin1','root','');
		$sql = "select *
		from usuario
		where usuario.id_membro =".$id_membro.";";
		$stm = $pdo->query($sql);
		//var_dump($stm);
		
		if (!$stm->rowCount() >= 1){
			
			$sqlGravar = "INSERT INTO USUARIO(ds_login, ds_senha,
					id_membro, id_perfil)
					VALUES(
					'".$login."',
					'".$senha."',
					'".$id_membro."',
					'".$id_perfil."')";
			$stmg = $pdo->query($sqlGravar);
			//var_dump($sqlGravar);
			return true;
		}
		else {
			//var_dump("update");
			$sqlGravar = "UPDATE usuario SET
					ds_login='".$login."',
					ds_senha='".$senha."',
					id_perfil='".$id_perfil."'
					where id_membro = ".$id_membro.";";
				
			$stmg = $pdo->query($sqlGravar);
			//var_dump($stmg);
				
			return true;
		}
	
	}
}
?>
